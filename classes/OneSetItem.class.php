<?php
include_once 'PurchasedPainting.class.php';
include_once 'PurchasedGlass.class.php';
include_once 'PurchasedFrame.class.php';
include_once 'PurchasedMatt.class.php';

/*
 * one set of cart item
 */
class OneSetItem
{
    private $painting, $frame, $glass, $matt;

    public function __construct($painting, $frame, $glass, $matt)
    {
        $this->painting = $painting;
        $this->frame = $frame;
        $this->glass = $glass;
        $this->matt = $matt;
    }
    
    /*
     * update price name of each item from dbs
     */
    public function updateOrderDetail()
    {
        $this->painting->updateDetail();
        $this->frame->updateDetail();
        $this->glass->updateDetail();
        $this->matt->updateDetail();
        //$this->calculateSetPrice();
    }
    
    public function getSetQty()
    {
        return $this->painting->getQty();
    }

    public function addSetQty($qty)
    {
        $this->painting->addQty($qty);
        $this->frame->addQty($qty);
        $this->glass->addQty($qty);
        $this->matt->addQty($qty);
    }
    
    public function setNewQty($qty)
    {
        $this->painting->setQty($qty);
        $this->frame->setQty($qty);
        $this->glass->setQty($qty);
        $this->matt->setQty($qty);
    }

    /*
     * to check if this set exists
     */
    public function isSameSet($paintingId)
    {
        if($this->painting->isSame($paintingId)) return $this;
        return null;
    }

    public function getPainting()
    {
        return $this->painting;
    }

    public function getFrame()
    {
        return $this->frame;
    }

    public function getGlass()
    {
        return $this->glass;
    }

    public function getMatt()
    {
        return $this->matt;
    }
}
?>