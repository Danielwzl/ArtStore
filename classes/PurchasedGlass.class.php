<?php
include_once 'ShoppingCartItem.class.php';

class PurchasedGlass extends ShoppingCartItem
{

    public function __construct($id, $qty)
    {
       parent::__construct($id, $qty);
    }
    
    protected function getData()
    {
        $data = new ShoppingCartDataGateway('TypesGlass', 'Title, GlassID, Price', 'GlassID');
        $rowGlass = $data->getByID($this->id);
        $this->name = $rowGlass['Title'];
        $this->price = $rowGlass['Price'];
        $data = null;
    }
}
?>