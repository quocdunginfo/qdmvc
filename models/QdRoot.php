<?php

/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 09/02/2015
 * Time: 10:45 PM
 */
class QdRoot extends ActiveRecord\Model
{
    protected static $fields_config = array(
        //SAMPLE FIELD CONFIG
        'id' => array(),
        '__sys_note_url' => array(
            'FieldClass' => 'System'
        ),
        '__sys_image_url' => array(
            'FieldClass' => 'System'
        ),
        '__lasteditor_name' => array(
            'Name' => '_lasteditor_name',
            'Caption' => array('en' => 'Last editor name', 'vn' => 'Sửa bởi'),
            'DataType' => 'Text',
            'FieldClass' => 'System',
        ),
        '__owner_name' => array(
            'Name' => '_lasteditor_name',
            'Caption' => array('en' => 'Owner name', 'vn' => 'Tạo bởi'),
            'DataType' => 'Text',
            'FieldClass' => 'System',
        ),
    );
    static $primary_key = 'id';

    static $before_update = array('on_before_update'); # new records only

    /**
     *
     */
    public function on_before_update()
    {
        $this->date_modified = new DateTime();
        $this->lasteditor_id = get_current_user_id();
    }

    static $before_create = array('on_before_create'); # new records only

    /**
     *
     */
    public function on_before_create()
    {
        $this->date_created = new DateTime();
        $this->owner_id = get_current_user_id();
    }

    protected static function  addFieldConfig()
    {

    }

    protected $fields_validation = array(//'0' => array('msg' => 'MSG', 'type' => 'success', 'hash' => md5)
    );

    protected function pushValidateError($field_name = '', $msg = '', $type = 'error')
    {
        $hash = md5($field_name . $msg . $type);
        /*foreach($this->fields_validation as $item)
        {
            if($item['hash']==$hash)
            {
                 return;
            }
        }
        array_push($this->fields_validation, array('field' => $field_name, 'msg' => $msg, 'type' => $type, 'hash' => $hash));*/
        $this->fields_validation[$hash] = array('field' => $field_name, 'msg' => $msg, 'type' => $type);
    }

    private $_xRec = null;

    protected function xRec()
    {
        if ($this->_xRec == null) {
            if ($this->id > 0) {
                $this->_xRec = static::GET($this->id);
            } else {
                $this->_xRec = null;
            }
        }
        return $this->_xRec;
    }

    public function GETVALIDATION()
    {
        return $this->fields_validation;
    }

    protected function OnValidate($field_name)
    {

    }

    public function VALIDATE()
    {
        $tmp = static::getFieldsConfig();
        //call validate trigger on all fields and then return array of error
        foreach ($tmp as $key => $config) {
            if (method_exists($this, $key . 'OnValidate')) {
                $this->{$key . 'OnValidate'}($key);
            }
        }
        foreach ($this->fields_validation as $item) {
            if ($item['type'] == 'error') {
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
        $config = static::getFieldsConfig();
        return $config[$field_name]['name'];
    }

    public static function GET($id = 1)
    {
        if (static::exists($id)) {
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
            $config = static::getFieldsConfig();
            return $config[$field_name]['DataType'];
        } catch (Exception $ex) {
            return 'Text';
        }

    }

    public static function getTableRelation($field_name)
    {
        try {
            $config = static::getFieldsConfig();
            return $config[$field_name]['TableRelation'];
        } catch (Exception $ex) {
            return array();
        }
    }

    protected $record_filter = array(
        'filter_default' => array(),//array('field' => array('value' => 'value_filter', 'exact' => true));
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

    public function delete($location='')
    {
        $class_name = $this->getCalledClassName();
        if($class_name!='QdLog')
        {
            $location .= "|{$class_name}|delete";
            $action = QdLog::$ACTION_DELETE;
            //write log
            $this->writeLog($action, $location);//quocdunginfo
        }

        $re = parent::delete();
        return $re;
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
    protected static function ISPK($field)
    {
        if(strtolower($field)==strtolower(static::$primary_key))
        {
            return true;
        }
        return false;
    }
    public function getImages()
    {
        $record = new QdImage();
        $record->SETRANGE('model', $this->getCalledClassName());
        $record->SETRANGE('model_id', $this->id);
        return $record;
    }
    public function SETRANGE($field, $value, $exact = true)
    {
        //ignore filter on FLOWFIELD
        if(!static::ISFLOWFIELD($field))
        {
            if(static::ISPK($field))
            {
                $exact = true;//force filter exact on PK field
            }
            $this->record_filter['filter'][$field]['value'] = $value;
            $this->record_filter['filter'][$field]['exact'] = $exact;
        }
        return $this;
    }

    public static function getInitObj()
    {
        $c = get_called_class();
        $obj = new $c();
        return $obj;
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

    protected $qd_cached_attr = array();

    protected function CALCFIELDS($flowfield_name)
    {
        $config = static::getFieldsConfig();
        $ff_config = $config[$flowfield_name]['FieldClass_FlowField'];
        if ($ff_config['Method'] == 'Lookup') {
            $ff_config_tf = $ff_config['TableFilter'];
            $c = new $ff_config['Table'];//init new object

            foreach ($ff_config_tf as $filter_item) {
                if ($filter_item['Type'] == 'FIELD') {
                    $c->SETRANGE($filter_item['Field'], $this->{$filter_item['Value']});
                }
            }
            //cache
            $tmp = $c->GETLIST();
			$this->qd_cached_attr[$flowfield_name] = $tmp[0]->{$ff_config['Field']};
            //return
            return $this->qd_cached_attr[$flowfield_name];
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
        $query = static::_generateQuery($this->record_filter);
        return static::all($query);
    }

    /**
     * @param $record
     * @return array
     */
    protected static function _generateConditionsArray($record)
    {
        if (is_array($record['filter']) && count($record['filter']) > 0) {
            $where = '';
            foreach ($record['filter'] as $key => $config) {
                if ($config['exact'] == true) {
                    $where .= "`{$key}` = '{$config['value']}' " . $record['filter_relation'] . " ";//quocdunginfo
                } else {
                    $where .= "`{$key}` LIKE '%{$config['value']}%' " . $record['filter_relation'] . " ";//quocdunginfo
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

    protected static $lookup_fields = null;

    protected static function ISLOOKUPFIELD($field_name)
    {
        try {
            $config = static::getFieldsConfig();
            return $config[$field_name]['TableRelation']['Table'] != '';
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getLookupFields()
    {
        if (static::$lookup_fields != null) {
            return static::$lookup_fields;
        } else {
            $tmp = static::getFieldsConfig();
            static::$lookup_fields = array();
            foreach ($tmp as $field => $config) {
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
            $config = static::getFieldsConfig();
            if (isset($config[$field_name]['Caption'][$lang])) {
                return $config[$field_name]['Caption'][$lang];
            }
            return '@' . $field_name;
        } catch (Exception $ex) {
            return '@' . $field_name;
            //return Qdmvc_Helper::getNoneText();
        }

    }

    public static function getFieldsConfig()
    {
        return static::$fields_config;
    }

    public static function ISREADONLY($f_name)
    {
        try {
            $config = static::getFieldsConfig();
            return ($config[$f_name]['ReadOnly'] || static::ISFLOWFIELD($f_name));
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function ISFLOWFIELD($flowfield_name)
    {
        try {
            $config = static::getFieldsConfig();
            return $config[$flowfield_name]['FieldClass'] == 'FlowField';
        } catch (Exception $ex) {
            return false;
        }
    }
    public static function ISSYSTEMFIELD($field_name='')
    {
        try {
            $config = static::getFieldsConfig();
            return $config[$field_name]['FieldClass'] == 'System';
        } catch (Exception $ex) {
            return false;
        }
    }
    public function __get($field_name)
    {
        //check cached value
        if (is_array($this->qd_cached_attr) && isset($this->qd_cached_attr[$field_name])) {
            return $this->qd_cached_attr[$field_name];
        }
        //calculate field value
        if (static::ISFLOWFIELD($field_name)) {
            //CALC FlowField First
            return $this->CALCFIELDS($field_name);
        }else if (static::ISSYSTEMFIELD($field_name)) {
            $class_name = $this->getClassName();
            //system preserved field
            if($field_name=='__sys_note_url')
            {
                return $this->qd_cached_attr[$field_name] = Qdmvc_Helper::getCompactPageListLink('note', array('model' => $class_name, 'model_id' => $this->id));
            }else if($field_name=='__sys_image_url')
            {
                return $this->qd_cached_attr[$field_name] = Qdmvc_Helper::getCompactPageListLink('image', array('model' => $class_name, 'model_id' => $this->id));
            }else if($field_name=='__lasteditor_name')
            {
                if($this->lasteditor_id >0 )
                {
                    $user_info = get_userdata($this->lasteditor_id);
                    return $this->qd_cached_attr[$field_name] = $user_info->user_login;
                }
                return Qdmvc_Helper::getNoneText();
            }else if($field_name=='__owner_name')
            {
                if($this->owner_id > 0)
                {
                    $user_info = get_userdata($this->owner_id);
                    return $this->qd_cached_attr[$field_name] = $user_info->user_login;
                }
                return Qdmvc_Helper::getNoneText();
            }
        }
        return parent::__get($field_name);
    }
    public function getCalledClassName()
    {
        return get_called_class();
    }
    public function getClassName()
    {
        return get_class($this);
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

    public function __set($name, $value)
    {
        //prevent set ERROR on 2 special type
        if(static::ISFLOWFIELD($name) || static::ISSYSTEMFIELD($name))
        {
            return $value;
        }
        return parent::__set($name, $value);
    }

    public function save($validate = true, $location='')
    {
        //replace all \" to ", to prevent " loopback when saving
        $config = static::getFieldsConfig();
        foreach ($config as $key => $value) {
            if (!static::ISFLOWFIELD($key) && !static::ISSYSTEMFIELD($key)) {
                $this->{$key} = str_replace('\\"', '"', $this->{$key});//quocdunginfo, need to find other approach
                $this->{$key} = str_replace("\\'", "'", $this->{$key});//quocdunginfo, need to find other approach
            }
        }
        //do validate and save
        if ($this->VALIDATE()) {
            $action = $this->is_new_record()?QdLog::$ACTION_INSERT:QdLog::$ACTION_MODIFY;
            $re = parent::save($validate);
            $class_name = $this->getCalledClassName();
            $location .= "|{$class_name}|save";
            if($re && $class_name!='QdLog')
            {
                //write log
                $this->writeLog($action, $location);//quocdunginfo
            }
            return $re;
        } else {
            return false;
        }
    }
    protected function writeLog($action=0, $location='')
    {
        $location .= '|writeLog';
        $obj = QdLog::getInitObj($this->getCalledClassName(), $this->id, $action, $location);
        $obj->save();
    }

    public static function getFieldOptions($field_name, $lang = 'en')
    {
        try {
            $tmp = array();
            $config = static::getFieldsConfig();
            $t = $config[$field_name]['Options'];
            foreach ($t as $value => $config) {
                $tmp[$value] = $config['Caption'][$lang];
            }

            return $tmp;
        } catch (Exception $ex) {
            return array();
        }
    }
}