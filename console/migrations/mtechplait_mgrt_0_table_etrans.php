<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_etrans
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_etrans extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%etrans}}', [
            'id' => $this->integer(11)->notNull(),
            'trans_from' => $this->integer(11)->notNull(),
            'trans_to' => $this->integer(11)->notNull(),
            'amount' => $this->decimal(10)->notNull(),
            'transaction_fee' => $this->decimal(10)->notNull()->defaultValue('0.00'),
            'type' => "ENUM ('credit', 'debit') NOT NULL",
            'reason' => $this->string(255)->null(),
            'date' => $this->integer(11)->notNull(),
            'status' => "ENUM ('Pending', 'Approved') NOT NULL DEFAULT 'Pending'",
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%etrans}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%etrans}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
