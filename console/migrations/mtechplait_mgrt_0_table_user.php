<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_user
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%user}}', [
            'id' => $this->integer(11)->notNull(),
            'username' => $this->string(255)->notNull(),
            'user_role' => $this->tinyint(4)->notNull()->defaultValue(1)->comment('1=User, 2=Admin'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->null(),
            'email' => $this->string(255)->notNull(),
            'transaction_password' => $this->string(255)->null(),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1),
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
                $this->dropTable('{{%user}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%user}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
