<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_package".
 *
 * @property int $id
 * @property int $user_id
 * @property int $pack_id
 * @property int $purchased_at
 * @property string $payment_mode
 * @property string $payment_status
 *
 * @property Package $pack
 * @property User $user
 */
class Levels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'levels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'upline_id', 'level'], 'integer'],
          
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'pack_id' => 'Pack ID',
            'upline_id' => 'Upline ID',
            'level' => 'Level',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpline()
    {
        return $this->hasOne(Profile::className(), ['id' => 'placement']);
    }
 /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser ()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
   
}
