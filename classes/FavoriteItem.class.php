<?php
class FavoriteItem
{
    private $paintings, $artists;
    
    public function __construct()
    {
        if($this->paintings == null) $this->paintings = array();
        if($this->artists == null) $this->artists = array();
    }
    
    public function getList($type)
    {
        return $this->$type;
    }
    
    public function add($id, $type)
    {
        if(array_search($id, $this->$type) === false)
        {
            array_push($this->$type, $id);
            return true;
        }
        return false; 
    }

    public function remove($key, $type)
    {
        $temp = &$this->$type;
        unset($temp[$key]);
    }
    
    public function emptyList($type)
    {
        unset($this->$type);
        $this->$type = array();
    }
    
    public function getQty()
    {
        return count($this->artists) + count($this->paintings);
    }
}

?>