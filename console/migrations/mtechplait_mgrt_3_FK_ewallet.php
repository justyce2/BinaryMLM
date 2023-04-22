<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_3_FK_ewallet
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_3_FK_ewallet extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $tablePrefix = \Yii::$app->getDb()->tablePrefix;
        $this->runSuccess[$tablePrefix.'ew_usr'] = $this->addForeignKey($tablePrefix.'ew_usr', '{{%ewallet}}', 'user_id', '{{%user}}', 'id', null, 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            $this->dropForeignKey($keyName, '{{%ewallet}}');
        }

    }
}
