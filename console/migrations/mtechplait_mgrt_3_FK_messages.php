<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_3_FK_messages
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_3_FK_messages extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $tablePrefix = \Yii::$app->getDb()->tablePrefix;
        $this->runSuccess[$tablePrefix.'msg_frm_usr'] = $this->addForeignKey($tablePrefix.'msg_frm_usr', '{{%messages}}', 'msg_from', '{{%user}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'msg_to_usr'] = $this->addForeignKey($tablePrefix.'msg_to_usr', '{{%messages}}', 'msg_to', '{{%user}}', 'id', null, 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            $this->dropForeignKey($keyName, '{{%messages}}');
        }

    }
}
