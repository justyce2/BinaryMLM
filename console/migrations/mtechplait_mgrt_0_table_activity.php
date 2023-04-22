<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_activity
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_activity extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%activity}}', [
            'id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'ip_address' => $this->string(255)->null(),
            'browser' => $this->string(255)->null(),
            'text' => $this->text()->null(),
            'date' => $this->integer(11)->notNull(),
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%activity}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%activity}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
