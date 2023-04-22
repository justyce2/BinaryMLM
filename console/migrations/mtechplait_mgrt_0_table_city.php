<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_city
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_city extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%city}}', [
            'id' => $this->integer(11)->notNull(),
            'state_id' => $this->integer(11)->notNull(),
            'name' => $this->string(30)->notNull(),
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%city}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%city}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
