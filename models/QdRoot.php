<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:45 PM
 */
class QdRoot extends ActiveRecord\Model
{
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

    protected static function  addFieldConfig()
    {

    }
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

    protected $record_filter = array(
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
        $this->record_filter['filter_default'] = $filter;
        return $this->SETFILTER($filter);
    }
    public function REMOVEFILTERDEFAULT()
    {
        return $this->SETFILTERDEFAULT(array());
    }
    public function REMOVEFILTER()
    {
        $this->record_filter['filter'] = $this->record_filter['filter_default'];
        return $this;
    }

    /**
     * @param $limit
     */
    public function SETLIMIT($limit)
    {
        $this->record_filter['limit'] = $limit;
        return $this;
    }

    /**
     *
     */
    public function REMOVELIMIT()
    {
        $this->record_filter['limit'] = -1;
        return $this;
    }

    /**
     *
     */
    public function REMOVEOFFSET()
    {
        $this->record_filter['offset'] = -1;
        return $this;
    }

    /**
     * @param $offset
     */
    public function SETOFFSET($offset)
    {
        $this->record_filter['offset'] = $offset;
        return $this;
    }

    /**
     * @param $field
     * @param string $asc
     */
    public function SETORDERBY($field, $asc = 'asc')
    {
        $this->record_filter['order'] = array('field' => $field, 'direction' => $asc);
        return $this;
    }

    /**
     * @param $field
     * @param $value
     */
    public function SETRANGE($field, $value)
    {
        $this->record_filter['filter'][$field] = $value;
        return $this;
    }

    /**
     * array($key => $value)
     *
     * @param $where_array
     */
    public function SETFILTER($where_array)
    {
        $this->record_filter['filter'] = $where_array;
        return $this;
    }
    public function SETFILTERRELATION($relation='AND')
    {
        $this->record_filter['filter_relation'] = $relation;
        return $this;
    }
    public function REMOVEFILTERRELATION()
    {
        $this->record_filter['filter_relation'] = 'AND';
        return $this;
    }
    /**
     * @param $field
     */
    public function REMOVERANGE($field)
    {
        unset($this->record_filter['filter'][static::getPF($field)]);
        return $this;
    }
    protected $qd_flowfields_attr = array();
    protected function CALCFIELDS($flowfield_name)
    {
        $ff_config = static::$fields_config[$flowfield_name]['FieldClass_FlowField'];
        if($ff_config['Method']=='Lookup')
        {
            $ff_config_tf = $ff_config['TableFilter'];
            $c = new $ff_config['Table'];//init new object

            foreach($ff_config_tf as $filter_item)
            {
                if($filter_item['Type']=='FIELD') {
                    $c->SETRANGE($filter_item['Field'], $this->{$filter_item['Value']});
                }
            }
            //cache
            $this->qd_flowfields_attr[$flowfield_name] = $c->GETLIST()[0]->{$ff_config['Field']};
            //return
            return $this->qd_flowfields_attr[$flowfield_name];
        }
    }


    /**
     * @return int
     */
    public function COUNTLIST()
    {
        return static::count(array('conditions' => static::_generateConditionsArray($this->record_filter)));
    }

    /**
     * @return array
     */
    public function GETLIST()
    {
        return static::all(static::_generateQuery($this->record_filter));
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
    protected static $fields_config = array(

    );
    public static function  getFieldsConfig()
    {
        return static::$fields_config;
    }
    protected static function ISFLOWFIELD($flowfield_name)
    {
        if(
        isset(static::$fields_config[$flowfield_name])
        )
        {
            $config = static::$fields_config[$flowfield_name];
            if ($config['FieldClass'] == 'FlowField' && !empty($config['FieldClass_FlowField'])){
                return true;
            }
        }
        return false;
    }
    public function __get($field_name)
    {
        if(static::ISFLOWFIELD($field_name))
        {
            //check cached value
            if(is_array($this->qd_flowfields_attr) && isset($this->qd_flowfields_attr[$field_name]))
            {
                return $this->qd_flowfields_attr[$field_name];
            }
            else {
                //CALC FlowField First
                return $this->CALCFIELDS($field_name);
            }
        }
        return parent::__get($field_name);
    }
    public static function toJSON($list)
    {
        $tmp = array();
        foreach ($list as $item) {
            $arr = array();
            foreach(static::getFieldsConfig() as $key => $value)
            {
                if(isset($value['FieldClass']) && $value['FieldClass']=='FlowField')
                {
                    $arr[$key] = $item->$key;
                }
                else
                {
                    //Normal Field
                    $arr[$key] = $item->$key;
                }
            }
            array_push($tmp, $arr);
        }
        return $tmp;
    }
}