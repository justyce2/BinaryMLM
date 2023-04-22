<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $short_name
 * @property int $phone_code
 * @property string $name
 *
 * @property Profile[] $profiles
 * @property State[] $states
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_name', 'phone_code', 'name'], 'required'],
            [['phone_code'], 'integer'],
            [['short_name'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_name' => 'Short Name',
            'phone_code' => 'Phone Code',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['country' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(State::className(), ['country_id' => 'id']);
    }
}
