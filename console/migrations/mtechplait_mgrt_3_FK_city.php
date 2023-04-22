<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_3_FK_city
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_3_FK_city extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $tablePrefix = \Yii::$app->getDb()->tablePrefix;
        $this->runSuccess[$tablePrefix.'state_fk'] = $this->addForeignKey($tablePrefix.'state_fk', '{{%city}}', 'state_id', '{{%state}}', 'id', 'NO ACTION', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            $this->dropForeignKey($keyName, '{{%city}}');
        }

    }
}
