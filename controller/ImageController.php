<?php
namespace controller;

use sommelier\base\Controller;
use sommelier\base\App;
use model\Image;
use sommelier\base\Exception;

class ImageController extends Controller
{

    public function actionIndex()
    {
        $this->actionPage();
    }

    public function actionPage()
    {
        $maxImages = (new Image())->select()->filter('active')->count();
        $perpage = 10;
        $maxPages = ceil($maxImages / $perpage);
        $page = App::$router->request->segment(2);
        if ($page === null) {
            $page = 1;
        }
        if ($page < 1 || $page > $maxPages) {
            throw new Exception(404);
        }

        $images = (new Image())->select()->filter('active')->limit($perpage)->orderBy('id desc')->offset(($page - 1) * $perpage)->q();
        echo App::$view->render('list', ['page' => $page, 'images' => $images, 'page' => $page, 'maxPages' => $maxPages]);
    }

    public function actionView()
    {
        $rawUrl = App::$router->request->segment(2);
        if (!$rawUrl) {//@TODO I dont like this
            throw new Exception(400, 'Image ID missing.');
        }
        $url = preg_replace("/[^a-zA-Z0-9]+/", "", $rawUrl); //@TODO Filtering should be 'native' @ model class and router
        if ($url != $rawUrl) {
            throw new Exception(400, 'Unexpected character found in the image ID.'); //@TODO please refer to the comments above
        }
        if ($url) {
            $image = (new Image())->select()->where('url="' . $url . '"')->filter('active')->q();
            if ($image) {
                $image = $image[0];
                echo App::$view->render('view', ['image' => $image, 'comments' => $image->comments()]);
            } else {
                throw new Exception(404, 'No image found.');
            }
        }
    }

    public function actionAddComment()//@TODO I NEED TO CHANGE THE STUFF HERE, THIS IS ALMOST A COPY-PASTE OF THE FUNCTION ABOVE :/
    {
        if (!App::$identity->isLogged()) {//@TODO FILTERS FILTERS AND MORE FILTERS
            $rawUrl = App::$router->request->segment(2);
            if (!$rawUrl) {//@TODO I dont like this
                throw new Exception(400, 'Image ID missing.');
            }
            $url = preg_replace("/[^a-zA-Z0-9]+/", "", $rawUrl); //@TODO Filtering should be 'native' @ model class and router
            if ($url != $rawUrl) {
                throw new Exception(400, 'Unexpected character found in the image ID.'); //@TODO please refer to the comments above
            }
            $comment = '';
            if (isset($_POST['Comment']['comment'])) {
                $comment = trim(htmlentities(isset($_POST['Comment']['comment']))); //@TODO FILTERS
            }
            if (!$comment) {
                throw new Exception(400, 'Comment is empty.');
            }
            if ($url) {
                $image = (new Image())->select()->where('url="' . $url . '"')->filter('active')->q();
                if ($image) {
                    if ($image[0]->countComments() < 10) {
                        $image = $image[0];
                        $comment = new \model\Comment();
                        $comment->createNew($image);
                        App::$router->redirect('/image/view/' . $image->url);
                    } else {
                        throw new Exception(500, 'Only ten comments are available per image.');
                    }
                } else {
                    throw new Exception(400, 'You\'re trying to comment an non-existing image.');
                }
            }
        } else {
            throw new Exception(500, 'You must be logged in.');
        }
    }

    public function actionUpload()
    {
        if (App::$identity->isLogged()) {//@TODO
            if (App::$identity->user()->imageCount() < 10) {
                //@TODO generate a thumbnail
                if (App::$router->request->method == 'POST') {//@TODO
                    $image = new Image();
                    $image->upload();
                    App::$router->redirect('/');
                } else {
                    echo App::$view->render('upload');
                }
            } else {
                throw new Exception(400, 'You can\'t upload more than 10 images.');
            }
        } else {
            throw new Exception(500, 'You must be logged in.');
        }
    }
}
