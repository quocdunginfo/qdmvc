<?php
class Qdpost extends ActiveRecord\Model
{
	static $table_name = 'wp_posts';
  
    # explicit pk since our pk is not "id" 
    static $primary_key = 'id';
	
	static $before_update = array('on_before_update'); # new records only
	
	public function on_before_update()
	{
		//$this->date_modified = $dt = new DateTime();
	}
    
    static $before_create = array('on_before_create'); # new records only
	
	public function on_before_create()
	{
		//$this->date_create = $dt = new DateTime();
	}
    public static function toJSON($qdprofile_list)
    {
        $tmp = array();
        $count = 0;
        foreach($qdprofile_list as $item)
        {
            $tmp[$count] = array();
            $tmp[$count]['id'] = $item->id;
            $tmp[$count]['nickname'] = $item->nickname;
            $count++;
            
        }
        return json_encode($tmp);
    }
    
}

