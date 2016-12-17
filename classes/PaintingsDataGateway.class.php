<?php
include_once 'TableDataGateway.class.php';

class PaintingsDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' Title, PaintingID, ImageFileName, FirstName, LastName, Excerpt, MSRP ';

    const TABLE_NAME = ' Paintings ';

    const PRIMARY_KEY = 'null';

    const JOINS = ' join Artists using(ArtistID) ';

    public function __construct()
    {
        parent::__construct();
        parent::setOrderBy(' order by YearOfWork ');
    }

    protected function getPrimaryKeyName()
    {
        if(self::PRIMARY_KEY === 'null') throw new Exception('null primary key');
        return self::PRIMARY_KEY;
    }

    protected function getSelectStatement()
    {
        return 'select' . self::REQUIRE_COL_MAIN . 'from' . self::TABLE_NAME . self::JOINS;
    }

    public function getSQL()
    {
        return $this->getSelectStatement();
    }

    public function setLimit($num)
    {
        parent::setLimitAmountOfData($num);
    }
}
?>