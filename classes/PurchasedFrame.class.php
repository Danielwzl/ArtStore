<?php
include_once 'ShoppingCartItem.class.php';

class PurchasedFrame extends ShoppingCartItem
{

    public function __construct($id, $qty)
    {
        parent::__construct($id, $qty);
    }

    protected function getData()
    {
        $data = new ShoppingCartDataGateway('TypesFrames', 'Title, FrameID, Price', 'FrameID');
        $rowFrame = $data->getByID($this->id);
        $this->name = $rowFrame['Title'];
        $this->price = $rowFrame['Price'];
        $data = null;
    }
}
?>