<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $msg_from
 * @property int $msg_to
 * @property string $subject
 * @property string $message
 * @property int $date
 * @property int $status 0=Delivered, 1=Seen, 2=Del From, 3=Del To, 4=Del Both
 *
 * @property User $msgFrom
 * @property User $msgTo
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            
            $time=time();
            if($this->isNewRecord) {
                $this->status=0;
                $this->date=$time;
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
            [['msg_from', 'msg_to', 'subject', 'message'], 'required'],
            [['msg_from', 'msg_to', 'date', 'status'], 'integer'],
            [['message'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['msg_from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['msg_from' => 'id']],
            [['msg_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['msg_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msg_from' => 'From',
            'msg_to' => 'To',
            'subject' => 'Subject',
            'message' => 'Message',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsgFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'msg_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMsgTo()
    {
        return $this->hasOne(User::className(), ['id' => 'msg_to']);
    }
}
