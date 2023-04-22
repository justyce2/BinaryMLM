<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Profile;

/**
 * ProfileSearch represents the model behind the search form of `frontend\models\Profile`.
 */
class ProfileSearch extends Profile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'referrer', 'position', 'placement', 'place_position', 'pack_id', 'country', 'created_at', 'updated_at','state'], 'safe'],
            [['first_name', 'last_name', 'gender', 'dob', 'address_line_1', 'address_line_2', 'zip_code', 'mobile_no', 'landline_no', 'facebook', 'twitter', 'blockchain_address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Profile::find();
        if(Yii::$app->user->identity->user_role===1) {
           $query->andWhere(['referrer' => Yii::$app->user->identity->id]);
        }
         
        
        $query->joinWith([
            'user',
            'pack',
            'country0',
            'state0' => function ($q) {
                $q->from('state name');
            },
            'referrer0' => function ($q) {
                $q->from('user ref');
            },
            'placement0' => function ($q) {
                $q->from('user plc');
            },
        ]);

        // add conditions that should always apply here

        	//$query->joinWith(['user']);
        	

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 60
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user.username' => $this->user_id,
            'ref.username' => $this->referrer,
            'plc.username' => $this->placement,
            'package.name' => $this->pack_id,
            'position' =>$this->position,
            'place_position' => $this->place_position,
            'dob' => $this->dob ? date('Y-m-d', strtotime($this->dob)) : '',
            'city' => $this->city,
            'state' => $this->state,
            'country.name' => $this->country,
            'user.created_at' => $this->created_at ? strtotime($this->created_at) : '',
            'user.updated_at' => $this->updated_at ? strtotime($this->updated_at) : '',
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'address_line_1', $this->address_line_1])
            ->andFilterWhere(['like', 'address_line_2', $this->address_line_2])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', 'landline_no', $this->landline_no])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'blockchain_address', $this->blockchain_address]);

        return $dataProvider;
    }
}
