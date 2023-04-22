<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_1_tableData_user
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_1_tableData_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->_transaction = $this->getDb()->beginTransaction();
        $this->batchInsert('{{%user}}', 
            ['id', 'username', 'user_role', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'transaction_password', 'status', 'created_at', 'updated_at'],
            [
                [1, 'tpadmin', 2, 'yvD7T_qt4yxUR36N6ACwrqg5y5c8B35s', '$2y$13$UES5/uew6BY1INs6B86Dnu0O.GinXw3iemXtFCzzlZuCZYktKHOVq', null, 'support@techplait.com', '$2y$13$4LtF4pEsoV4klQDPhP0Mn.YhLl5vD7zICZS9D7SuxOugj47JR7GfC', 1, 1541395615, 1541395615],
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
