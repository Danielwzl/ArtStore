<?php
include_once 'TableDataGateway.class.php';

class SingleGalleryDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' GalleryID, GalleryName, GalleryNativeName, 
                                GalleryCity, GalleryCountry, Latitude, Longitude, 
                                GalleryWebSite, ImageFileName, Title, PaintingID ';

    const TABLE_NAME = ' Galleries ';

    const PRIMARY_KEY = ' GalleryID ';

    const JOINS = ' join Paintings using(GalleryID) ';

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