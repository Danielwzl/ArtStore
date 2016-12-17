<?php
include_once 'ShoppingCartItem.class.php';

class PurchasedPainting extends ShoppingCartItem
{

    private $imageID;

    public function __construct($id, $qty)
    {
        parent::__construct($id, $qty);
    }

    protected function getData()
    {
        $data = new ShoppingCartDataGateway('Paintings', 'ImageFileName, Title, MSRP, PaintingID', 'PaintingID');
        $rowPainting = $data->getByID($this->id);
        $this->imageID = $rowPainting['ImageFileName'];
        $this->name = $rowPainting['Title'];
        $this->price = $rowPainting['MSRP'];
        $data = null;
    }

    public function getImageId()
    {
        return $this->imageID;
    }
}
?>