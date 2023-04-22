<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_2_key_messages
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_2_key_messages extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['PRIMARY'] = $this->addPrimaryKey(null, '{{%messages}}', 'id');
        $this->runSuccess['addAutoIncrement'] = $this->addAutoIncrement('{{%messages}}', 'id', 'integer', '', 0);
        $this->runSuccess['msg_frm_usr'] = $this->createIndex('msg_frm_usr', '{{%messages}}', 'msg_from', 0);
        $this->runSuccess['msg_to_usr'] = $this->createIndex('msg_to_usr', '{{%messages}}', 'msg_to', 0);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('addAutoIncrement' === $keyName) {
                continue;
            } elseif ('PRIMARY' === $keyName) {
                // must be remove auto_increment before drop primary key
                if (isset($this->runSuccess['addAutoIncrement'])) {
                    $value = $this->runSuccess['addAutoIncrement'];
                    $this->dropAutoIncrement("{$value['table_name']}", $value['column_name'], $value['column_type'], $value['property']);
                }
                $this->dropPrimaryKey(null, '{{%messages}}');
            } elseif (!empty($keyName)) {
                $this->dropIndex("`$keyName`", '{{%messages}}');
            }
        }

    }
}
