<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_user_package
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_user_package extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%user_package}}', [
            'id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'pack_id' => $this->integer(11)->notNull(),
            'purchased_at' => $this->integer(11)->notNull(),
            'payment_mode' => "ENUM ('Cheque', 'Paypal', 'Bitcoin') NOT NULL DEFAULT 'Cheque'",
            'payment_status' => "ENUM ('Pending', 'Paid', 'Failed', 'Canceled') NOT NULL DEFAULT 'Pending'",
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%user_package}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%user_package}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
