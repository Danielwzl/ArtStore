<?php 
include_once 'ShoppingCartItem.class.php';

class PurchasedMatt extends ShoppingCartItem
{

    public function __construct($id, $qty)
    {
        parent::__construct($id, $qty);
    }

    protected function getData()
    {
        $data = new ShoppingCartDataGateway('TypesMatt', 'Title, MattID', 'MattID');
        $rowMatt = $data->getByID($this->id);
        $this->name = $rowMatt['Title'];
        $this->price = 10;
        $data = null;
    }
}

?>
