<?php
require_once ('TableDataGateway.class.php');

class SinglePaintDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' ImageFileName, Paintings.Description, Excerpt, Title, LastName, ArtistID, YearOfWork,
                    Medium, Width, Height, GalleryName, GalleryID, AccessionNumber, CopyrightText, 
                    MuseumLink, GenreName, GenreID, MSRP, WikiLink, GoogleLink, GoogleDescription ';

    const TABLE_NAME = ' Paintings ';

    const PRIMARY_KEY = ' PaintingID ';

    const JOINS = ' join Artists using(ArtistID)
                   join PaintingGenres using(PaintingID)
                   join Genres using(GenreID)
                   join Galleries using(GalleryID) ';

    public function __construct()
    {
        parent::__construct();
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