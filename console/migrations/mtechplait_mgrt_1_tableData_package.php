<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_1_tableData_package
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_1_tableData_package extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->_transaction = $this->getDb()->beginTransaction();
        $this->batchInsert('{{%package}}', 
            ['id', 'name', 'amount', 'validity', 'created_at', 'updated_at', 'status'],
            [
                [1, 'Silver', '100.00', 30, 1541395929, 1541395929, 'Active'],
                [2, 'Gold', '300.00', 60, 1541395950, 1541395950, 'Active'],
                [3, 'Platinum', '500.00', 90, 1541395969, 1541395969, 'Active'],
            ]
        );
        $this->_transaction->commit();

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        $this->_transaction->rollBack();

    }
}
