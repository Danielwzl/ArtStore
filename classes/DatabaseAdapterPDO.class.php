<?php

/*
 *connect to dbs 
 */
class DatabaseAdapterPDO
{

    private $pdo;

    private $stmt;

    public function __construct($value)
    {
        $this->setConnectionInfo($value);
    }

    public function setConnectionInfo($values = array())
    {
        if(!is_array($values)) $values = array($values);
        
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        
        try
        {
            $pdo = new PDO($connString, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }

    /*
     * return a selected row with sql statement
     */
    public function fetchRow($sql, $values = array())
    {
        if(!is_array($values)) $values = array($values);
        try
        {
            $stmt = $this->pdo->prepare($sql);
            foreach($values as $key => $value)
            {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * return multiple rows  
     */
    public function fetchAsArray($sql)
    {
        try
        {
            $res = $this->pdo->query($sql);
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     * return multiple rows by sql statement with a id
     */
    public function fetchAsArrayByID($sql, $values = array())
    {
        if(!is_array($values)) $values = array($values);
        try
        {
            $stmt = $this->pdo->prepare($sql);
            foreach($values as $key => $value)
            {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function disconnect()
    {
        $this->stmt = null;
        $this->pdo = null;
    }
}
?>