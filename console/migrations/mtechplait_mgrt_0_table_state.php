<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_state
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_state extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%state}}', [
            'id' => $this->integer(11)->notNull(),
            'country_id' => $this->integer(11)->notNull(),
            'name' => $this->string(200)->notNull(),
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%state}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%state}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
