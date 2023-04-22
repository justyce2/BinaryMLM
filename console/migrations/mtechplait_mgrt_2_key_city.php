<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_2_key_city
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_2_key_city extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['PRIMARY'] = $this->addPrimaryKey(null, '{{%city}}', 'id');
        $this->runSuccess['addAutoIncrement'] = $this->addAutoIncrement('{{%city}}', 'id', 'integer', '', 48357);
        $this->runSuccess['state_id'] = $this->createIndex('state_id', '{{%city}}', 'state_id', 0);

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
                $this->dropPrimaryKey(null, '{{%city}}');
            } elseif (!empty($keyName)) {
                $this->dropIndex("`$keyName`", '{{%city}}');
            }
        }

    }
}
