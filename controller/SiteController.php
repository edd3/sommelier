<?php
namespace controller;

use sommelier\base\Controller;
use sommelier\base\App;
use sommelier\base\Exception;
use model\User;

class SiteController extends Controller
{

    public function actionIndex()
    {
        echo App::$view->render();
    }

    public function actionTest()
    {
        echo App::$view->render('test', ['a' => 'aaa']);
    }

    public function actionTest2()
    {
        echo App::$view->render();
    }

    public function actionLogin()
    {
        if (App::$router->request->method == 'POST') {//@TODO MAKE VERBS FOR CONTROLLERS INSTEAD OF IF CHECKS
            $post = $_POST; //@TODO SANITIZATION //consider filtering all post and get and accessing them via App::$request->post()/get()?
            if ((new User())->login($post)) {
                
            } else {
                
            }
            App::$router->redirect('/');
        } else {
            throw new Exception(405);
        }
    }

    public function actionLogout()
    {
        if (App::$router->request->method == 'POST') {
            session_destroy();
        } else {
            throw new Exception(405);
        }
    }

    public function actionRegister()
    {
        if (App::$router->request->method == 'POST') {//@TODO MAKE VERBS FOR CONTROLLERS INSTEAD OF IF CHECKS
            $post = $_POST; //@TODO SANITIZATION //consider filtering all post and get and accessing them via App::$request->post()/get()?
            (new User())->register($post);
            App::$router->redirect('/');
        } else {
            throw new Exception(405);
        }
    }
}
