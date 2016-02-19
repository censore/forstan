<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property string $id
 * @property string $type_id
 * @property string $name
 *
 * @property CategoryTypes $type
 * @property Subcategories[] $subcategories
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'name'], 'required'],
            [['type_id'], 'integer'],
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
            'type_id' => 'Type ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(CategoryTypes::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategories()
    {
        return $this->hasMany(Subcategories::className(), ['category_id' => 'id']);
    }
}
