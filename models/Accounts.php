<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accounts".
 *
 * @property string $id
 * @property string $user_id
 * @property string $type_id
 * @property string $open_date
 * @property string $description_ru
 * @property string $description_he
 * @property string $description_en
 *
 * @property AccountTypes $type
 * @property Users $user
 * @property Balances[] $balances
 * @property Transactions[] $transactions
 * @property Transactions[] $transactions0
 */
class Accounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id', 'open_date'], 'required'],
            [['user_id', 'type_id'], 'integer'],
            [['open_date'], 'safe'],
            [['description_ru', 'description_he', 'description_en'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type_id' => 'Type ID',
            'open_date' => 'Open Date',
            'description_ru' => 'Description Ru',
            'description_he' => 'Description He',
            'description_en' => 'Description En',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(AccountTypes::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalances()
    {
        return $this->hasMany(Balances::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transactions::className(), ['from_account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions0()
    {
        return $this->hasMany(Transactions::className(), ['to_account_id' => 'id']);
    }
}
