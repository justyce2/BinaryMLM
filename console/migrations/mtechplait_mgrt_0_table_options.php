<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_options
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_options extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%options}}', [
            'id' => $this->integer(11)->notNull(),
            'option_name' => $this->string(255)->notNull(),
            'option_value' => $this->text()->null(),
            'autoload' => "ENUM ('Yes', 'No') NOT NULL DEFAULT 'Yes'",
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%options}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%options}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
