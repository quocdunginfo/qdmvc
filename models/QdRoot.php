<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:45 PM
 */
class QdRoot extends ActiveRecord\Model
{
    /*
    protected static $fields_config = array(
        //SAMPLE FIELD CONFIG
        '_product_cat_name' => array(
            'Name' => 'product_cat_name',
            'Caption' => array('en' => 'Product Cat Name', 'vn' => 'Tên loại SP'),
            'DataType' => 'Text',//'Image', 'Date'
            'FieldClass' => 'FlowField',
            'FieldClass_FlowField' => array(
                'Method' => 'Lookup',
                'Table' => 'QdProductCat',
                'Field' => 'name',
                'TableFilter' =>  array(
                    0 => array(
                        'Field' => 'id',
                        'Type' => 'FIELD',
                        'Value' => 'product_cat_id'
                    )
                )
            )
        )
    );*/
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

    protected $fields_validation = array(
        'error' => array()//'error' => array('msg' => 'MSG', 'type' => 'success')
    );

    protected function pushValidateError($msg, $type='error')
    {
        array_push($this->fields_validation['error'], array('msg' => $msg, 'type' => $type));
    }

    private $_xRec = null;

    protected function xRec()
    {
        if ($this->_xRec == null) {
            if($this->id>0)
            {
                $this->_xRec = static::GET($this->id);
            }
            else
            {
                $this->_xRec = null;
            }
        }
        return $this->_xRec;
    }

    public function GETVALIDATION()
    {
        return $this->fields_validation['error'];
    }

    public function VALIDATE()
    {
        //call validate trigger on all fields and then return array of error
        foreach (static::$fields_config as $key => $config) {
            if (method_exists($this, $key . 'OnValidate')) {
                $this->{$key . 'OnValidate'}();
            }
            /*
            try {
                $this->{$key . 'OnValidate'}();
            }catch (Exception $ex)
            {

            }*/
        }
        foreach($this->fields_validation['error'] as $item)
        {
            if($item['type']=='error')
            {
                return false;
            }
        }
        return true;
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
        return static::$fields_config[$field_name]['name'];
    }

    public static function GET($id=1)
    {
        if(static::exists($id))
        {
            return static::find($id);
        }
        return null;
    }

    /**
     * @param $field_name
     * @return mixed
     */
    public static function getDataType($field_name)
    {
        try {
            return static::$fields_config[$field_name]['DataType'];
        } catch (Exception $ex) {
            return 'Text';
        }

    }

    public static function getTableRelation($field_name)
    {
        try {
            return static::$fields_config[$field_name]['TableRelation']['Table'];
        } catch (Exception $ex) {
            return '';
        }
    }

    protected $record_filter = array(
        'filter_default' => array(),//array('field' => 'value_filter');
        'filter' => array(),//array('field' => array('value' => 'value_filter', 'exact' => true));
        'limit' => 10,
        'offset' => 0,
        'order' => array('field' => 'id', 'direction' => 'asc'),//true: asc, false: desc
        //Since 01032015
        'filter_raw' => '1=1 OR 2=2',//raw SQL Condition
        'filter_relation' => 'AND'
    );

    public function SETFILTERDEFAULT($filter = array())
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
    public function SETRANGE($field, $value, $exact = true)
    {
        $this->record_filter['filter'][$field]['value'] = $value;
        $this->record_filter['filter'][$field]['exact'] = $exact;
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

    public function SETFILTERRELATION($relation = 'AND')
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
        if ($ff_config['Method'] == 'Lookup') {
            $ff_config_tf = $ff_config['TableFilter'];
            $c = new $ff_config['Table'];//init new object

            foreach ($ff_config_tf as $filter_item) {
                if ($filter_item['Type'] == 'FIELD') {
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
        if (is_array($record['filter']) && count($record['filter']) > 0) {
            $where = '';
            foreach ($record['filter'] as $key => $value) {
                if ($value['exact'] == true) {
                    $where .= "`{$key}` = '{$value['value']}' " . $record['filter_relation'] . " ";//quocdunginfo
                } else {
                    $where .= "`{$key}` LIKE '%{$value['value']}%' " . $record['filter_relation'] . " ";//quocdunginfo
                }
            }
            if (strtoupper($record['filter_relation']) == 'AND') {
                $where .= '1=1';
            } else {
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
        if (is_array($record)) {
            if (is_array($record['filter']) && count($record['filter']) > 0) {
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

    protected static $fields_config = array();
    protected static $lookup_fields = null;

    protected static function ISLOOKUPFIELD($field_name)
    {
        try {
            return static::$fields_config[$field_name]['TableRelation']['Table'] != '';
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getLookupFields()
    {
        if (static::$lookup_fields != null) {
            return static::$lookup_fields;
        } else {
            static::$lookup_fields = array();
            foreach (static::$fields_config as $field => $config) {
                if (static::ISLOOKUPFIELD($field)) {
                    array_push(static::$lookup_fields, $field);
                }
            }
            return static::$lookup_fields;
        }
    }

    public static function getFieldCaption($field_name, $lang = 'en')
    {
        try {
            if (isset(static::$fields_config[$field_name]) && !isset(static::$fields_config[$field_name]['Caption'])) {
                return '@'.$field_name;
            } else {
                return static::$fields_config[$field_name]['Caption'][$lang];
            }
        } catch (Exception $ex) {
            return Qdmvc_Helper::getNoneText();
        }

    }

    public static function getFieldsConfig()
    {
        return static::$fields_config;
    }

    public static function ISREADONLY($f_name)
    {
        try {
            return (static::$fields_config[$f_name]['ReadOnly'] || static::ISFLOWFIELD($f_name));
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function ISFLOWFIELD($flowfield_name)
    {
        try {
            return static::$fields_config[$flowfield_name]['FieldClass'] == 'FlowField';
        } catch (Exception $ex) {
            return false;
        }
    }

    public function __get($field_name)
    {
        if (static::ISFLOWFIELD($field_name)) {
            //check cached value
            if (is_array($this->qd_flowfields_attr) && isset($this->qd_flowfields_attr[$field_name])) {
                return $this->qd_flowfields_attr[$field_name];
            } else {
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
            foreach (static::getFieldsConfig() as $key => $value) {
                $arr[$key] = $item->$key;
            }
            array_push($tmp, $arr);
        }
        return $tmp;
    }
    public function save($validate = true)
    {
        if($this->VALIDATE())
        {
            return parent::save($validate);
        }
        else
        {
            return false;
        }
    }
}