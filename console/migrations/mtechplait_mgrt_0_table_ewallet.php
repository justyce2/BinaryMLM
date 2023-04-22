<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_ewallet
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_ewallet extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%ewallet}}', [
            'id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'current_balance' => $this->decimal(10)->notNull()->defaultValue('0.00'),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%ewallet}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%ewallet}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
