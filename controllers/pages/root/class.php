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
        $this->data['returnid'] = isset($_GET['qdreturnid']) ? $_GET['qdreturnid'] : '';//id
        $this->data['view_style'] = 'normal';
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
        //mac dinh lay het field ben model dem qua

    }
    public function run()
    {
        //load View and render
        $c = static::getViewClass();
        if($c!='')
        {
            (new $c($this))->render();
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
            return static::getLayout()[$f_name]['Width'];
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
    protected static function getTableRelation($field_name)
    {
        $c = static::getModel();
        return $c::getTableRelation($field_name);
    }
    protected static function getLookupURL($field_name)
    {
        //get Table relation
        $model = static::getTableRelation($field_name);
        return Qdmvc_Helper::getLookupPath(static::getDefaultLookupPage($model),$field_name);
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
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['PageList']))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['PageList'];
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
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['DataPort']))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['DataPort'];
        }
    }
    /*
     * Trả về Model (class name - NOT Table name)
     */
    public static function getModel()
    {
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['Model']))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['Model'];
        }
    }
    public static function getCaption($lang='en')
    {
        if(isset(Qdmvc_Page_Index::getIndex()[static::getPage()]['Caption'][$lang]))
        {
            return Qdmvc_Page_Index::getIndex()[static::getPage()]['Caption'][$lang];
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
}