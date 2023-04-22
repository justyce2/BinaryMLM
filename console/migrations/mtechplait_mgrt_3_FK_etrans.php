<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_3_FK_etrans
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_3_FK_etrans extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $tablePrefix = \Yii::$app->getDb()->tablePrefix;
        $this->runSuccess[$tablePrefix.'trns_frm_usr'] = $this->addForeignKey($tablePrefix.'trns_frm_usr', '{{%etrans}}', 'trans_from', '{{%user}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'trns_to_usr'] = $this->addForeignKey($tablePrefix.'trns_to_usr', '{{%etrans}}', 'trans_to', '{{%user}}', 'id', null, 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            $this->dropForeignKey($keyName, '{{%etrans}}');
        }

    }
}
