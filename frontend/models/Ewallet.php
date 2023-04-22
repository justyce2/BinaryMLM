<?php

namespace frontend\models;

use Yii;


/**
 * This is the model class for table "ewallet".
 *
 * @property int $id
 * @property int $user_id
 * @property string $current_balance
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class Ewallet extends \yii\db\ActiveRecord
{
    public $totalearnings;
    /**
     * {@inheritdoc}
     */
   public static function tableName()
    {
        return 'ewallet';
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            
            $time=time();
            if($this->isNewRecord) {
                $this->created_at=$time;
                $this->current_balance=0.00;
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
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['current_balance'], 'number'],
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
            'state' => 'State',
            'current_balance' => 'Current Balance',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
     public function getState0() {
        return $this->hasOne(State::className(), ['id' => 'state']);
    }
}
