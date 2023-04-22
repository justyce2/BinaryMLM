<?php

namespace frontend\models;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property int $referrer
 * @property string $position
 * @property int $placement
 * @property string $place_position
 * @property int $pack_id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $dob
 * @property string $address_line_1
 * @property string $address_line_2
 * @property int $city
 * @property int $state
 * @property int $country
 * @property string $zip_code
 * @property string $mobile_no
 * @property string $landline_no
 * @property string $facebook
 * @property string $twitter
 * @property string $blockchain_address
 * @property int $cur_pv
 * @property int $cf_left
 * @property int $cf_right
 * @property int $matched_upto
 * @property int $created_at
 * @property int $updated_at
 *
 * @property City $city0
 * @property Country $country0
 * @property Package $pack
 * @property User $placement0
 * @property User $referrer0
 * @property State $state0
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

            $time = time();
            if ($this->isNewRecord) {
                $this->created_at = $time;
            }
            $this->updated_at = $time;

            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'referrer', 'position', 'pack_id', 'first_name', 'last_name', 'gender','mobile_no', 'accountno', 'accountname', 'bankname'], 'required'],
            [['user_id', 'pack_id', 'city', 'state', 'country', 'cur_pv', 'cf_left', 'cf_right', 'matched_upto', 'created_at', 'updated_at'], 'integer'],
            [['position', 'place_position', 'gender'], 'string'],
            [['dob'], 'safe'],
            [['first_name', 'last_name', 'address_line_1', 'address_line_2', 'facebook', 'twitter', 'blockchain_address'], 'string', 'max' => 255],
            [['zip_code', 'mobile_no', 'landline_no'], 'string', 'max' => 20],
            [['pack_id'], 'exist', 'skipOnError' => true, 'targetClass' => Package::className(), 'targetAttribute' => ['pack_id' => 'id']],
            [['referrer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['referrer' => 'id']],
           //[['placement'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['placement' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'Username',
            'referrer' => 'Sponsor ID',
            'position' => 'Sponsor Position',
            'placement' => 'Placement',
            'place_position' => 'Placement Position',
            //'pack_id' => 'Package',
            'pack_id' => 'Level',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'dob' => 'Date of Birth',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'zip_code' => 'Zip Code',
            'mobile_no' => 'Mobile No',
            'landline_no' => 'Landline No',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'blockchain_address' => 'Blockchain Address',
            'created_at' => 'Joined At',
            'updated_at' => 'Last Updated',
            'bankname' => 'Bank Name',
            'accountname' => 'Account Name',
            'accountno' => 'Account Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity0() {
        return $this->hasOne(City::className(), ['id' => 'city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry0() {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPack() {
        return $this->hasOne(Package::className(), ['id' => 'pack_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacement0() {
        return $this->hasOne(User::className(), ['id' => 'placement']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrer0() {
        return $this->hasOne(User::className(), ['id' => 'referrer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState0() {
        return $this->hasOne(State::className(), ['id' => 'state']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
