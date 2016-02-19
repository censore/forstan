<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operations".
 *
 * @property string $id
 * @property string $user_id
 * @property string $subcategory_id
 * @property string $status_id
 * @property string $create_date
 * @property string $comment
 *
 * @property StatusTypes $status
 * @property Subcategories $subcategory
 * @property Users $user
 * @property Transactions[] $transactions
 */
class Operations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'subcategory_id', 'status_id', 'create_date'], 'required'],
            [['user_id', 'subcategory_id', 'status_id'], 'integer'],
            [['create_date'], 'safe'],
            [['comment'], 'string', 'max' => 255]
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
            'subcategory_id' => 'Subcategory ID',
            'status_id' => 'Status ID',
            'create_date' => 'Create Date',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(StatusTypes::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategories::className(), ['id' => 'subcategory_id']);
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
    public function getTransactions()
    {
        return $this->hasMany(Transactions::className(), ['operation_id' => 'id']);
    }
}
