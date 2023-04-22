<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_0_table_profile
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_0_table_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->runSuccess['createTable'] = $this->createTable('{{%profile}}', [
            'id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'referrer' => $this->integer(11)->notNull(),
            'pack_id' => $this->integer(11)->notNull(),
            'first_name' => $this->string(255)->null(),
            'last_name' => $this->string(255)->null(),
            'gender' => "ENUM ('Male', 'Female', 'Rather not say') NOT NULL DEFAULT 'Male'",
            'dob' => $this->date()->null(),
            'address_line_1' => $this->string(255)->null(),
            'address_line_2' => $this->string(255)->null(),
            'city' => $this->integer(11)->notNull(),
            'state' => $this->integer(11)->notNull(),
            'country' => $this->integer(11)->notNull(),
            'zip_code' => $this->string(20)->null(),
            'mobile_no' => $this->string(20)->null(),
            'landline_no' => $this->string(20)->null(),
            'facebook' => $this->string(255)->null(),
            'twitter' => $this->string(255)->null(),
            'blockchain_address' => $this->string(255)->null(),
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
                $this->dropTable('{{%profile}}');
            } elseif ('addTableComment' === $keyName) {
                $this->dropCommentFromTable('{{%profile}}');
            } else {
                throw new \yii\db\Exception('only support "dropTable" and "dropCommentFromTable"');
            }
        }
    }
}
