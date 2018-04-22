<?php

namespace app\models;

use kartik\password\StrengthValidator;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PasswordForm extends Model
{

    public $password;




    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['password'], 'required'],
            [['password'], StrengthValidator::className(),'hasEmail' =>false  ,'hasUser' => false,'min'=>8, 'digit'=>4, 'special'=>3,'upper'=>2,'lower' => 2,'max' => 15]

        ];
    }

}
