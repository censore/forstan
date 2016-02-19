<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $type_id
 * @property string $login
 * @property string $password
 * @property string $create_date
 * @property string $name_ru
 * @property string $name_he
 * @property string $name_en
 * @property string $comment
 * @property string $hash
 *
 * @property Accounts[] $accounts
 * @property Operations[] $operations
 * @property UserTypes $type
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'login', 'password', 'create_date'], 'required'],
            [['type_id'], 'integer'],
            [['create_date'], 'safe'],
            [['login', 'name_ru', 'name_he', 'name_en', 'comment'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 32],
            [['hash'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'login' => 'Login',
            'password' => 'Password',
            'create_date' => 'Create Date',
            'name_ru' => 'Name Ru',
            'name_he' => 'Name He',
            'name_en' => 'Name En',
            'comment' => 'Comment',
            'hash' => 'Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Accounts::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations()
    {
        return $this->hasMany(Operations::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(UserTypes::className(), ['id' => 'type_id']);
    }
}
