<?php
namespace app\models;

use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;
/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    /**
     * @var \common\models\User
     */
    private $_user;
    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Ссылка не содержит данных.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Ссылка не действительна.');
        }
        parent::__construct($config);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
        ];
    }
    
    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->password = $this->password;
        $user->removePasswordResetToken();
        return $user->save();
    }
}