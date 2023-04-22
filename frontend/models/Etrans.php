<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "etrans".
 *
 * @property int $id
 * @property int $trans_from
 * @property int $trans_to
 * @property string $amount
 * @property string $type
 * @property string $reason
 * @property int $date
 * @property string $status
 *
 * @property User $transFrom
 * @property User $transTo
 */
class Etrans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etrans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trans_from', 'trans_to', 'amount', 'type', 'date'], 'required'],
            [['trans_from', 'trans_to', 'date'], 'integer'],
            [['amount', 'transaction_fee'], 'number'],
            [['type', 'status'], 'string'],
            [['reason'], 'string', 'max' => 255],
            [['trans_from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['trans_from' => 'id']],
            [['trans_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['trans_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_from' => 'Transferred From',
            'trans_to' => 'Transferred To',
            'amount' => 'Amount',
            'transaction_fee' => 'Transaction Fee',
            'type' => 'Type',
            'reason' => 'Reason',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'trans_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransTo()
    {
        return $this->hasOne(User::className(), ['id' => 'trans_to']);
    }
}
