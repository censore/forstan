<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account_types".
 *
 * @property string $id
 * @property string $value
 *
 * @property Accounts[] $accounts
 */
class AccountTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Accounts::className(), ['type_id' => 'id']);
    }
}
