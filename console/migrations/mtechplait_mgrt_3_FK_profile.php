<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_3_FK_profile
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_3_FK_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $tablePrefix = \Yii::$app->getDb()->tablePrefix;
        $this->runSuccess[$tablePrefix.'prf_city'] = $this->addForeignKey($tablePrefix.'prf_city', '{{%profile}}', 'city', '{{%city}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'prf_country'] = $this->addForeignKey($tablePrefix.'prf_country', '{{%profile}}', 'country', '{{%country}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'prf_pack'] = $this->addForeignKey($tablePrefix.'prf_pack', '{{%profile}}', 'pack_id', '{{%package}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'prf_ref'] = $this->addForeignKey($tablePrefix.'prf_ref', '{{%profile}}', 'referrer', '{{%user}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'prf_state'] = $this->addForeignKey($tablePrefix.'prf_state', '{{%profile}}', 'state', '{{%state}}', 'id', null, 'CASCADE');
        $this->runSuccess[$tablePrefix.'prf_usr'] = $this->addForeignKey($tablePrefix.'prf_usr', '{{%profile}}', 'user_id', '{{%user}}', 'id', null, 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        foreach ($this->runSuccess as $keyName => $value) {
            $this->dropForeignKey($keyName, '{{%profile}}');
        }

    }
}
