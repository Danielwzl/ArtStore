<?php
include_once 'TableDataGateway.class.php';

/*
 * aritist in favorite list
 */
class FavoriteArtistDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' ArtistID, FirstName, LastName ';

    const TABLE_NAME = ' Artists ';

    const PRIMARY_KEY = ' ArtistID ';

    const JOINS = '';

    public function __construct()
    {
        parent::__construct();
        parent::setOrderBy(' order by LastName ');
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