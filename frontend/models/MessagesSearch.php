<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Messages;

/**
 * MessagesSearch represents the model behind the search form of `frontend\models\Messages`.
 */
class MessagesSearch extends Messages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'msg_from', 'msg_to', 'date', 'status'], 'integer'],
            [['subject', 'message'], 'safe'],
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
    public function search($params, $for='inbox')
    {
        $query = Messages::find();
        
        if($for=='inbox') {
            $query->andWhere(['msg_to' => Yii::$app->user->identity->id])
                  ->andWhere(['!=', 'status', 3]);
        }
        else if($for=='sent') {
            $query->andWhere(['msg_from' => Yii::$app->user->identity->id])
                  ->andWhere(['!=', 'status', 2]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 8
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
            'msg_from' => $this->msg_from,
            'msg_to' => $this->msg_to,
            'date' => $this->date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
