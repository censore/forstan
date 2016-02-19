<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balances".
 *
 * @property string $id
 * @property string $account_id
 * @property string $currency_id
 * @property string $value
 *
 * @property Accounts $account
 * @property Currencies $currency
 */
class Balances extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'balances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'currency_id', 'value'], 'required'],
            [['account_id', 'currency_id'], 'integer'],
            [['value'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'currency_id' => 'Currency ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Accounts::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }
}
