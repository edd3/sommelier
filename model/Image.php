<?php
namespace model;

use sommelier\base\Model;
use sommelier\base\App;
use sommelier\base\Exception;

class Image extends Model
{

//    public $id;
//    public $user_id;
//    public $date;
//    public $file;
//    public $name;
//    public $deleted;
//    public $url;
//    public $approved;

    public function attributes()
    {
        return [
            'id' => ['type' => 'integer',
                'required' => true,
            ],
            'user_id' => ['type' => 'integer',
                'required' => true,
            ],
            'date' => ['type' => 'integer',
                'required' => true,
            ],
            'file' => ['type' => 'string',
                'required' => true,
                'max_length' => 255
            ],
            'name' => ['type' => 'string',
                'required' => true,
                'max_length' => 255
            ],
            'url' => ['type' => 'string',
                'required' => true,
                'max_length' => 255
            ],
            'deleted' => ['type' => 'integer',
                'required' => true,
            ],
            'approved' => ['type' => 'integer',
                'required' => true,
            ]
        ];
    }

    public function tableName()
    {
        return 'image';
    }

    public static function className()
    {
        return __CLASS__;
    }

    public function filters()
    {
        return[
            'active' => [
                'deleted=0',
            ]
        ];
    }

    public function show()
    {
        return '<img src="/images/' . $this->file . '" class="rounded" alt="' . $this->name . '">';
    }

    public function user()
    {
        return (new User())->select()->where('id=' . $this->user_id)->q()[0];
    }

    public function comments()
    {
        return (new Comment())->select()->where('image_id=' . $this->id)->filter('active')->orderBy('id')->q();
    }

    public function countComments()
    {
        return (new Comment())->select()->where('image_id=' . $this->id)->filter('active')->orderBy('id')->count();
    }

    public function upload()
    {
        $target_dir = App::$mainDir . 'web/images/';

        $newFileName = bin2hex(openssl_random_pseudo_bytes(20)); //@TODO check collision
        $url = bin2hex(openssl_random_pseudo_bytes(10)); //@TODO check collision

        preg_match('/\.[0-9a-z]+$/', $_FILES["uploadfile"]["name"], $extension);
        $extension = $extension[0];

        if (getimagesize($_FILES["uploadfile"]["tmp_name"]) == false) {
            throw new Exception(500, 'You can only upload image files');
        }
        if ($_FILES["uploadfile"]["size"] > 10000000) {
            throw new Exception(500, 'Image file too large.');
        }

        if (!move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_dir . $newFileName . $extension)) {
            throw new Exception(500, 'Error on uploading.');
        }
        $this->user_id = App::$identity->user()->id;
        $this->url = $url;
        $this->file = $newFileName . $extension;
        $this->name = $_POST['Image']['name'];
        $this->date = time();
        $this->save();
    }
}
