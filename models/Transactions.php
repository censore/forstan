<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property string $id
 * @property string $operation_id
 * @property string $from_account_id
 * @property string $to_account_id
 * @property string $currency_id
 * @property string $amount
 * @property string $date
 *
 * @property Currencies $currency
 * @property Accounts $fromAccount
 * @property Operations $operation
 * @property Accounts $toAccount
 */
class Transactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operation_id', 'currency_id', 'amount', 'date'], 'required'],
            [['operation_id', 'from_account_id', 'to_account_id', 'currency_id'], 'integer'],
            [['amount'], 'number'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operation_id' => 'Operation ID',
            'from_account_id' => 'From Account ID',
            'to_account_id' => 'To Account ID',
            'currency_id' => 'Currency ID',
            'amount' => 'Amount',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromAccount()
    {
        return $this->hasOne(Accounts::className(), ['id' => 'from_account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operations::className(), ['id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToAccount()
    {
        return $this->hasOne(Accounts::className(), ['id' => 'to_account_id']);
    }
}
