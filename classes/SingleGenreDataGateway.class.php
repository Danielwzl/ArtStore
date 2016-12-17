<?php
include_once 'TableDataGateway.class.php';

class SingleGenreDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' GenreName, GenreID, Link, 
                                Genres.Description as des, 
                                ImageFileName, Title, PaintingID ';

    const TABLE_NAME = ' Genres ';

    const PRIMARY_KEY = ' GenreID ';

    const JOINS = ' join PaintingGenres using(GenreID) 
                join Paintings using(PaintingID) ';

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