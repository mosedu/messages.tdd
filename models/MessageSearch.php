<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Message;

/**
 * MessageSearch represents the model behind the search form about `app\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg_id', 'msg_type', 'msg_dep_id', 'msg_user_id', 'msg_status'], 'integer'],
            [['msg_created', 'msg_person', 'msg_email', 'msg_phone', 'msg_subject', 'msg_child', 'msg_child_birth', 'msg_ekis_id', 'msg_text', 'msg_user_setted', 'msg_answer_period', 'msg_answer', 'msg_answer_time', 'msg_comment', 'msg_talk_start', 'msg_talk_finish'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Message::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'msg_id' => $this->msg_id,
            'msg_type' => $this->msg_type,
            'msg_dep_id' => $this->msg_dep_id,
            'msg_created' => $this->msg_created,
            'msg_child_birth' => $this->msg_child_birth,
            'msg_user_id' => $this->msg_user_id,
            'msg_user_setted' => $this->msg_user_setted,
            'msg_answer_period' => $this->msg_answer_period,
            'msg_answer_time' => $this->msg_answer_time,
            'msg_status' => $this->msg_status,
            'msg_talk_start' => $this->msg_talk_start,
            'msg_talk_finish' => $this->msg_talk_finish,
        ]);

        $query->andFilterWhere(['like', 'msg_person', $this->msg_person])
            ->andFilterWhere(['like', 'msg_email', $this->msg_email])
            ->andFilterWhere(['like', 'msg_phone', $this->msg_phone])
            ->andFilterWhere(['like', 'msg_subject', $this->msg_subject])
            ->andFilterWhere(['like', 'msg_child', $this->msg_child])
            ->andFilterWhere(['like', 'msg_ekis_id', $this->msg_ekis_id])
            ->andFilterWhere(['like', 'msg_text', $this->msg_text])
            ->andFilterWhere(['like', 'msg_answer', $this->msg_answer])
            ->andFilterWhere(['like', 'msg_comment', $this->msg_comment]);

        return $dataProvider;
    }
}
