<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\base\DynamicModel;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\Profile;
use frontend\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\SignupForm;
use frontend\models\User;
use frontend\models\UserPackage;
use frontend\models\Package;
use frontend\models\Levels;
use frontend\models\Etrans;
use common\components\TPHelper;
use common\components\MLMHelper;
use yii\filters\AccessControl;
use yii\web\IdentityInterface;
use common\models\LoginForm;

/**
 * UsersController implements the CRUD actions for Profile model.
 */
class UsersController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['choosegateway', 'payresponse', 'completetrans', 'approvechq', 'transpass','updatepayout','verifyflutter', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['profile', 'edit', 'mylist'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->user_role===1) {
                                return true;
                            }
                            return false;
                        }
                    ],
                    [
                        'actions' => ['index', 'view', 'update', 'delete','login'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->user_role===2) {
                                return true;
                            }
                            return false;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex() {
        Yii::$app->session->set('curMain', 'usermanage');
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionLogin($username) {
    	
    	//print_r($username);
    	//die;
        $user =   $pInfo = User::findOne(['username' => $username]);
        $authkey = $user->auth_key;
        $model = new LoginForm();
       
    if (Yii::$app->user->identity->user_role==2  && $model->logins($username)) {
        	 TPHelper::newActivity('Logged in', Yii::$app->user->identity->id);
          
          // Yii::$app->user->login($username);
            return $this->goBack();
        
           
        }
        
       
    }
public function actionMylist() {
        Yii::$app->session->set('curMain', 'usermanage');
        $searchModel = new ProfileSearch();
     
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('mylist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        Yii::$app->session->set('curMain', 'usermanage');
        
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]); 
        }
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        Yii::$app->session->set('curMain', 'newuser');
        $model = new Profile();
        $user = new SignupForm();
        // echo("Some Error Occur try again later..");
        //    die;
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
            try {
                // Get placement information
                if (!empty($model->referrer) && !empty($model->position)) {
                    $posUser = Profile::findOne(['placement' => $model->referrer, 'place_position' => $model->position]);
                    if ($posUser) {
                        $getPlc = MLMHelper::getPlacementUser($posUser->user_id);
                       // $model->placement = $getPlc['placement'];
                       // $model->place_position = $getPlc['position'];
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
                    TPHelper::newActivity('Created new user ('.$uInfo->username.')', Yii::$app->user->identity->id);
                    Yii::$app->session->set('user_id', $model->user_id);
                    Yii::$app->session->set('pack_id', $model->pack_id);
                    return $this->redirect(['choosegateway']);
                }
                else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Cannot update user. Please try again later!');
                }
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'user' => $user
        ]);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        Yii::$app->session->set('curMain', 'usermanage');
        $model=$this->findModel($id);
        $user=$this->userModel($model->user_id);
        
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            Yii::$app->response->format=Response::FORMAT_JSON;
            $userVal=ActiveForm::validate($user);
            $modelVal=ActiveForm::validate($model);
            $resp=array_merge($userVal, $modelVal);
            return $resp;
        }
        
        if($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $connection=Yii::$app->db;
            $transaction=$connection->beginTransaction();
            try {
                if(!empty($user->password)) $user->password_hash=Yii::$app->security->generatePasswordHash($user->password);
                $user_updated=$user->save(false) ? true : false;
                $profile_updated=$model->save(false) ? true : false;
                if($user_updated && $profile_updated) {
                    $transaction->commit();
                    
                    $pack = UserPackage::findOne(['user_id'=> $user->id]);
                    if($pack){
                    	if($pack->payment_status == 'Pending'){
                    		Yii::$app->session->set('user_id', $pack->user_id);
                    Yii::$app->session->set('pack_id', $pack->pack_id);
                    return $this->redirect(['choosegateway']);
                    	}
                    }else{
                    	
                    Yii::$app->session->set('user_id', $user->id);
                    Yii::$app->session->set('pack_id', 1);
                    return $this->redirect(['choosegateway']);
                    }
                    
                    Yii::$app->session->setFlash('success', 'User has been updated!');
                    return $this->redirect(['index']);
                }
                else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Can\'t update user. Please try again later!');
                }
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user
        ]);
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function userModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    /**
     * Provides option to choose payment gateway for user.
     */
    public function actionChoosegateway() {
        $user_id=Yii::$app->session->get('user_id');
        $pack_id=Yii::$app->session->get('pack_id');
         //echo("Some Error Occur try again later..");
         //   die;
        if($user_id=='' || $pack_id=='') {
            Yii::$app->session->setFlash('error', 'Invalid request!');
            
            return $this->redirect(['users/index']);
        }
        
        $model=new DynamicModel(['pmethod']);
        if($model->load(Yii::$app->request->post())) {
            $postdata=Yii::$app->request->post('DynamicModel');
            $pmethod=!empty($postdata['pmethod'])?$postdata['pmethod']:'Bank';
            $upack=new UserPackage();
            $upack->user_id=$user_id;
            $upack->pack_id=$pack_id;
            $upack->purchased_at=time();
             $upack->transaction_ref= time();
            $upack->payment_mode=$pmethod;
            $upack->payment_status='Pending';
           
            if($upack->save()) {
                
                if($pmethod=='Cash' OR $pmethod=='Bank') {
                    Yii::$app->session->setFlash('success', 'You have chosen to pay via Cash tranfer or Bank. Your account will be activated once we have received your cheque!');
                     if (Yii::$app->user->identity->user_role===2) {
                           return $this->redirect(['users/index']);
                            }else{
                            return $this->redirect(['users/mylist']);	
                            }
                   
                }
                else {
                    $userinfo = Profile::findOne(['user_id' => $user_id]);
                	$userinfoe = User::findOne($user_id);
                    $pInfo=Package::findOne($pack_id);
                    $transaction_ref = $upack->id.'a'.rand(100000,1000000);
                     $upackInfo=UserPackage::findOne($upack->id);
                      $upackInfo->transaction_ref=$transaction_ref;
                      $upackInfo->save();
                    $params['tx_ref']=$transaction_ref;
                   
                   // $params['tx_ref']=1234567890;
                  //  $params['amount']=$pInfo->amount;
                   // $params['amount']=3000;
                   // $params['amount']=$pInfo->amount + 100;
                    $params['amount']=10050;
                    //$params['subaccounts'][] = array('id'=>'RS_39B8273357B7ABD55BD4AACD914E205E');
                   // $params['description']='Membership Payment #'.$user_id;
                    $params['currency']='NGN';
                    $params['redirect_url']=Url::to(['users/payresponse', 'upackId' => $upack->id], true);
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
                 // $allpara = http_build_query($params);
                  
                //  $link = "https://checkout.flutterwave.com/v3/hosted/pay?".$allpara;
                  
                 // print_r($link);
                //  die;
    //	return $this->redirect($link);
                 
                  $this->actionPayflutter($params);
                }
            }
        }
        
        return $this->render('gateway', [
            'model' => $model
        ]);
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
        // Get payment status
        
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
        	 Yii::$app->session->setFlash('error', 'Transaction has been canceled. Account will be inactive until you complete the payment!');
          
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
			 
			 
   			 $status  = $response->status ;
			
			if($status == 'success' ){
			//	$upackId=$txnref; 
					//$upackId=$customer_id; 
						$consumer_id= explode("a",$txnref);
				$upackId=$consumer_id[0];
        if($upackId) {
            $upackInfo=UserPackage::findOne($upackId);
            $upackInfo->purchased_at=time();
            $upackInfo->payment_status='Paid';
            $upackInfo->save();
            
            $pInfo = Profile::findOne(['user_id' => $upackInfo->user_id]);
            $posUser = Profile::findOne(['placement' => $pInfo->referrer, 'place_position' => $pInfo->position]);
             $placement = $pInfo->placement;
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
             //print_r($upackInfo->user_id);
             //die;
               $this->actionLevelCompleted($placement);
            
             Yii::$app->session->setFlash('success', 'Transaction has been completed. Account is active now!');
           
        				}
			}else{
				 Yii::$app->session->setFlash('error', 'Transaction has been canceled. Account will be inactive until you complete the payment!');
			}
        }else{
            Yii::$app->session->setFlash('error', 'Transaction has been canceled. Account will be inactive until you complete the payment!');
          
        }
        
        // process data based on status
        
      $redirect_uri=(Yii::$app->user->identity->user_role===1) ? ['users/profile'] : ['users/index'] ;
        return $this->redirect($redirect_uri);
    }
        
    
    
    public function actionCompletetrans() {
        $upack_id=Yii::$app->request->post('upack_id');
        $upackInfo=UserPackage::findOne($upack_id);
        if($upackInfo) {
            $pInfo=Package::findOne($upackInfo->pack_id);
           // $params['amount']=$pInfo->amount;
            $params['amount']=10000;
            $params['description']='Membership Payment #'.$upackInfo->user_id;
            $params['return_url']=Url::to(['users/payresponse', 'upackId' => $upackInfo->id], true);
            $json=Yii::$app->paypal->execPayment($params);
            $response=json_decode($json, true);
            return $this->redirect($response['links'][1]['href']);
        }
        else {
            Yii::$app->session->setFlash('error', 'Something went wrong. Please try agian later!');
            return $this->redirect(['users/index']);
        }
    }
    
    public function actionApprovechq($id) {
     //  $this->actionUpdatePayout();
        
        $upackInfo=UserPackage::find()->joinWith(['pack'])->where(['user_package.id' => $id])->one();
        if($upackInfo) {
            
           
            $pInfo = Profile::findOne(['user_id' => $upackInfo->user_id]);
             //$placement = $pInfo->placement;
              $posUser = Profile::findOne(['placement' => $pInfo->referrer, 'place_position' => $pInfo->position]);
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
              
             
           
            
            
            // update upack table
            $upackInfo->purchased_at=time();
            $upackInfo->payment_status='Paid';
            $upackInfo->save();
         
            MLMHelper::sendCommission($id); // sends commission to the upline users
            
            Yii::$app->session->setFlash('success', 'Payment Approved! Commission has been distributed!'); 
            $pInfoss = Profile::findOne(['user_id' => $upackInfo->user_id]);
             $placement = $pInfoss->placement;
               $this->actionLevelCompleted($placement);
            
        }
        if(Yii::$app->user->identity->user_role===1){
        return $this->redirect(['organization/genealogy']);    
        }else{
        return $this->redirect(['users/index']);    
        }
        
    }
    
    
     public function actionVerifyflutter($txnref) {
        // Get payment status
       
        if(!empty($txnref)){
        	
        		$curl = curl_init();
			  
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref=".$txnref,
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
			 
			 //print_r($response);
			 //die;
   			 $status  = $response->status ;
   			 
   			 if($status == 'success' ){
			//	$upackId=$txnref; 
					//$upackId=$customer_id; 
						$consumer_id= explode("a",$txnref);
				$upackId=$consumer_id[0];
        if($upackId) {
            $upackInfo=UserPackage::findOne($upackId);
            $upackInfo->purchased_at=time();
            $upackInfo->payment_status='Paid';
            $upackInfo->save();
            
            $pInfo = Profile::findOne(['user_id' => $upackInfo->user_id]);
            $posUser = Profile::findOne(['placement' => $pInfo->referrer, 'place_position' => $pInfo->position]);
             $placement = $pInfo->placement;
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
             //print_r($upackInfo->user_id);
             //die;
               $this->actionLevelCompleted($placement);
            
             Yii::$app->session->setFlash('success', 'Transaction has been completed. Account is active now!');
           
        				}
			}else{
				 Yii::$app->session->setFlash('error', 'Transaction not recieved. Account will be inactive until you complete the payment!');
			}
        }else{
            Yii::$app->session->setFlash('error', 'Transaction not recieved. Account will be inactive until you complete the payment!');
          
        }
        
        // process data based on status
        
      //$redirect_uri=(Yii::$app->user->identity->user_role===1) ? ['users/profile'] : ['users/index'] ;
        return $this->redirect(['users/index']);
			
	}
    
    
    
    /**
     * Spillover Method for Auto placement
     * Techplait © 2019
     */
     
     
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
    
   
    
       public function actionUpdatepayout() {
      // $pInfooo = Profile::findAll(['blockchain_address' => NULL]);
      //die;
        $pInfooo =    Profile::find()
    //->where(['blockchain_address' => NULL])
    //->orderBy('user_id DESC')
    ->orderBy('user_id DESC')
    ->all();
           Foreach($pInfooo As $pInfos){
          // echo $pInfos->user_id."<br />";
    	 
    $pInfo = Profile::findOne(['user_id' =>  $pInfos->user_id]);
    	$pInfo2 = UserPackage::findOne(['user_id' => $pInfos->user_id, 'payment_status'=>'Paid']);
    $id  = $pInfos->user_id;
     if($pInfo){
     	
     	if($pInfo->pack_id > 1){
     		$level= 1;
     		$packInfo = Package::findOne($level);
     		$fee = $packInfo['amount'];
     		$payout = Etrans::findOne(['trans_to' => $id, 'amount'=> $fee]);
     	$user = User::findOne($id);
     		if(!$payout){
     			echo $id.'< br/>';
     			echo $user->username.'<br>';
     			
     			$etrans = New Etrans();
            $etrans->trans_from = 1;
            $etrans->trans_to = $id;
            $etrans->amount = $fee;
            $etrans->type = 'credit';
            $etrans->reason = 'Level Completed for level '. $level;
            $etrans->status = 'Approved';
            $etrans->date = time();
            
           
            $etrans->save();
            TPHelper::updateUserWallet($id, $fee);
     			
     		}
     		
     		
     		
     	}
     	
     	
	}
	
}
  
    Yii::$app->session->setFlash('success', 'Payout Updated! Commission has been distributed!'); 
            
        return $this->redirect(['users/index']);   	  
        
    }
    
     
     
    
    /**
     * Techplait © 2019
     */
    public function actionLevelCompleted($id){
    	
    $pInfo = Profile::findOne(['user_id' => $id]);
    	$pInfo2 = UserPackage::findOne(['user_id' => $id]);
    
     if($pInfo){
     	$upline_id =  $pInfo->placement;
     		$levl = $pInfo->pack_id ;
   		   $packInfo = Package::findOne($levl);
    // $level = $pInfo->pack_id  +1;
     $level = 2;
        $count =  Profile::findAll(['placement' => $id]);
        
        
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
        	 	    if($packInfo['amount'] == 20000 && !$hasRef){
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
    	 $this->actionUplineCompleted($upline_id);
		}
    }
    public function actionTranspass() {
        Yii::$app->session->set('curMain', 'transpass');
        $postdata=Yii::$app->request->post('DynamicModel');
        
        $model1=new DynamicModel(['user_id', 'currentPassword', 'newPassword', 'repeatPassword']);
        $model1->addRule(['user_id', 'currentPassword', 'newPassword', 'repeatPassword'], 'required')
                ->addRule(['repeatPassword'], 'compare', ['compareAttribute' => 'newPassword', 'message' => 'Passwords doesn\'t match.']);
        
        $model2=new DynamicModel(['user_id', 'new_Password', 'repeat_Password']);
        $model2->addRule(['user_id', 'new_Password', 'repeat_Password'], 'required')
                ->addRule(['repeat_Password'], 'compare', ['compareAttribute' => 'new_Password', 'message' => 'Passwords doesn\'t match.']);
        
        if(Yii::$app->request->isPost && !empty($postdata)) {
            $newpass=!empty($postdata['currentPassword']) ? $postdata['newPassword'] : $postdata['new_Password'] ;
            $uInfo=User::findOne($postdata['user_id']);
            if($uInfo) {
                if(!empty($postdata['currentPassword']) && Yii::$app->security->validatePassword($postdata['currentPassword'], $uInfo->transaction_password)===false) {
                    Yii::$app->session->setFlash('error', 'Current password is incorrect!');
                    return $this->refresh();
                }
                $uInfo->transaction_password=Yii::$app->security->generatePasswordHash($newpass);
                if($uInfo->save()) {
                    Yii::$app->session->setFlash('success', 'Password has been updated!');
                    return $this->refresh();
                }
                else {
                    Yii::$app->session->setFlash('error', 'Can\'t update password. Please try again later!');
                    return $this->refresh();
                }
            }
        }
        
        return $this->render('transpass', [
            'model1' => $model1,
            'model2' => $model2
        ]);
    }
    
    public function actionProfile() {
        $profile=TPHelper::uProfile(Yii::$app->user->identity->id);
        Yii::$app->session->set('curMain', 'usermanage');
        
        return $this->render('profile', [
            'model' => $this->findModel($profile->id),
        ]); 
    }
    
    public function actionEdit() {
        $id=TPHelper::uProfile(Yii::$app->user->identity->id)->id;
        Yii::$app->session->set('curMain', 'usermanage');
        $model=$this->findModel($id);
        $user=$this->userModel($model->user_id);
        
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            Yii::$app->response->format=Response::FORMAT_JSON;
            $userVal=ActiveForm::validate($user);
            $modelVal=ActiveForm::validate($model);
            $resp=array_merge($userVal, $modelVal);
            return $resp;
        }
        
        if($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
            $connection=Yii::$app->db;
            $transaction=$connection->beginTransaction();
            try {
                if(!empty($user->password)) $user->password_hash=Yii::$app->security->generatePasswordHash($user->password);
                $user_updated=$user->save(false) ? true : false;
                $profile_updated=$model->save(false) ? true : false;
                if($user_updated && $profile_updated) {
                    $transaction->commit();
                    $pack = UserPackage::findOne(['user_id'=> $user->id]);
                    if($pack){
                    	if($pack->payment_status == 'Pending'){
                    		Yii::$app->session->set('user_id', $pack->user_id);
                    Yii::$app->session->set('pack_id', $pack->pack_id);
                    return $this->redirect(['choosegateway']);
                    	}
                    }else{
                    	
                    Yii::$app->session->set('user_id', $user->id);
                    Yii::$app->session->set('pack_id', 1);
                    return $this->redirect(['choosegateway']);
                    }
                    
                    Yii::$app->session->setFlash('success', 'User has been updated!');
                    return $this->redirect(['profile']);
                }
                else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Can\'t update user. Please try again later!');
                }
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user
        ]);
    }

}
