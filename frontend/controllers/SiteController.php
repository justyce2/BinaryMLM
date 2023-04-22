<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\components\TPHelper;
use frontend\models\Profile;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use frontend\models\User;
use frontend\models\Etrans;
use yii\base\DynamicModel;
use frontend\models\UserPackage;
use frontend\models\Package;
use frontend\models\Levels;
use yii\helpers\Url;
use common\components\MLMHelper;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        MLMHelper::autoBinaryBonus();
        Yii::$app->session->set('curMain', 'dashboard');
       
       if(Yii::$app->user->identity->user_role===1) {
       	 $pack = UserPackage::findOne(['user_id'=>Yii::$app->user->identity->id]);
       	 if(($pack && $pack->payment_status='Paid') ){
       	 	 return $this->render('index');
       	 }elseif(($pack && $pack->payment_status='Pending') || (!$pack)){
       	 	 return $this->redirect('users/edit');
       	 }
       	
       }
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
       
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $this->layout='auth';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            TPHelper::newActivity('Logged in', Yii::$app->user->identity->id);
            return $this->goBack();
        }
        
        $model->password='';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionRegister() {
        if(!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        
        $this->layout='auth';
        $model = new Profile();
        $user = new SignupForm();
        
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            Yii::$app->response->format=Response::FORMAT_JSON;
            $userVal=ActiveForm::validate($user);
            $modelVal=ActiveForm::validate($model);
            $resp=array_merge($userVal, $modelVal);
            return $resp;
        }

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $connection=Yii::$app->db;
            $transaction=$connection->beginTransaction();
            
           // echo("Some Error Occur try again later..");
           // die;
            try {
                // Get placement information
                if (!empty($model->referrer) && !empty($model->position)) {
                    $posUser = Profile::findOne(['placement' => $model->referrer, 'place_position' => $model->position]);
                    if ($posUser) {
                        $getPlc = MLMHelper::getPlacementUser($posUser->user_id);
                       // $model->placement = $getPlc['placement'];
                        //$model->place_position = $getPlc['position'];
                         $model->place_position = $model->position;
                        
                        $model->placement = 0;
                
                    }
                    else {
                        //$model->placement = $model->referrer;
                        $model->placement = 0;
                        $model->place_position = $model->position;
                        
                        
                      
                    }
                }
                
                $user_created=$user->signup() ? true : false;
                $uInfo=User::findOne(['username' => $user->username]);
                $model->user_id=$uInfo->id;
                
                $profile_created=$model->save() ? true : false;
                if($user_created && $profile_created) {
                    $transaction->commit();
                    TPHelper::newActivity('Joined in this site', $uInfo->id);
                    Yii::$app->session->set('user_id', $model->user_id);
                    Yii::$app->session->set('pack_id', $model->pack_id);
                    return $this->redirect(['choosegateway']);
                }
                else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error while doing registration. Please try again later!');
                }
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        
        $permalink = Yii::$app->request->get('permalink');
        if($permalink) {
            $model->referrer = $permalink;
        }

        return $this->render('register', [
            'model' => $model,
            'user' => $user
        ]);
    }
    
    public function actionChoosegateway() {
        $this->layout='auth';
       //  echo("Some Error Occur try again later..");
        //    die;
        $user_id=Yii::$app->session->get('user_id');
        $pack_id=Yii::$app->session->get('pack_id');
        if($user_id=='' || $pack_id=='') {
            Yii::$app->session->setFlash('error', 'Invalid request!');
            return $this->redirect(['register']);
        }
        
        $model=new DynamicModel(['pmethod']);
        if($model->load(Yii::$app->request->post())) {
            $postdata=Yii::$app->request->post('DynamicModel');
            $pmethod=!empty($postdata['pmethod'])?$postdata['pmethod']:'Bank';
            $upack=new UserPackage();
            $upack->user_id=$user_id;
            $upack->pack_id=$pack_id;
            $upack->purchased_at=time(); 
           
            $upack->payment_mode=$pmethod;
            $upack->payment_status='Pending';
             $upack->transaction_ref= time();
            if($upack->save()) {
                if($pmethod=='Cash' Or $pmethod=='Bank') {
                    Yii::$app->session->setFlash('success', 'You have chosen to pay via Cash or Bank. Your account will be activated once we have received your cheque!');
                    return $this->redirect(['login']);
                }
                else {
                	$userinfo = Profile::findOne(['user_id' => $user_id]);
                	$userinfoe = User::findOne($user_id);
                	
                    $pInfo=Package::findOne($pack_id);
                    //$params['tx_ref']=$upack->id;
                    $transaction_ref = $upack->id.'a'.rand(100000,1000000);
                     $upackInfo=UserPackage::findOne($upack->id);
                      $upackInfo->transaction_ref=$transaction_ref;
                      $upackInfo->save();
                    $params['tx_ref']=$transaction_ref;
                  //$params['amount']=$pInfo->amount + 100;
                  $params['amount']=10000 + 50;
                  
                  
                 // $params['subaccounts']['id']='RS_39B8273357B7ABD55BD4AACD914E205E';
                  //$params['subaccounts'][] = array('id'=>'RS_39B8273357B7ABD55BD4AACD914E205E');
                   // $params['amount']=3000;
                   // $params['description']='Membership Payment #'.$user_id;
                    $params['currency']='NGN';
                    $params['redirect_url']=Url::to(['site/payresponse', 'upackId' => $upack->id], true);
                 // $params['payment_options']=array("card","ussd","bank");
                    $params['meta']['consumer_id']=$upack->id;
                    $params['customer']['email']=$userinfoe->email;
                    $params['customer']['phonenumber']=$userinfo->mobile_no;
                    $params['customer']['name']=$userinfo->first_name.' '.$userinfo->last_name;
                    $params['customizations']['title']='I Stand With Jesus';
                    $params['customizations']['description']='Membership Payment #'.$user_id;
                    $params['customizations']['logo']='https://istandwithjesus.org.ng/img/logo.png';
                   // $params['return_url']=Url::to(['site/payresponse', 'upackId' => $upack->id], true);
                    
                    
                   // $json=Yii::$app->paypal->execPayment($params);
                   // $response=json_decode($json, true);
                   
                  
                  // 
                  $this->actionPayflutter($params);
                  
                  
                  
                  
                    //return $this->redirect('payflutter');
                }
            }
        }
        
        return $this->render('gateway', [
            'model' => $model
        ]);
    }
    public function actionSendSmsm($phone){
        
       
$smsparams['to']= $phone;
$smsparams['sender']= 'iStandWithJ';
$smsparams['token']= '';
$smsparams['message']= 'You have now registered with I stand with Jesus, Kindly proceed to register you 2 persons. thank you';
$smsparams['type']= '0';
$smsparams['routing']= '3';



$postdata = json_encode($smsparams);
 $url = 'https://app.smartsmssolutions.com/io/api/client/v1/sms/';
$ch = curl_init($url); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

$response = curl_exec($ch);
curl_close($ch);

return;
    }
    
    public function actionPayflutter($params=array()){
    		$curl = curl_init();
  $url = 'https://api.flutterwave.com/v3/payments';
  
$postdata = json_encode($params);
 
$ch = curl_init($url); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
    "Authorization: Bearer FLWSECK-6438bc678581e5b6fd7b655e471d5065-X"
));
$response = curl_exec($ch);
curl_close($ch);

    
    
   // echo($response);
  //  echo($response['status']);
    $response = json_decode($response);
    if($response != NULL){
     if($response->status=='success'){
    	$link = $response->data->link;
    	return $this->redirect($link);
    }else{
    	 Yii::$app->session->setFlash('error', 'Invalid request!');
            return $this->redirect(['choosegateway']);
    	
    }	
    }else{
     Yii::$app->session->setFlash('error', 'Invalid request!');
            return $this->redirect(['choosegateway']);	
    }
    //$status  = $response->status ;
   
    }
    
    public function actionPayresponse() {
        
        
        if(Yii::$app->request->get('data')  && Yii::$app->request->get('event') )
        {
        $txnidwebhook=Yii::$app->request->get('data');
        $txnid = $txnidwebhook->id;
        $txnref = $txnidwebhook->tx_ref;
        $status = $txnidwebhook->status;
        
        
        }else if(Yii::$app->request->get('tx_ref')){
        	$txnid = Yii::$app->request->get('transaction_id');
        	//print_r($txnid);
        	//die;
        	$txnref = Yii::$app->request->get('tx_ref');
        	$status = Yii::$app->request->get('status');
        	 
        }else{
            
        	 Yii::$app->session->setFlash('error', 'Transaction has been canceled. Account will be inactive until you complete the payment.....!');
          
        }
        
        if(!empty($txnid) && $status == 'successful'){
        	
        		$curl = curl_init();
			  
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$txnid."/verify",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/json",
			    "Authorization: Bearer FLWSECK-6438bc678581e5b6fd7b655e471d5065-X"
			  ),
			));


			$response = curl_exec($curl);



			curl_close($curl);
			 $response = json_decode($response);
			 
			// print_r($response);
			// die;
   			 $status  = $response->status ;
		//	$customer_id =	Yii::$app->request->get('meta')->consumer_id;
		  
        	  
			if($status == 'success' ){
				//$upackId=$txnref;
				$consumer_id= explode("a",$txnref);
				$upackId=$consumer_id[0];
        if($upackId) {
            $upackInfo=UserPackage::findOne($upackId);
            $pInfo = Profile::findOne(['user_id' => $upackInfo->user_id]);
            $upackInfo->purchased_at=time();
            $upackInfo->payment_status='Paid';
            $upackInfo->save();
            
            
            $posUser = Profile::findOne(['placement' => $pInfo->referrer, 'place_position' => $pInfo->position]);
            // $placement = $pInfo->placement;
              if( $pInfo->placement==0){
                  
                   if ($posUser) {
                  
                $this->getPlacementUser($posUser->user_id, $upackInfo->user_id);
                      
                    }
                    else {
                        $pInfo->placement = $pInfo->referrer;
                        $pInfo->place_position = $pInfo->position;
                       //  $pInfo->cur_pv += $upackInfo->pack->point_volume;
                        $pInfo->save();
                    }
              }
            
             $pInfoss = Profile::findOne(['user_id' => $upackInfo->user_id]);
             $placement = $pInfoss->placement;
             
              $this->actionLevelcompletd($placement);
              
            
             Yii::$app->session->setFlash('success', 'Transaction has been completed. Account is active now!');
            // $this->actionLevelcompleted($placement);
             $lin = 'https://istandwithjesus.org.ng/mem/tp/levelcompleted?id='.$placement;
            return $this->redirect($lin);
           
        				}
			}else{
				 Yii::$app->session->setFlash('error', 'Transaction has been canceled. Account will be inactive until you complete the payment..l.!');
			}
        }else{
            Yii::$app->session->setFlash('error', 'Transaction has been canceled. Account will be inactive until you complete the payment..k.!');
          
        }
        
        // process data based on status
        
        return $this->redirect(['login']);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function  actionUpdateallmembers(){
         // $pInfooo = Profile::findAll(['blockchain_address' => NULL]);
          
        $pInfooo =    Profile::find()
    //->where(['blockchain_address' => NULL])
    //->orderBy('user_id DESC')
    ->orderBy('user_id ASC')
    ->all();
           Foreach($pInfooo As $pInfos){
          // echo $pInfos->user_id."<br />";
    	 
    $pInfo = Profile::findOne(['user_id' =>  $pInfos->user_id]);
    	$pInfo2 = UserPackage::findOne(['user_id' => $pInfos->user_id, 'payment_status'=>'Paid']);
    $id  = $pInfos->user_id;
     if($pInfo){
         $pInfor = Profile::findOne(['user_id' =>  $id]);	
    	$pInfo2 = UserPackage::findOne(['user_id' => $id]);
    	$totPack = Package::find()->all();
    	$totPack =  count($totPack);
       	$upline_id = $pInfo->placement;
        $level = $pInfo->pack_id ;
   		 $packInfo = Package::findOne($level);
    	 $count =  Levels::findAll(['upline_id' => $id, 'level'=> $level]);
    	 if(count($count)>1  && $level < $totPack){
    	     $count2 =  Levels::findAll(['user_id' => $id,'upline_id'=>$upline_id ,'level'=> $level+1]);
    	     if(count($count2)==0){
    	 		$pLevels = New Levels();
        	 	$pLevels->user_id = $id;
        	 	$pLevels->upline_id =$upline_id;
        	 	$pLevels->level =$level +1;
        	 	$pLevels->time =time();
        	 	$pLevels->save();
        	 	
        	 	$pInfo->pack_id = $level +1;
        	 	$pInfo->save();
        	 	
        	 	$pInfo2->pack_id = $level +1;
        	 	$pInfo2->save();
        	 	  
        	 	
        	 	if ($packInfo['amount'] > 1) {
        	 	  //  $hasRef = Profile::findOne(['referrer' => $id]);
        	 	   // $hasRef = count($hasRef);
        	 	   $iseligible = TRUE;
        	 	   
        	 	}
        	 	    /**if($packInfo['amount'] == 15000 && !$hasRef){
        	 	    $iseligible = FALSE;	
        	 	    } **/
        	 //	 die;
        	 if($iseligible){
            $etrans = New Etrans();
            $etrans->trans_from = 1;
            $etrans->trans_to = $id;
            $etrans->amount = $packInfo->amount;
            $etrans->type = 'credit';
            $etrans->reason = 'Level Completed';
            $etrans->status = 'Approved';
            $etrans->date = time();
            
           
            $etrans->save();
            TPHelper::updateUserWallet($id, $packInfo->amount);
            
        	 }
        	 
        	 	}	
        }
    	 	
    	 }
    	 
		}
         
           
         
     
      echo 'process completed';
      die;
     }
     public function  actionUpdateallmemberstwo(){
         // $pInfooo = Profile::findAll(['blockchain_address' => NULL]);
          
        $pInfooo =    Profile::find()
    //->where(['blockchain_address' => NULL])
    ->orderBy('user_id DESC')
   // ->orderBy('user_id ASC')
    ->all();
           Foreach($pInfooo As $pInfos){
           
    	 
    $pInfo = Profile::findOne(['user_id' =>  $pInfos->user_id]);
    	$pInfo2 = UserPackage::findOne(['user_id' => $pInfos->user_id, 'payment_status'=>'Paid']);
    $id  = $pInfos->user_id;
     if($pInfo){
         $pInfor = Profile::findOne(['user_id' =>  $id]);	
    	$pInfo2 = UserPackage::findOne(['user_id' => $id]);
    	$totPack = Package::find()->all();
    	$totPack =  count($totPack);
       	$upline_id = $pInfo->placement;
        $level = $pInfo->pack_id ;
   		 $packInfo = Package::findOne($level);
    	 $count =  Levels::findAll(['upline_id' => $id, 'level'=> $level]);
    	 if(count($count)>1  && $level < $totPack){
    	     $count2 =  Levels::findAll(['user_id' => $id,'upline_id'=>$upline_id ,'level'=> $level+1]);
    	     if(count($count2)==0){
    	 		$pLevels = New Levels();
        	 	$pLevels->user_id = $id;
        	 	$pLevels->upline_id =$upline_id;
        	 	$pLevels->level =$level +1;
        	 	$pLevels->time =time();
        	 	$pLevels->save();
        	 	
        	 	$pInfo->pack_id = $level +1;
        	 	$pInfo->save();
        	 	
        	 	$pInfo2->pack_id = $level +1;
        	 	$pInfo2->save();
        	 	  
        	 	
        	 	if ($packInfo['amount'] > 1) {
        	 	    $hasRef = Profile::findOne(['referrer' => $id]);
        	 	   // $hasRef = count($hasRef);
        	 	   $iseligible = TRUE;
        	 	    if($packInfo['amount'] == 15000 && !$hasRef){
        	 	    $iseligible = TRUE;	
        	 	    } 
        	 //	 die;
        	 if($iseligible){
            $etrans = New Etrans();
            $etrans->trans_from = 1;
            $etrans->trans_to = $id;
            $etrans->amount = $packInfo->amount;
            $etrans->type = 'credit';
            $etrans->reason = 'Level Completed';
            $etrans->status = 'Approved';
            $etrans->date = time();
            
           
            $etrans->save();
            TPHelper::updateUserWallet($id, $packInfo->amount);
            
        	 }
        	 
        	 	}	
        }
    	 	
    	 }
    	 
		}
         
           }
         
     
      echo 'process completed';
      die;
     }
     
   
     
     
     
     public function  actionUpdateallmemberslevels(){
             	
    $pInfooo = Profile::findAll(['blockchain_address' => NULL]);
   // $pInfooo = Profile::findAll();
   
     Foreach($pInfooo As $pInfos){
           
    	 
    $pInfo = Profile::findOne(['user_id' =>  $pInfos->user_id]);
    	$pInfo2 = UserPackage::findOne(['user_id' => $pInfos->user_id, 'payment_status'=>'Paid']);
    
     if($pInfo){
     	$upline_id =  $pInfo->placement;
     	
     	$levl = $pInfo->pack_id ;
   		   $packInfo = Package::findOne($levl);
    // $level = $pInfo->pack_id  +1;
     $level = 2;
        $count =  Profile::findAll(['placement' => $pInfos->user_id]);
      // $cur_lee =  Levels::findAll(['user_id' => $pInfos->user_id]);
        
     /**  if($cur_lee){
        foreach($cur_lee As $cur_lees){
            
            $ccc[] .= $cur_lees->level;
             
          
        }
        $level=  max($ccc); 
        $ccc  = '';
       }     */
        if(count($count) > 1  && $pInfo2){
            
           
        	
        	$count2 = Levels::findAll(['user_id' => $pInfos->user_id, 'level'=> $level]);
       	
        	
        	 if(count($count2) == 0){
        	     	
        	 	$pLevels = New Levels();
        	 	$pLevels->user_id = $pInfos->user_id;
        	 	$pLevels->upline_id =$upline_id;
        	 	$pLevels->level =$level;
        	 	$pLevels->time =time();
        	 	$pLevels->save();
        	 	/// intert levels
        	 	
        	 
        	 	$pInfo->pack_id = $level ;
        	  	$pInfo->save();
        	 	
        	 	$pInfo2->pack_id = $level ;
        	 	$pInfo2->save();
        	 	
        		 if($packInfo->amount > 0){
            $etrans = New Etrans();
            $etrans->trans_from = 1;
            $etrans->trans_to = $id;
            $etrans->amount = $packInfo->amount;
            $etrans->type = 'credit';
            $etrans->reason = 'Level Completed';
            $etrans->status = 'Approved';
            $etrans->date = time();
            
           
            $etrans->save();
            TPHelper::updateUserWallet($id, $packInfo->amount);
        	 }
        	 
        	 }
        	
        }  
        //	$this->actionUplineCompleted($upline_id);
		}
         
     }
       
      echo 'process completed';
      die;
     }
    public  function getPlacementUser($tpUsr,  $tpId) {
        
       
        $nxtUsers = [];
        $dataFound = false;
        $tpUsers = Profile::find()->joinWith(['user'])->where(['user_id' => $tpUsr])->all();
        foreach ($tpUsers as $usrInfo) {
            $posLeft = Profile::findOne(['placement' => $usrInfo->user_id, 'place_position' => 'Left']);
            
             
                                
            if (!$posLeft) {
                $data = ['placement' => $usrInfo->user_id, 'username' => $usrInfo->user->username, 'position' => 'Left'];
                $dataFound = true;
                break;
            }
            else {
                $posRight = Profile::findOne(['placement' => $usrInfo->user_id, 'place_position' => 'Right']);
                if (!$posRight) {
                    $data = ['placement' => $usrInfo->user_id, 'username' => $usrInfo->user->username, 'position' => 'Right'];
                    $dataFound = true;
                    break;
                }
                else {
                    $nxtUsers[] = $posLeft->user_id;
                    $nxtUsers[] = $posRight->user_id;
                    continue;
                }
            }
        }
       if($dataFound ) {
            
            $pInfo = Profile::findOne(['user_id' => $tpId]);
             
            if($pInfo){
               $pInfo->placement = $data['placement'];
               
              
                        
            $pInfo->place_position = $data['position']; 
            $pInfo->save();
            }
            
            return $data;
        }
        else {
            self::getPlacementUser($nxtUsers, $tpId);
        }
    }
    
    /**
     * Techplait © 2019
     */
    public function actionLevelcompleted($id){
        
    	
    $pInfo = Profile::findOne(['user_id' => $id]);
    	$pInfo2 = UserPackage::findOne(['user_id' => $id]);
    
     if($pInfo){
     	$upline_id =  $pInfo->placement;
     		$levl = $pInfo->pack_id ;
   		   $packInfo = Package::findOne($levl);
    // $level = $pInfo->pack_id  +1;
     $level = 2;
        $count =  Profile::findAll(['placement' => $id]);
        
        //echo(count($count));
        //die;
        if(count($count) > 1){
        	
        	$count2 = Levels::findAll(['user_id' => $id, 'level'=> $level]);
       	
        	
        	 if(count($count2) == 0){
        	     	
        	 	$pLevels = New Levels();
        	 	$pLevels->user_id = $id;
        	 	$pLevels->upline_id =$upline_id;
        	 	$pLevels->level =$level;
        	 	$pLevels->time =time();
        	 	$pLevels->save();
        	 	/// intert levels
        	 	
        	 	
        	 	$pInfo->pack_id = $level ;
        	  	$pInfo->save();
        	 	
        	 	$pInfo2->pack_id = $level ;
        	 	$pInfo2->save();
        	 	
        	 	
        	 	
        	 if($packInfo->amount > 0){
            $etrans = New Etrans();
            $etrans->trans_from = 1;
            $etrans->trans_to = $id;
            $etrans->amount = $packInfo->amount;
            $etrans->type = 'credit';
            $etrans->reason = 'Level Completed';
            $etrans->status = 'Approved';
            $etrans->date = time();
            
           
            $etrans->save();
            TPHelper::updateUserWallet($id, $packInfo->amount);
        	 }
        	 
        	 }
        	
        }
        	$this->actionUplineCompleted($upline_id);
		}
		return $this->redirect(['login']);
    }
    
     public function actionLevelcompletd($id){
        
    	
    $pInfo = Profile::findOne(['user_id' => $id]);
    	$pInfo2 = UserPackage::findOne(['user_id' => $id]);
    
     if($pInfo){
     	$upline_id =  $pInfo->placement;
     		$levl = $pInfo->pack_id ;
   		   $packInfo = Package::findOne($levl); 
    // $level = $pInfo->pack_id  +1;
     $level = 2;
        $count =  Profile::findAll(['placement' => $id]);
        
        //echo(count($count));
        //die;
        if(count($count) > 1){
        	
        	$count2 = Levels::findAll(['user_id' => $id, 'level'=> $level]);
       	
        	
        	 if(count($count2) == 0){
        	     	
        	 	$pLevels = New Levels();
        	 	$pLevels->user_id = $id;
        	 	$pLevels->upline_id =$upline_id;
        	 	$pLevels->level =$level;
        	 	$pLevels->time =time();
        	 	$pLevels->save();
        	 	/// intert levels
        	 	
        	 	
        	 	$pInfo->pack_id = $level ;
        	  	$pInfo->save();
        	 	
        	 	$pInfo2->pack_id = $level ;
        	 	$pInfo2->save();
        	 	
        	 if($packInfo->amount > 0){
            $etrans = New Etrans();
            $etrans->trans_from = 1;
            $etrans->trans_to = $id;
            $etrans->amount = $packInfo->amount;
            $etrans->type = 'credit';
            $etrans->reason = 'Level Completed';
            $etrans->status = 'Approved';
            $etrans->date = time();
            
           
            $etrans->save();
            TPHelper::updateUserWallet($id, $packInfo->amount);
            
        	 }
        	 
        	 }
        	
        }
        	$this->actionUplineCompleted($upline_id);
		}
	//	return $this->redirect(['login']);
    }
    
    public function actionUplineCompleted($id){
    	//$user_id = $id;
    
    	$pInfo = Profile::findOne(['user_id' => $id]);
    	if($pInfo){
    	$pInfo2 = UserPackage::findOne(['user_id' => $id]);
    	$totPack = Package::find()->all();
    	$totPack =  count($totPack);
       	$upline_id = $pInfo->placement;
        $level = $pInfo->pack_id ;
   		 $packInfo = Package::findOne($level);
    	 $count =  Levels::findAll(['upline_id' => $id, 'level'=> $level]);
    	 if(count($count)>1  && $level < $totPack){
    	     $count2 =  Levels::findAll(['user_id' => $id,'upline_id'=>$upline_id ,'level'=> $level+1]);
    	     if(count($count2)==0){
    	 		$pLevels = New Levels();
        	 	$pLevels->user_id = $id;
        	 	$pLevels->upline_id =$upline_id;
        	 	$pLevels->level =$level +1;
        	 	$pLevels->time =time();
        	 	$pLevels->save();
        	 	
        	 	$pInfo->pack_id = $level +1;
        	 	$pInfo->save();
        	 	
        	 	$pInfo2->pack_id = $level +1;
        	 	$pInfo2->save();
        	 	  
        	 	
        	 	if ($packInfo['amount'] > 1) {
        	 	    $hasRef = Profile::findOne(['referrer' => $id]);
        	 	   // $hasRef = count($hasRef);
        	 	   $iseligible = TRUE;
        	 	    if($packInfo['amount'] == 15000 && !$hasRef){
        	 	    $iseligible = TRUE;	
        	 	    } 
        	 //	 die;
        	 if($iseligible){
            $etrans = New Etrans();
            $etrans->trans_from = 1;
            $etrans->trans_to = $id;
            $etrans->amount = $packInfo->amount;
            $etrans->type = 'credit';
            $etrans->reason = 'Level Completed';
            $etrans->status = 'Approved';
            $etrans->date = time();
            
           
            $etrans->save();
            TPHelper::updateUserWallet($id, $packInfo->amount);
            
        	 }
        	 
        	 	}	
        }
    	 	
    	 }
    	 $this->actionUplineCompleted($upline_id);
		}
    }
 /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        TPHelper::newActivity('Logged out', Yii::$app->user->identity->id);
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $this->layout='auth';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
