<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_2_key_options
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_2_key_options extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['PRIMARY'] = $this->addPrimaryKey(null, '{{%options}}', 'id');
        $this->runSuccess['addAutoIncrement'] = $this->addAutoIncrement('{{%options}}', 'id', 'integer', '', 23);

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
                $this->dropPrimaryKey(null, '{{%options}}');
            } elseif (!empty($keyName)) {
                $this->dropIndex("`$keyName`", '{{%options}}');
            }
        }

    }
}
