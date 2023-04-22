<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\Response;
use frontend\models\User;
use frontend\models\State;
use frontend\models\City;
use common\components\TPHelper;
use yii\filters\AccessControl;
use common\components\MLMHelper;
use frontend\models\Profile;

/**
 * AjaxController used to retrieve data dynamically.
 */
class AjaxController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['getcurbal'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSearchuser($term, $incAdmin = false) {
        if (Yii::$app->request->isAjax) {
            $results = [];
            if (is_numeric($term)) {
                if ($incAdmin)
                    $model = User::findOne(['id' => $term]);
                else
                    $model = User::findOne(['id' => $term, 'user_role' => 1]);
                if ($model) {
                    $results[] = [
                        'id' => $model->id,
                        'label' => $model->username,
                    ];
                }
            } else {
                $q = addslashes($term);
                if ($incAdmin)
                    $que = User::find()->where("(`username` like '%{$q}%')")->all();
                else
                    $que = User::find()->where("(`username` like '%{$q}%') and user_role=1")->all();
                foreach ($que as $model) {
                    $results[] = [
                        'id' => $model->id,
                        'label' => $model->username,
                    ];
                }
            }
            echo Json::encode($results);
        }
    }

    public function actionStates() {
        if (Yii::$app->request->isAjax) {
            $parents = Yii::$app->request->post('depdrop_parents');
            if ($parents != null) {
                $country_id = $parents[0];
                $output = State::find()->select(['id', 'name'])->where(['country_id' => $country_id])->asArray()->all();
                $data = Json::encode(['output' => $output, 'selected' => '']);
                Yii::$app->response->format = Response::FORMAT_RAW;
                return $data;
            }
            $data = Json::encode(['output' => '', 'selected' => '']);
            Yii::$app->response->format = Response::FORMAT_RAW;
            return $data;
        }
    }

    public function actionCities() {
        if (Yii::$app->request->isAjax) {
            $parents = Yii::$app->request->post('depdrop_parents');
            if ($parents != null) {
                $state_id = $parents[0];
                $output = City::find()->select(['id', 'name'])->where(['state_id' => $state_id])->asArray()->all();
                $data = Json::encode(['output' => $output, 'selected' => '']);
                Yii::$app->response->format = Response::FORMAT_RAW;
                return $data;
            }
            $data = Json::encode(['output' => '', 'selected' => '']);
            Yii::$app->response->format = Response::FORMAT_RAW;
            return $data;
        }
    }

    public function actionGetcurbal() {
        $userInfo = User::find()->select('id')->where(['username' => Yii::$app->request->post('username')])->one();
        if ($userInfo) {
            $curBalance = TPHelper::curBalance($userInfo->id);
            return Yii::$app->formatter->format($curBalance, 'currency');
        }
        return false;
    }

    public function actionGetplacement($sponsor, $position) {
        if (Yii::$app->request->isAjax) {
            $getSponsor = User::findOne(['username' => $sponsor]);
            if($getSponsor) {
                $posUser = Profile::findOne(['placement' => $getSponsor->id, 'place_position' => $position]);
                if ($posUser) {
                    $getPlc = MLMHelper::getPlacementUser($posUser->user_id, true);
                    return $getPlc['username'];
                }
                else {
                    return $getSponsor->username;
                }
            }
        }
        else {
            return 'Invalid request.';
        }
    }

}
