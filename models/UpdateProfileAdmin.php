<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class UpdateProfileAdmin
 * @package app\models
 */

class UpdateProfileAdmin extends Model
{

    public $login;
    public $email;
    public $password;
    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This login has already been taken.'],
            ['login', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * Сохранение изображения.
     */

    private function saveImage($user)
    {

        if (!is_null($this->image)) {

            $randomPath = Yii::$app->security->generateRandomString();

            $this->image->saveAs("uploads/{$randomPath}.{$this->image->extension}");

            $user->photo_link = '/uploads/' . $randomPath . '.' . $this->image->extension;
        }

    }

    /**
     * Обновление фотографии и данный о пользователе.
     */

    public function updateProfile()
    {

        if (!is_null(Yii::$app->user->identity->photo_link) && !is_null($this->image)) {
            deleteFile(Yii::$app->user->identity->photo_link);
        }

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        /**
         * Сохранение изображения.
         */

        $this->saveImage($user);

        $user->login = $this->login;
        $user->email = $this->email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);

        $user->update();
    }

    public function upload()
    {
        if (!is_null(Yii::$app->user->identity->photo_link) && !is_null($this->image)) {
            deleteFile(Yii::$app->user->identity->photo_link);
        }

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();

        /**
         * Сохранение изображения.
         */

        $this->saveImage($user);

        $user->update();
    }

}


