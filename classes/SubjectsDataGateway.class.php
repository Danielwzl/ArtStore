<?php
include_once 'TableDataGateway.class.php';

class SubjectsDataGateway extends TableDataGateway
{

    const REQUIRE_COL_MAIN = ' SubjectID, SubjectName ';

    const TABLE_NAME = ' Subjects ';

    const PRIMARY_KEY = 'null';

    const JOINS = '';

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