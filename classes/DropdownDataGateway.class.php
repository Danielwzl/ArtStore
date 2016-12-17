<?php
include_once 'TableDataGateway.class.php';

/*
 * all dropdown list
 */
class DropdownDataGateway extends TableDataGateway
{

    private $colName, $tableName;

    const PRIMARY_KEY = 'null';

    const JOINS = '';

    public function __construct($colName, $tableName)
    {
        parent::__construct();
        $this->colName = $colName;
        $this->tableName = $tableName;
    }

    protected function getPrimaryKeyName()
    {
        if(self::PRIMARY_KEY === 'null') throw new Exception('null primary key');
        return self::PRIMARY_KEY;
    }

    protected function getSelectStatement()
    {
        return 'select ' . $this->colName . ' from ' . $this->tableName . ' ' . self::JOINS;
    }

    public function setOrderBy($order)
    {
        parent::setOrderBy($order);
    }
}
?>