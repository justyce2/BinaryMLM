<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_1_tableData_options
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_1_tableData_options extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->_transaction = $this->getDb()->beginTransaction();
        $this->batchInsert('{{%options}}', 
            ['id', 'option_name', 'option_value', 'autoload'],
            [
                [1, 'width_ceiling', '2', 'Yes'],
                [2, 'depth_ceiling', '3', 'Yes'],
                [3, 'type_of_commission', 'percentage', 'Yes'],
                [4, 'level_1_commission', '10', 'Yes'],
                [5, 'level_2_commission', '5', 'Yes'],
                [6, 'level_3_commission', '2', 'Yes'],
                [7, 'refferal_bonus_enabled', '1', 'Yes'],
                [8, 'refferal_bonus_type', 'percentage', 'Yes'],
                [9, 'refferal_bonus_value', '5', 'Yes'],
                [10, 'service_charge', '5', 'Yes'],
                [11, 'tds', '2', 'Yes'],
                [12, 'transaction_fee', '10', 'Yes'],
                [13, 'company_name', 'Techplait', 'Yes'],
                [14, 'company_address', 'Company Address Here.', 'Yes'],
                [15, 'email', 'support@techplait.com', 'Yes'],
                [16, 'phone', '6379090580', 'Yes'],
                [17, 'facebook', 'https://facebook.com', 'Yes'],
                [18, 'twitter', 'https://twitter.com', 'Yes'],
                [19, 'instagram', 'https://instagram.com', 'Yes'],
                [20, 'google_plus', 'https://plus.google.com', 'Yes'],
                [21, 'terms_and_conditions', '<p>Terms and Conditions Here.</p>
', 'Yes'],
                [22, 'privacy_policy', '<p>Privacy Policy Here.</p>
', 'Yes'],
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
