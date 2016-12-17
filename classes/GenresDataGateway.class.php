<?php
include_once 'TableDataGateway.class.php';

class GenresDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' GenreID, GenreName ';

    const TABLE_NAME = ' Genres ';

    const PRIMARY_KEY = 'null';

    const JOINS = '';

    public function __construct()
    {
        parent::__construct();
        parent::setOrderBy(' order by EraID, GenreName ');
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