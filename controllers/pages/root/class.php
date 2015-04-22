<?php
/**
 * Created by PhpStorm.
 * User: quocd_000
 * Date: 05/03/2015
 * Time: 11:34 PM
 */
class Qdmvc_Page_Root {
    protected $data = array();
    protected static $fields_show = array();
    function __construct()
    {
        $this->loadView();
        //build data_port value
        $this->data['data_port'] = Qdmvc_Helper::getDataPortPath(static::getDataPort(), $this->getPageView());
        //pre value for page List
        $this->data['role'] = isset($_GET['qdrole']) ? $_GET['qdrole'] : '';//lookup, navigate
        $this->data['returnid'] = isset($_GET['qdreturnid']) ? $_GET['qdreturnid'] : '';
        $this->data['getfield'] = isset($_GET['qdgetfield']) ? $_GET['qdgetfield'] : 'id';//id
        $this->data['view_style'] = 'normal';
        $this->data['language'] = Qdmvc_Config::getLanguage();
        $this->data['init_obj'] = $this->getInitObjJSON();
        if($this->data['role']=='lookup' || $this->data['role']=='navigate')
        {
            $this->data['view_style'] = 'compact';//compact, full
        }

        //pre-filter
        /*
        if(isset($_GET['filterfield'])) {
            $this->data['filter'] = array(
                0 => array('filterfield' => $_GET['filterfield'], 'filtervalue' => $_GET['filtervalue'])
            );
        }*/


        static::initFields();
    }
    protected function getPageView()
    {
        $re = array();
        //passing page filter
        //pre filter
        $count = 0;
        while(isset($_REQUEST['filterdatafield'.$count]))
        {
            $re[$_REQUEST['filterdatafield'.$count]] = $_REQUEST['filtervalue'.$count];
            $count++;
        }
        return array_merge($this->getCustomPageView(), $re);
    }
    protected function getCustomPageView()
    {
        return array();
    }
    public function getFilter()
    {
        return $this->data['filter'];
    }
    protected static function initFields()
    {
        return array(
            'id' => array(
                'SourceExpr' => 'id',
                'PrimaryKey' => true,
                'Width' => 70
            )
        );
    }
    public function run()
    {
        //load View and render
        $c = static::getViewClass();
        if($c!='')
        {
            $tmp = new $c($this);
            $tmp->render();
        }
    }
    protected static function getViewClass()
    {
        return '';
    }
    protected static function getDefaultLookupPage($model)
    {
        foreach(Qdmvc_Page_Index::getIndex() as $page=>$config)
        {
            if($config['PageType']=='List' && $config['Model']==$model)
            {
                return $page;
            }
        }
    }
    /*
     * Page List Only
     */
    public static function getWidth($f_name)
    {
        try{
            $tmp = static::getLayout();
            return $tmp[$f_name]['Width'];
        }catch (Exception $ex)
        {
            return '';
        }
    }
    public function getPagePartURL($part_name='')
    {
        return '';
    }
    protected static function isReadOnly($f_name)
    {
        $c = static::getModel();
        return $c::ISREADONLY($f_name);
    }
    protected static function getDataType($field_name)
    {
        $c = static::getModel();
        return $c::getDataType($field_name);
    }
    protected static function getLookupURL($field_name)
    {
        $c = static::getModel();
        $tbrelation = $c::getTableRelation($field_name);
        $tbfilter = $tbrelation['TableFilter'];
        $filter_arr = array();
        $df_lk_page = static::getDefaultLookupPage($tbrelation['Table']);
        $getfield = $tbrelation['Field'];

        foreach($tbfilter as $item)
        {
            $filter_arr[$item['Field']] = $item['Value'];
        }

        return Qdmvc_Helper::getLookupPath($df_lk_page, $field_name, $filter_arr, $getfield);
    }
    protected function loadView($name='view')
    {
        Qdmvc::loadController('/pages/'.static::getPage().'/'.$name);
    }
    /*
     * Trả về tên của Page, Setup trong Page Index Tree
     */
    public static function getPage()
    {

    }
    /*
     * json init object
     */
    protected function getInitObj()
    {
        $c = static::getModel();
        //if run page root direct
        if(!class_exists($c))
        {
            return null;
        }
        $obj = $c::getInitObj();
        //set pre filter
        $arr = static::getPageView();
        foreach($arr as $field=>$value)
        {
            $obj->{$field} = $value;
        }
        return $obj;
    }
    private function getInitObjJSON()
    {
        $obj = $this->getInitObj();
        $c = static::getModel();
        //convert to JSON
        $re = $c::toJSON(array($obj));
        return json_encode($re[0]);
    }
    /*
     * Trả về Caption của 1 field nào đó, thông qua Setup trong Model tương ứng
     */
    public function getFieldCaption($field_name, $lang='en')
    {
        $c = static::getModel();
        return $c::getFieldCaption($field_name, $lang);
    }
    public function getLayout()
    {
        if(static::$fields_show==null)
        {
            static::$fields_show = static::initFields();
        }
        return static::$fields_show;
    }
    /*
     * Trả về PageList Navigation tương ứng với PageCard hiện hành
     */
    protected function getPageList()
    {
        $index = Qdmvc_Page_Index::getIndex();
        $page = $index[static::getPage()];
        if(isset($page['PageList']))
        {
            return $page['PageList'];
        }
    }
    /*
     * Trả về URL của PageList Navigation sau khi đã thêm filter đầy đủ
     */
    public function getPageListURL()
    {
        return Qdmvc_Helper::getCompactPageListLink($this->getPageList(), $this->getPageView());
    }
    /*
     * Trả về DataPort (name only)
     */
    public static function getDataPort()
    {
        $index = Qdmvc_Page_Index::getIndex();
        $page = $index[static::getPage()];
        if(isset($page['DataPort']))
        {
            return $page['DataPort'];
        }
    }
    /*
     * Trả về Model (class name - NOT Table name)
     */
    public static function getModel()
    {
        $index = Qdmvc_Page_Index::getIndex();
        $page = $index[static::getPage()];
        if(isset($page['Model']))
        {
            return $page['Model'];
        }
        return '';
    }
    public static function getCaption($lang='en')
    {
        $index = Qdmvc_Page_Index::getIndex();
        $page = $index[static::getPage()];
        if(isset($page['Caption'][$lang]))
        {
            return $page['Caption'][$lang];
        }
        else {
            return 'Default Page Root Caption';
        }
    }
    /*
     * Trả về data dành cho View (MVC)
     */
    public function getData()
    {
        return $this->data;
    }
    public function getFieldOptions($f_name, $lang='en')
    {
        $c = static::getModel();
        return $c::getFieldOptions($f_name, $lang);
    }
}