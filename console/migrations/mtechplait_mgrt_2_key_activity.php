<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_2_key_activity
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_2_key_activity extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['PRIMARY'] = $this->addPrimaryKey(null, '{{%activity}}', 'id');
        $this->runSuccess['addAutoIncrement'] = $this->addAutoIncrement('{{%activity}}', 'id', 'integer', '', 0);
        $this->runSuccess['act_usr'] = $this->createIndex('act_usr', '{{%activity}}', 'user_id', 0);

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
                $this->dropPrimaryKey(null, '{{%activity}}');
            } elseif (!empty($keyName)) {
                $this->dropIndex("`$keyName`", '{{%activity}}');
            }
        }

    }
}
