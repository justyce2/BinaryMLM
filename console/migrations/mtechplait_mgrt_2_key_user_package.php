<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_2_key_user_package
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_2_key_user_package extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['PRIMARY'] = $this->addPrimaryKey(null, '{{%user_package}}', 'id');
        $this->runSuccess['addAutoIncrement'] = $this->addAutoIncrement('{{%user_package}}', 'id', 'integer', '', 0);
        $this->runSuccess['up_usr'] = $this->createIndex('up_usr', '{{%user_package}}', 'user_id', 0);
        $this->runSuccess['up_pack'] = $this->createIndex('up_pack', '{{%user_package}}', 'pack_id', 0);

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
                $this->dropPrimaryKey(null, '{{%user_package}}');
            } elseif (!empty($keyName)) {
                $this->dropIndex("`$keyName`", '{{%user_package}}');
            }
        }

    }
}
