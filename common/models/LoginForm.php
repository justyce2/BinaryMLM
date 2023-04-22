<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            // username is validated by validatePayment()
            ['username', 'validatePayment'],
        ];
    }
    
    public function validatePayment($attribute, $params) {
        if (!$this->hasErrors()) {
            $uInfo = \frontend\models\User::find()->joinWith(['userPackages'])->where(['username' => $this->username])->one();
            if(!empty($uInfo) && ($uInfo->user_role!=2)) {
                if(!empty($uInfo->userPackages) && ($uInfo->userPackages[0]->payment_status=='Pending')) {
                    //$this->addError($attribute, 'You payment is awaiting for verification. Your account will be activated after verification.');
                }
            }
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }
    
     public function logins($user)
    {
    	if (Yii::$app->user->identity->user_role==2  && $user) {
          $this->rememberMe = "";
           return Yii::$app->user->login($this->getUserAdmin($user), $this->rememberMe ? 3600 * 24 * 30 : 0);
           
        }
       return false; 
    }
 protected function getUserAdmin($user)
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($user);
        }

        return $this->_user;
    }
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
