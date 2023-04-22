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
class UserPackage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_package';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'pack_id', 'purchased_at'], 'required'],
            [['user_id', 'pack_id', 'purchased_at'], 'integer'],
            [['payment_mode', 'payment_status'], 'string'],
            [['pack_id'], 'exist', 'skipOnError' => true, 'targetClass' => Package::className(), 'targetAttribute' => ['pack_id' => 'id']],
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
            'user_id' => 'User ID',
            'pack_id' => 'Level',
            'purchased_at' => 'Purchased At',
            'payment_mode' => 'Payment Mode',
            'transaction_ref'=>'Transaction Ref',
            'payment_status' => 'Payment Status',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPack()
    {
        return $this->hasOne(Package::className(), ['id' => 'pack_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
