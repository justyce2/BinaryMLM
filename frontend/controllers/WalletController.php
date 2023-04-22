<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Etrans;
use frontend\models\EtransSearch;
use common\components\TPHelper;
use yii\filters\AccessControl;

class WalletController extends Controller {
    
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['fundtransfer', 'transferhistory'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['history'],
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
                        'actions' => ['creditdebit'],
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

    public function actionCreditdebit() {
        Yii::$app->session->set('curMain', 'ewallet');
        Yii::$app->session->set('curSub', 'credit_debit');
        
        $model=New Etrans();
        
        if($model->load(Yii::$app->request->post())) {
            
            
           // print_r(Yii::$app->request->post());
          //  die;
            
            $model->trans_from=Yii::$app->user->identity->id;
            $model->reason='From Credit/Debit';
            $model->date = time();
            $model->status='Approved';
          // $model->save();
            if($model->save()) {
                TPHelper::updateUserWallet($model->trans_to, $model->amount, $model->type);
                Yii::$app->session->setFlash('success', 'Amount '.$model->type.'ed to the selected user!');
                return $this->refresh();
            }
            else {
                Yii::$app->session->setFlash('error', 'Error while processing your request!');
                return $this->refresh();
            }
            
        }
        
        return $this->render('creditdebit', [
            'model' => $model
        ]);
    }

    public function actionFundtransfer() {
        Yii::$app->session->set('curMain', 'ewallet');
        Yii::$app->session->set('curSub', 'fund_transfer');
        
        $model=new Etrans();
        
        if($model->load(Yii::$app->request->post())) {
            $deductAmt=bcadd($model->amount, TPHelper::getOption('transaction_fee'), 2);
            $curBal=TPHelper::curBalance($model->trans_from);
            if($curBal<$deductAmt) {
                Yii::$app->session->setFlash('error', 'Low balance in the wallet. Try lower amount!');
                return $this->refresh();
            }
            $model->transaction_fee=TPHelper::getOption('transaction_fee');
            $model->type='credit';
            $model->reason='Fund Transfer';
            $model->date=time();
            $model->status='Approved';
            if($model->save()) {
                TPHelper::updateUserWallet($model->trans_from, $deductAmt, 'debit');
                TPHelper::updateUserWallet($model->trans_to, $model->amount);
                Yii::$app->session->setFlash('success', 'Fund transfer completed!');
                return $this->refresh();
            }
            else {
                Yii::$app->session->setFlash('error', 'Error while processing your request!');
                return $this->refresh();
            }
        }
        
        return $this->render('fundtransfer', [
            'model' => $model
        ]);
    }

    public function actionTransferhistory() {
        Yii::$app->session->set('curMain', 'ewallet');
        Yii::$app->session->set('curSub', 'transfer_history');
        
        $searchModel = new EtransSearch();
        $dataProvider = $searchModel->transhistory(Yii::$app->request->queryParams);

        return $this->render('transferhistory', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionHistory() {
        Yii::$app->session->set('curMain', 'ewallet');
        Yii::$app->session->set('curSub', 'history');
        
        $searchModel = new EtransSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'history');

        return $this->render('history', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
