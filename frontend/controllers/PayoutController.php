<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Etrans;
use frontend\models\EwalletSearch;
use frontend\models\EtransSearch;
use common\components\TPHelper;
use yii\filters\AccessControl;


class PayoutController extends Controller {
    
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['earned', 'released'],
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
                        'actions' => ['release', 'confirmtrans'],
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
        ];
    }

    public function actionRelease() {
        Yii::$app->session->set('curMain', 'payout');
        Yii::$app->session->set('curSub', 'release');
        
        $searchModel = new EwalletSearch();
        $dataProvider = $searchModel->payoutrelease(Yii::$app->request->queryParams);
        
        // If release button is clicked
        if(Yii::$app->request->isPost) {
            $selection=Yii::$app->request->post('selection');
            if(!empty($selection)) {
                $released=0;
                foreach($selection as $uId) {
                    $poutAmt=Yii::$app->request->post('poutAmt_'.$uId);
                    $curBalance=TPHelper::curBalance($uId);
                    if($poutAmt<=$curBalance) {
                        $etrans=new Etrans();
                        $etrans->trans_from=Yii::$app->user->identity->id;
                        $etrans->trans_to=$uId;
                        $etrans->amount=$poutAmt;
                        $etrans->type='debit';
                        $etrans->reason='Payout Release';
                        $etrans->date=time();
                        if($etrans->save()) {
                            $released++;
                        }
                    }
                }
                if($released>0) {
                    Yii::$app->session->setFlash('success', 'Payout released for '.$released.' user(s). You should confirm your transfer after making manual payment!');
                    return $this->refresh();
                }
                else {
                    Yii::$app->session->setFlash('error', 'Something went wrong. Please try after sometime!');
                    return $this->refresh();
                }
            }
            else {
                Yii::$app->session->setFlash('error', 'Choose atleast one user to release payout!');
                return $this->refresh();
            }
        }

        return $this->render('release', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionConfirmtrans() {
        Yii::$app->session->set('curMain', 'payout');
        Yii::$app->session->set('curSub', 'confirmtrans');
        
        $searchModel = new EtransSearch();
        $dataProvider = $searchModel->confirmtrans(Yii::$app->request->queryParams);
        
        // If confirm button is clicked
        if(Yii::$app->request->isPost) {
            $selection=Yii::$app->request->post('selection');
            if(!empty($selection)) {
                $confirmed=0;
                foreach($selection as $eId) {
                    $etrans=Etrans::findOne($eId);
                    $etrans->status='Approved';
                    if($etrans->save()) {
                        TPHelper::updateUserWallet($etrans->trans_to, $etrans->amount, 'debit');
                        $confirmed++;
                    }
                }
                if($confirmed>0) {
                    Yii::$app->session->setFlash('success', 'Payout transfer confirmed for '.$confirmed.' user(s).');
                    return $this->refresh();
                }
                else {
                    Yii::$app->session->setFlash('error', 'Something went wrong. Please try after sometime!');
                    return $this->refresh();
                }
            }
            else {
                Yii::$app->session->setFlash('error', 'Choose atleast one user to confirm transfer!');
                return $this->refresh();
            }
        }

        return $this->render('confirmtrans', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionEarned() {
        Yii::$app->session->set('curMain', 'incomedetails');
        Yii::$app->session->set('curSub', 'earned');
        
        $searchModel = new EtransSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'earned');

        return $this->render('earned', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionReleased() {
        Yii::$app->session->set('curMain', 'incomedetails');
        Yii::$app->session->set('curSub', 'released');
        
        $searchModel = new EtransSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'released');

        return $this->render('released', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
