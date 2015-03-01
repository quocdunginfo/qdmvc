<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:45 PM
 */
class QdRoot extends ActiveRecord\Model
{
    static $table_name = 'mpd_';

    # explicit pk since our pk is not "id"
    static $primary_key = 'id';

    static $before_update = array('on_before_update'); # new records only

    /**
     *
     */
    public function on_before_update()
    {
        $this->date_modified = new DateTime();
    }

    static $before_create = array('on_before_create'); # new records only

    /**
     *
     */
    public function on_before_create()
    {
        $this->date_created = new DateTime();
    }

    /**
     * @param $list
     * @return mixed|string|void
     */
    public static function toJSON($list)
    {
        $tmp = array();
        $count = 0;
        foreach ($list as $item) {
            $tmp[$count] = array();
            $tmp[$count]['id'] = $item->id;
            $count++;
        }
        return json_encode($tmp);
    }
    protected static $fields = array(
        'id' => array(
            'name' => 'id',
            'caption' => 'ID'
        )
    );

    /**
     * @return string
     */
    public static function getTbName()
    {
        return static::$table_name;
    }

    /**
     * @param $field_name
     * @return mixed
     */
    public static function getPF($field_name)//get Physical Field
    {
        return static::$fields[$field_name]['name'];
    }

    /**
     * @param $field_name
     * @return mixed
     */
    public static function getType($field_name)
    {
        if (array_key_exists('type', static::$fields[$field_name]))
        {
            return static::$fields[$field_name]['type'];
        }
    }

    protected $record = array(
        'filter_default' => array(),//array('field' => 'value_filter');
        'filter' => array(),//array('field' => 'value_filter');
        'limit' => 10,
        'offset' => 0,
        'order' => array('field' => 'id', 'direction' => 'asc'),//true: asc, false: desc
        //Since 01032015
        'filter_raw' => '1=1 OR 2=2',//raw SQL Condition
        'filter_relation' => 'AND'
    );
    public function SETFILTERDEFAULT($filter=array())
    {
        $this->record['filter_default'] = $filter;
        return $this->SETFILTER($filter);
    }
    public function REMOVEFILTERDEFAULT()
    {
        return $this->SETFILTERDEFAULT(array());
    }
    public function REMOVEFILTER()
    {
        $this->record['filter'] = $this->record['filter_default'];
        return $this;
    }

    /**
     * @param $limit
     */
    public function SETLIMIT($limit)
    {
        $this->record['limit'] = $limit;
        return $this;
    }

    /**
     *
     */
    public function REMOVELIMIT()
    {
        $this->record['limit'] = -1;
        return $this;
    }

    /**
     *
     */
    public function REMOVEOFFSET()
    {
        $this->record['offset'] = -1;
        return $this;
    }

    /**
     * @param $offset
     */
    public function SETOFFSET($offset)
    {
        $this->record['offset'] = $offset;
        return $this;
    }

    /**
     * @param $field
     * @param string $asc
     */
    public function SETORDERBY($field, $asc = 'asc')
    {
        $this->record['order'] = array('field' => $field, 'direction' => $asc);
        return $this;
    }

    /**
     * @param $field
     * @param $value
     */
    public function SETRANGE($field, $value)
    {
        $this->record['filter'][$field] = $value;
        return $this;
    }

    /**
     * array($key => $value)
     *
     * @param $where_array
     */
    public function SETFILTER($where_array)
    {
        $this->record['filter'] = $where_array;
        return $this;
    }
    public function SETFILTERRELATION($relation='AND')
    {
        $this->record['filter_relation'] = $relation;
        return $this;
    }
    public function REMOVEFILTERRELATION()
    {
        $this->record['filter_relation'] = 'AND';
        return $this;
    }
    /**
     * @param $field
     */
    public function REMOVERANGE($field)
    {
        unset($this->record['filter'][static::getPF($field)]);
        return $this;
    }

    /**
     * @return int
     */
    public function COUNTLIST()
    {
        return static::count(array('conditions' => static::_generateConditionsArray($this->record)));
    }

    /**
     * @return array
     */
    public function GETLIST()
    {
        return static::all(static::_generateQuery($this->record));
    }

    /**
     * @param $record
     * @return array
     */
    protected static function _generateConditionsArray($record)
    {
        if(is_array($record['filter']) && count($record['filter'])>0) {
            $where = '';
            foreach ($record['filter'] as $key => $value) {
                $where .= "`{$key}` LIKE '%{$value}%' ".$record['filter_relation']." ";
            }
            if(strtoupper($record['filter_relation'])=='AND')
            {
                $where .= '1=1';
            }
            else
            {
                $where .= '1=2';
            }
            return array($where);
        }
        return array();
    }

    /**
     * @param $record
     * @return array
     */
    protected static function _generateQuery($record)
    {
        $re = array();
        if(is_array($record)) {
            if(is_array($record['filter']) && count($record['filter'])>0) {
                $re['conditions'] = static::_generateConditionsArray($record);
            }
            if ($record['limit'] > 0) {
                $re['limit'] = $record['limit'];
            }
            if ($record['offset'] > 0) {
                $re['offset'] = $record['offset'];
            }
            if (is_array($record['order']) && count($record['order']) > 0) {
                $re['order'] = $record['order']['field'] . ' ' . $record['order']['direction'];
            }
            return $re;
        }
        return $re;
    }
}