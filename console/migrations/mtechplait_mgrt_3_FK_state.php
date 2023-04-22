<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_3_FK_state
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_3_FK_state extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $tablePrefix = \Yii::$app->getDb()->tablePrefix;
        $this->runSuccess[$tablePrefix.'country_fk'] = $this->addForeignKey($tablePrefix.'country_fk', '{{%state}}', 'country_id', '{{%country}}', 'id', null, 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            $this->dropForeignKey($keyName, '{{%state}}');
        }

    }
}
