<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\components\TPHelper;
use yii\filters\AccessControl;

/**
 * Organization controller for referral tree
 */
class OrganizationController extends Controller {
    
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionGenealogy($startFrom=null) {
        Yii::$app->session->set('curMain', 'organization');
        Yii::$app->session->set('curSub', 'genealogy');
        return $this->render('genealogy', [
            'startFrom' => $startFrom
        ]);
    }
    
    public function actionTabular() {
        Yii::$app->session->set('curMain', 'organization');
        Yii::$app->session->set('curSub', 'tabular');
        $data=TPHelper::tabularData();

        return $this->render('tabular', [
            'data' => $data
        ]);
    }
    
    public function actionSponsor() {
        Yii::$app->session->set('curMain', 'organization');
        Yii::$app->session->set('curSub', 'sponsor');
        return $this->render('sponsor');
    }

}
