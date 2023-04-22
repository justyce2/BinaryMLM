<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property int $id
 * @property string $option_name
 * @property string $option_value
 * @property string $autoload
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_name'], 'required'],
            [['option_value', 'autoload'], 'string'],
            [['option_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_name' => 'Option Name',
            'option_value' => 'Option Value',
            'autoload' => 'Autoload',
        ];
    }
}
