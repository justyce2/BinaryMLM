<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_package
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_package extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%package}}', [
            'id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'amount' => $this->decimal(10)->notNull()->defaultValue('0.00'),
            'validity' => $this->integer(11)->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'status' => "ENUM ('Active', 'Inactive') NOT NULL DEFAULT 'Active'",
        ], $this->tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            if ('createTable' === $keyName) {
                $this->dropTable('{{%package}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%package}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
