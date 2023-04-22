<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Messages;
use frontend\models\MessagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends Controller {

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Messages models.
     * @return mixed
     */
    public function actionIndex() {
        Yii::$app->session->set('curMain', 'messages');
        
        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionSent() {
        Yii::$app->session->set('curMain', 'messages');
        
        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'sent');

        return $this->render('sent', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Messages model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        Yii::$app->session->set('curMain', 'messages');
        
        $model=$this->findModel($id);
        if($model->status===0 && ($model->msg_from!==Yii::$app->user->identity->id)) {
            $model->status=1;
            $model->save();
        }
        
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $model,
            ]);
        }
        else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Messages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        Yii::$app->session->set('curMain', 'messages');
        
        $model=new Messages();

        if($model->load(Yii::$app->request->post())) {
            if(($model->msg_from!=$model->msg_to) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Your message has been sent!');
                return $this->redirect(['sent']);
            }
            else {
                Yii::$app->session->setFlash('error', 'You cannot send message to yourself!');
                return $this->refresh();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Messages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Messages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $from='inbox') {
        $status=($from==='inbox') ? 3 : 2;
        $model=$this->findModel($id);
        $model->status=$status;
        if($model->save()) {
            $link=($from==='inbox') ? 'index' : 'sent';
            return $this->redirect([$link]);
        }
    }

    /**
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
