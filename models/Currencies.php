<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 *
 * @property Balances[] $balances
 * @property Transactions[] $transactions
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalances()
    {
        return $this->hasMany(Balances::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transactions::className(), ['currency_id' => 'id']);
    }
}
