<?php
include_once 'TableDataGateway.class.php';

class ShoppingCartDataGateway extends TableDataGateway
{

    private $col, $tableName, $primaryKey;

    const JOINS = ' ';

    public function __construct($tableName, $col, $primaryKay)
    {
        parent::__construct();
        $this->tableName = ' ' . $tableName . ' ';
        $this->col = ' ' . $col . ' ';
        $this->primaryKey = ' ' . $primaryKay . ' ';
    }

    protected function getPrimaryKeyName()
    {
        if($this->primaryKey === 'null') throw new Exception('null primary key');
        return $this->primaryKey;
    }

    protected function getSelectStatement()
    {
        return 'select' . $this->col . 'from' .  $this->tableName . self::JOINS;
    }

    public function getSQL()
    {
        return $this->getSelectStatement();
    }
}
?>