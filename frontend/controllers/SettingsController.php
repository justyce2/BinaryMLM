<?php
namespace frontend\controllers;

use Yii;
use yii\base\DynamicModel;
use yii\web\Controller;
use common\components\TPHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * Settings controller for general settings
 */
class SettingsController extends Controller {
    
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
    
    public function actionSystem() {
        Yii::$app->session->set('curMain', 'settings');
        Yii::$app->session->set('curSub', 'system_settings');
        $depth=TPHelper::getOption('depth_ceiling');
        
        $com_model=new DynamicModel(['calculation_period', 'maximum_commission_eligibility_level', 'binary_commission']);
        $com_model->addRule(['calculation_period', 'maximum_commission_eligibility_level', 'binary_commission'], 'required');
        
        $ref_model=new DynamicModel(['refferal_bonus_enabled', 'refferal_bonus_type', 'refferal_bonus_value']);
        $ref_model->addRule(['refferal_bonus_enabled', 'refferal_bonus_type', 'refferal_bonus_value'], 'required');
        
        $oth_model=new DynamicModel(['service_charge', 'tds', 'transaction_fee']);
        $oth_model->addRule(['service_charge', 'tds', 'transaction_fee'], 'required');
        
        // Save user input to the database
        $com_save=$com_model->load(Yii::$app->request->post());
        $oth_save=$oth_model->load(Yii::$app->request->post());
        if($com_save || $oth_save) {
            $postdata=Yii::$app->request->post();
            foreach($postdata['DynamicModel'] as $opt_name => $opt_value) {
                TPHelper::saveOption($opt_name, $opt_value);
            }
            Yii::$app->session->setFlash('success', 'Settings has been updated!');
            return $this->redirect(['settings/system']);
        }
        
        return $this->render('system', [
            'com_model' => $com_model,
            'ref_model' => $ref_model,
            'oth_model' => $oth_model,
            'depth' => $depth
        ]);
    }
    
    public function actionCompany() {
        Yii::$app->session->set('curMain', 'settings');
        Yii::$app->session->set('curSub', 'company_profile');
        
        $site_model=new DynamicModel(['company_name', 'company_address', 'email', 'phone', 'logo', 'logo_inverse', 'favicon']);
        $site_model->addRule(['company_name', 'company_address', 'email', 'phone'], 'required')
                ->addRule('email', 'email')
                ->addRule(['logo', 'favicon'], 'file');
        
        $social_model=new DynamicModel(['facebook', 'twitter', 'instagram', 'google_plus']);
        $social_model->addRule(['facebook', 'twitter', 'instagram', 'google_plus'], 'required');
        
        // Save user input to the database
        $site_save=$site_model->load(Yii::$app->request->post());
        $social_save=$social_model->load(Yii::$app->request->post());
        if($site_save || $social_save) {
            $postdata=Yii::$app->request->post();
            foreach($postdata['DynamicModel'] as $opt_name => $opt_value) {
                if($opt_name!='logo' && $opt_name!='logo_inverse' && $opt_name!='favicon') {
                    TPHelper::saveOption($opt_name, $opt_value);
                }
                // logo upload
                $uploadedLogo=UploadedFile::getInstance($site_model, 'logo');
                ($uploadedLogo) ? $uploadedLogo->saveAs('img/logo.png') : '' ;
                // logo inverse upload
                $uploadedLogoIn=UploadedFile::getInstance($site_model, 'logo_inverse');
                ($uploadedLogoIn) ? $uploadedLogoIn->saveAs('img/logo_inverse.png') : '' ;
                // favicon upload
                $uploadedIco=UploadedFile::getInstance($site_model, 'favicon');
                ($uploadedIco) ? $uploadedIco->saveAs('img/favicon.ico') : '' ;
            }
            Yii::$app->session->setFlash('success', 'Company profile has been updated!');
            return $this->redirect(['settings/company']);
        }
        
        return $this->render('company', [
            'site_model' => $site_model,
            'social_model' => $social_model
        ]);
    }
    
    public function actionContent() {
        Yii::$app->session->set('curMain', 'settings');
        Yii::$app->session->set('curSub', 'content_manage');
        
        $t_model=new DynamicModel(['terms_and_conditions']);
        $t_model->addRule(['terms_and_conditions'], 'safe');
        
        $p_model=new DynamicModel(['privacy_policy']);
        $p_model->addRule(['privacy_policy'], 'safe');
        
        // Save user input to the database
        $t_save=$t_model->load(Yii::$app->request->post());
        $p_save=$p_model->load(Yii::$app->request->post());
        if($t_save || $p_save) {
            $postdata=Yii::$app->request->post();
            foreach($postdata['DynamicModel'] as $opt_name => $opt_value) {
                TPHelper::saveOption($opt_name, $opt_value);
            }
            Yii::$app->session->setFlash('success', 'Content management has been updated!');
            return $this->redirect(['settings/content']);
        }
        
        return $this->render('content', [
            't_model' => $t_model,
            'p_model' => $p_model
        ]);
    }

}
