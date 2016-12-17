<?php
include_once 'ShoppingCartDataGateway.class.php';

/*
 * base class of painting frame glass matt
 */
abstract class ShoppingCartItem
{

    protected $price, $name, $id, $qty;

    abstract protected function getData();

    public function __construct($id, $qty)
    {
        $this->id = $id;
        if($this->id > 0) $this->qty = $qty;
    }
    public function isSame($id)
    {
        if($this->id != $id) return false;
        return true;
    }

    public function addQty($num)
    {
        if($this->id != 0) $this->qty += $num;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return str_replace(',', '', $this->price);
    }

    public function getQty()
    {
        return $this->qty;
    }

    public function setQty($qty)
    {
        if($qty > 0 && $this->qty != $qty) $this->qty = $qty;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /*
     *update data from dbs 
     */
    public function updateDetail()
    {
        if($this->id > 0) //if id exists
        {
            $this->getData();
            //$this->totalPrice();
        }
        else
        {
            $this->id = 0;
            $this->price = 0;
            $this->name = null;
            $this->qty = 0;
            $this->totalPrice = 0;
        }
    }
}

?>