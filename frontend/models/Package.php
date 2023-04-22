<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property int $id
 * @property string $name
 * @property string $amount
 * @property int $point_volume
 * @property int $created_at
 * @property int $updated_at
 * @property string $status
 *
 * @property Profile[] $profiles
 * @property UserPackage[] $userPackages
 */
class Package extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'package';
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            
            $time=time();
            if($this->isNewRecord) {
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
            [['name', 'amount', 'point_volume'], 'required'],
            [['amount'], 'number'],
            [['point_volume', 'created_at', 'updated_at'], 'integer'],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'amount' => 'Amount',
            'point_volume' => 'Point Volume (PV)',
            'created_at' => 'Created At',
            'updated_at' => 'Last Updated',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles() {
        return $this->hasMany(Profile::className(), ['pack_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPackages() {
        return $this->hasMany(UserPackage::className(), ['pack_id' => 'id']);
    }

}