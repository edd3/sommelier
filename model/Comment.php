<?php
namespace model;

use sommelier\base\Model;
use sommelier\base\App;
use sommelier\base\Exception;

class Comment extends Model
{

    public function attributes()
    {
        return [
            'id' => ['type' => 'integer',
            ],
            'image_id' => ['type' => 'integer',
                'required' => true,
            ],
            'user_id' => ['type' => 'integer',
                'required' => true,
            ],
            'date' => ['type' => 'integer',
                'required' => true,
            ],
            'comment' => ['type' => 'string',
                'required' => true,
                'max_length' => 4096
            ],
            'deleted' => ['type' => 'integer',
                'default' => 0
            ],
        ];
    }

    public function tableName()
    {
        return 'comment';
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

    public function user()
    {
        return (new User())->select()->where('id=' . $this->user_id)->q()[0];
    }

    public function image()
    {
        return (new Image())->select()->where('id=' . $this->image_id)->q()[0];
    }

    public function createNew($image)
    {
        $this->comment = $_POST['Comment']['comment'];
        $this->image_id = $image->id;
        $this->user_id = App::$identity->user()->id;
        $this->date = time();
        $this->save();
    }
}
