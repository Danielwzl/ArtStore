<?php
include_once 'TableDataGateway.class.php';

/*
 * painting in favorite list
 */
class FavoritePaintingDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' PaintingID, ImageFileName, Title ';

    const TABLE_NAME = ' Paintings ';

    const PRIMARY_KEY = ' PaintingID ';

    const JOINS = '';

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
}
?>