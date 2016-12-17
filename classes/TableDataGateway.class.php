<?php
require_once ('config.php');
require_once ('DatabaseAdapterPDO.class.php');

/*
 * get sql statement and return selected row
 */
abstract class TableDataGateway
{

    protected $limitNumberOfData; //if there is limitation of number of data needed

    protected $orderBy; //set orderBy here bucause where clause needs to put before order by statement, same as limit statement

    protected $dbAdapter;

    public function __construct()
    {
        $this->dbAdapter = new DataBaseAdapterPDO(array(DBCONNSTRING ,DBUSER ,DBPASS));
    }

    abstract protected function getPrimaryKeyName(); //get id used in where clause

    abstract protected function getSelectStatement();

    public function getAll()
    {
        $sql = $this->getSelectStatement() . $this->orderBy;
        $sql .= empty($this->limitNumberOfData) ? '' : ' limit ' . $this->limitNumberOfData; //check if there is limitation of data needed
        return $this->dbAdapter->fetchAsArray($sql);
    }

    /*
     * catch nullpointer if other partner use this function without define primary key
     */
    public function getById($id)
    {
        $sql = $this->getSelectStatement();
        try
        {
            $sql .= ' where ' . $this->getPrimaryKeyName() . '=:id' . $this->orderBy;
            return $this->dbAdapter->fetchRow($sql, array(':id' => $id));
        }
        catch(Exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function getBySQL($sql, $values = array())
    {
        if(!is_array($values)) $values = array($values);
        $sql .= $this->orderBy;
        $sql .= empty($this->limitNumberOfData) ? '' : ' limit ' . $this->limitNumberOfData;
        return $this->dbAdapter->fetchAsArrayByID($sql, $values);
    }

    /*
     * catch nullpointer if other partner use this function without define primary key
     */
    public function getAllById($id, $values = array())
    {
        $sql = $this->getSelectStatement();
        try
        {
            $sql .= ' where ' . $this->getPrimaryKeyName() . '=:id' . $this->orderBy;
            return $this->dbAdapter->fetchAsArrayByID($sql, array(':id' => $id));
        }
        catch(Exception $e)
        {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function disconnect()
    {
        $this->dbAdapter->disconnect();
        $this->dbAdapter = null;
    }

    protected function setLimitAmountOfData($num)
    {
        $this->limitNumberOfData = $num;
    }

    protected function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }
}
?>
