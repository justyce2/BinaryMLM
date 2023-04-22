<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $transaction_password
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Activity[] $activities
 * @property Etrans[] $etrans
 * @property Etrans[] $etrans0
 * @property Ewallet[] $ewallets
 * @property Messages[] $messages
 * @property Messages[] $messages0
 * @property Profile[] $profiles
 * @property Profile[] $profiles0
 * @property Superadmin[] $superadmins
 * @property UserPackage[] $userPackages
 */
class User extends \yii\db\ActiveRecord {

    public $password;
    public $transpass;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            
            if($this->password!='') $this->password_hash=Yii::$app->security->generatePasswordHash($this->password);
            if($this->transpass!='') $this->transaction_password=Yii::$app->security->generatePasswordHash($this->transpass);
            $time=time();
            if($this->isNewRecord) {
                $this->auth_key=Yii::$app->security->generateRandomString();
                $this->user_role=2;
                $this->created_at=$time;
            }
            $this->updated_at=$time;
            
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'password', 'transpass', 'email'], 'required'],
            [['user_role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'transaction_password'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'user_role' => 'User Role',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'transpass' => 'Transaction Password',
            'transaction_password' => 'Transaction Password',
            'status' => 'Status',
            'created_at' => 'Joined At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities() {
        return $this->hasMany(Activity::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtrans() {
        return $this->hasMany(Etrans::className(), ['trans_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtrans0() {
        return $this->hasMany(Etrans::className(), ['trans_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEwallets() {
        return $this->hasMany(Ewallet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages() {
        return $this->hasMany(Messages::className(), ['msg_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0() {
        return $this->hasMany(Messages::className(), ['msg_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles() {
        return $this->hasMany(Profile::className(), ['referrer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles0() {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuperadmins() {
        return $this->hasMany(Superadmin::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPackages() {
        return $this->hasMany(UserPackage::className(), ['user_id' => 'id']);
    }

}
