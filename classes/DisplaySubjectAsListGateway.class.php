<?php
include_once 'TableDataGateway.class.php';

/*
 * subjects list of each painting
 */
class DisplaySubjectAsListGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' SubjectName, SubjectID ';

    const TABLE_NAME = ' Subjects ';

    const PRIMARY_KEY = ' PaintingID ';

    const JOINS = ' join PaintingSubjects using(SubjectID) 
                   join Paintings using(PaintingID) ';

    public function __construct()
    {
        parent::__construct();
        parent::setOrderBy(' order by SubjectName ');
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