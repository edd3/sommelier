<?php
namespace sommelier\base;

class Model
{

    private $query;
    private $preQuery;

    public function attributes()
    {
        
    }

    public static function className()
    {
        return __CLASS__;
    }

    public function tableName()
    {
        return '%TABLE NAME%';
    }

    public function filters()
    {
        return[
        ];
    }

    private function orderQuery()
    {
        $arr = ['select', 'from', 'where', 'order by', 'limit', 'offset'];
        $newPreQuery = [];
        foreach ($arr as $k => $v) {
            if (isset($this->preQuery[$v])) {
                $newPreQuery[$v] = $this->preQuery[$v];
            }
        }
        $this->preQuery = $newPreQuery;
    }

    private function createQuery()
    {
        if (!$this->query) {
            $this->orderQuery();
            $arr = [];
            foreach ($this->preQuery as $k => $v) {

                $arr[] = $k;
                if (!is_array($v)) {
                    $arr[] = $v;
                } else {
                    $arr[] = implode($v, ' and ');
                }
            }
            $this->query = implode($arr, ' ');
        }
    }

    public function select($select = '*')
    {
        $this->preQuery['select'] = $select;
        $this->preQuery['from'] = $this->tableName();

        return $this;
    }

    public function filter($filter)
    {
        if ($this->filters()[$filter]) {
            $this->preQuery['where'][] = $this->filters()[$filter][0];
            return $this;
        } else {
            throw new Exception(500, "You're trying to use a non-existing filter.");
        }
    }

    public function where($str)
    {
        $this->preQuery['where'][] = $str;
        return $this;
    }

    public function limit($n = 10)
    {
        if (is_numeric($n)) {
            $this->preQuery['limit'] = $n;
            return $this;
        } else {
            throw new Exception(500, 'Only numbers allowed for limit($n).');
        }
    }

    public function offset($n = 0)
    {
        if (is_numeric($n)) {
            $this->preQuery['offset'] = $n;
            return $this;
        } else {
            throw new Exception(500, 'Only numbers allowed for limit($n).');
        }
    }

    public function orderBy($orderBy)
    {
        $this->preQuery['order by'] = $orderBy;
        return $this;
    }

    public function load($arr)
    {
        foreach ($this->attributes() as $k => $v) {
            if (isset($arr[$k])) {
                $this->{$k} = $arr[$k];
            }
        }
        return $this;
    }

    public function count()
    {
        $this->preQuery['select'] = 'count(*) as cnt';

        $this->createQuery();

        return $this->inquire()[0]['cnt'];
    }

    public function q()
    {
        $this->createQuery();
        $ret = false;
        foreach ($this->inquire() as $k => $v) {
            $class = static::className();
            $ret[] = (new $class)->load($v);
        }
        return $ret;
    }

    public function inquire()
    {
        if (!$result = App::$db->query($this->query)) {
            throw new Exception(500, 'MySql error!<br>Querry: ' . $this->query . '<br>' . App::$db->Errno . '<br>' . App::$db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function raw($sql)
    {
        $this->query = $sql;
        return $this;
    }

    public function save()//@TODO VALIDATION
    {
        $attr = [];
        foreach ($this->attributes() as $k => $a) {
            if (isset($a['non-db']) && $a['non-db']) {
                
            } else {
                if (isset($this->{$k})) {
                    $attr[$k] = htmlspecialchars($this->{$k}, ENT_QUOTES, 'UTF-8');
                } else if (isset($a['default'])) {
                    $attr[$k] = $a['default'];
                }
            }
        }
        $columns = '`' . implode('`,`', array_keys($attr)) . '`';
        $values = '\'' . implode('\',\'', $attr) . '\'';
        $this->raw('INSERT INTO `' . static::tableName() . '` (' . $columns . ') VALUES (' . $values . ')');
        if (!$result = App::$db->query($this->query)) {
            throw new Exception(500, 'MySql error!<br>Querry: ' . $this->query . '<br>' . App::$db->error);
        }
    }
}
