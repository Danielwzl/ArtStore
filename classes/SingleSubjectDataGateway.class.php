<?php
include_once 'TableDataGateway.class.php';

class SingleSubjectDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' DISTINCT SubjectName, SubjectID,  
                                ImageFileName, Title, PaintingID ';

    const TABLE_NAME = ' Subjects ';

    const PRIMARY_KEY = ' SubjectID ';

    const JOINS = ' join PaintingSubjects using(SubjectID) 
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