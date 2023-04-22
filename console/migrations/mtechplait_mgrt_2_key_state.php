<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_2_key_state
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_2_key_state extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['PRIMARY'] = $this->addPrimaryKey(null, '{{%state}}', 'id');
        $this->runSuccess['addAutoIncrement'] = $this->addAutoIncrement('{{%state}}', 'id', 'integer', '', 4122);
        $this->runSuccess['country_fk'] = $this->createIndex('country_fk', '{{%state}}', 'country_id', 0);

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
                $this->dropPrimaryKey(null, '{{%state}}');
            } elseif (!empty($keyName)) {
                $this->dropIndex("`$keyName`", '{{%state}}');
            }
        }

    }
}
