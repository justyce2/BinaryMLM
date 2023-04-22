<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_messages
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_messages extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%messages}}', [
            'id' => $this->integer(11)->notNull(),
            'msg_from' => $this->integer(11)->notNull(),
            'msg_to' => $this->integer(11)->notNull(),
            'subject' => $this->string(255)->notNull(),
            'message' => $this->text()->notNull(),
            'date' => $this->integer(11)->notNull(),
            'status' => $this->tinyint(4)->notNull()->defaultValue(0)->comment('0=Delivered, 1=Seen, 2=Del From, 3=Del To'),
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%messages}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%messages}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
