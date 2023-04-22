<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property string $browser
 * @property string $text
 * @property int $date
 *
 * @property User $user
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord) {
                $this->ip_address=Yii::$app->request->userIP;
                $this->browser=Yii::$app->request->userAgent;
                $this->date=time();
            }
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date'], 'required'],
            [['user_id', 'date'], 'integer'],
            [['text'], 'string'],
            [['ip_address', 'browser'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Username',
            'ip_address' => 'Ip Address',
            'browser' => 'Browser',
            'text' => 'Activity',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
