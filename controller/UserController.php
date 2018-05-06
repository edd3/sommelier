<?php
namespace controller;

use sommelier\base\Controller;
use sommelier\base\App;
use model\User;
use sommelier\base\Exception;

class UserController extends Controller
{

    public function actionIndex()
    {
        $this->actionPage();
    }

    public function actionPage()
    {
        $maxUsers = (new User())->select()->filter('active')->count();
        $perpage = 10;
        $maxPages = ceil($maxUsers / $perpage);
        $page = App::$router->request->segment(2);
        if ($page === null) {
            $page = 1;
        }
        if ($page < 1 || $page > $maxPages) {
            throw new Exception(404);
        }

//        $users = (new User())->select()->filter('active')->limit($perpage)->orderBy('id desc')->offset(($page - 1) * $perpage)->q();
        $users = (new User())->raw('SELECT u.*, COUNT(*) cnt FROM image i, user u where i.user_id=u.id GROUP BY user_id order by cnt desc')->q();
        echo App::$view->render('list', ['page' => $page, 'users' => $users, 'page' => $page, 'maxPages' => $maxPages]);
    }
}
