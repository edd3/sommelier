<?php
namespace model;

use sommelier\base\Model;
use sommelier\base\App;
use sommelier\base\Exception;

class User extends Model
{

    public function attributes()
    {
        return [
            'id' => ['type' => 'integer',
            ],
            'is_admin' => ['type' => 'integer',
            ],
            'username' => ['type' => 'string',
                'required' => true,
                'max_length' => 127
            ],
            'first_name' => ['type' => 'string',
                'max_length' => 127
            ],
            'last_name' => ['type' => 'string',
                'max_length' => 127
            ],
            'password' => ['type' => 'password',
                'required' => true,
                'max_length' => 255
            ],
            'email' => ['type' => 'email',
                'required' => true,
                'max_length' => 255
            ],
            'activation_code' => ['type' => 'string',
                'max_length' => 64
            ],
            'status' => ['type' => 'integer',
            ],
            'cnt' => ['type' => 'integer',
                'non-db' => true
            ]
        ];
    }

    public function tableName()
    {
        return 'user';
    }

    public static function className()
    {
        return __CLASS__;
    }

    public function filters()
    {
        return[
            'active' => [
                'status=1',
            ]
        ];
    }

    public function login($post)//@TODO STATUS
    {
        $user = $this->validate($post);
        if (!$user) {
            $_SESSION['error']['form']['Login'] = '<b>Wrong username or password.</b>';
            return false;
        } else {
            $_SESSION['userId'] = $user->id;
            return true;
        }
    }

    public function validate($post)
    {
        if (isset($post['User']) && isset($post['User']['email']) && isset($post['User']['password'])) {
            $userInfo = $post['User'];
            $email = $userInfo['email']; //@TODO STERLIZIATION
            $password = $userInfo['password'];
            $user = (new User)->select()->where('email="' . $email . '"')->q();
            if ($user) {
                if (password_verify($password, $user[0]->password)) {
                    return $user[0];
                } else {
                    
                }
            } else {
                
            }
            return false;
        } else {
            throw new Exception(400, 'Error in the request');
        }
    }

    public function register($post)
    {
        $post = $post['User'];
        $user = (new User)->select()->where('username="' . $post['username'] . '" or email="' . $post['email'] . '"')->q();
        if ($user) {
            $_SESSION['error']['form']['Register'] = '<b>Please use different username and/or email.</b>';
            return false;
        }


        $user = (new User)->load($post); //@TODO disable is_admin, status and activation via load() function using attribute properties
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
        $user->save();
    }
    
    public function imageCount(){
        $cnt=(new Image())->select()->where('user_id='.$this->id)->filter('active')->count();
        return $cnt;
    }
}
