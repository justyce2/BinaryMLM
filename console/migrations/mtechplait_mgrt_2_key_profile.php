<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_2_key_profile
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_2_key_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['PRIMARY'] = $this->addPrimaryKey(null, '{{%profile}}', 'id');
        $this->runSuccess['addAutoIncrement'] = $this->addAutoIncrement('{{%profile}}', 'id', 'integer', '', 0);
        $this->runSuccess['prf_usr'] = $this->createIndex('prf_usr', '{{%profile}}', 'user_id', 0);
        $this->runSuccess['prf_pack'] = $this->createIndex('prf_pack', '{{%profile}}', 'pack_id', 0);
        $this->runSuccess['prf_ref'] = $this->createIndex('prf_ref', '{{%profile}}', 'referrer', 0);
        $this->runSuccess['prf_city'] = $this->createIndex('prf_city', '{{%profile}}', 'city', 0);
        $this->runSuccess['prf_state'] = $this->createIndex('prf_state', '{{%profile}}', 'state', 0);
        $this->runSuccess['prf_country'] = $this->createIndex('prf_country', '{{%profile}}', 'country', 0);

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
                $this->dropPrimaryKey(null, '{{%profile}}');
            } elseif (!empty($keyName)) {
                $this->dropIndex("`$keyName`", '{{%profile}}');
            }
        }

    }
}
