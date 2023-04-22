<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use frontend\models\Ewallet;
use frontend\models\EtransSearch;
use yii\filters\AccessControl;

class ReportController extends Controller {
    
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['commission'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['payout', 'topearners'],
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

    public function actionCommission() {
        Yii::$app->session->set('curMain', 'reports');
        Yii::$app->session->set('curSub', 'creport');
        
        $searchModel = new EtransSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, (Yii::$app->user->identity->user_role===2) ? 'creport' : 'userCom');

        return $this->render('commission', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPayout() {
        Yii::$app->session->set('curMain', 'reports');
        Yii::$app->session->set('curSub', 'poutreport');
        
        $searchModel = new EtransSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'preport');

        return $this->render('payout', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTopearners() {
        Yii::$app->session->set('curMain', 'reports');
        Yii::$app->session->set('curSub', 'topearners');
        
        $query=Ewallet::find();
        $query->select('ewallet.*, sum(etrans.amount) as totalearnings');
        $query->leftJoin('etrans', 'ewallet.user_id=etrans.trans_to');
        $query->where([
            'etrans.status' => 'Approved',
            'etrans.type' => 'credit'
        ]);
        $query->groupBy('etrans.trans_to, ewallet.id');
        $dataProvider=new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['user_id', 'current_balance', 'totalearnings'],
                'defaultOrder' => [
                    'totalearnings' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('topearners', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
