<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_country
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_country extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%country}}', [
            'id' => $this->integer(11)->notNull(),
            'short_name' => $this->string(3)->notNull(),
            'phone_code' => $this->integer(11)->notNull(),
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
                $this->dropTable('{{%country}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%country}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
