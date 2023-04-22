<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_3_FK_user_package
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_3_FK_user_package extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $tablePrefix = \Yii::$app->getDb()->tablePrefix;
        $this->runSuccess[$tablePrefix.'up_pack'] = $this->addForeignKey($tablePrefix.'up_pack', '{{%user_package}}', 'pack_id', '{{%package}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'up_usr'] = $this->addForeignKey($tablePrefix.'up_usr', '{{%user_package}}', 'user_id', '{{%user}}', 'id', null, 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            $this->dropForeignKey($keyName, '{{%user_package}}');
        }

    }
}
