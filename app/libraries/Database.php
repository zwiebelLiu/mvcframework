<?php

class Database{
    private $dbHost=DB_HOST;
    private $dbUser=DB_USER;
    private $dbPass=DB_PASS;
    private $dbName=DB_NAME;

    private $statment;
    private $dbHandler;
    private $error;

    public function __construct()
    {
        $conn= 'mysql:host='.$this->dbHost.';dbname='.$this->dbName;
        $options=array(
            PDO::ATTR_PERSISTENT=>true,
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
        );

        try
        {
            $this->dbHandler=new PDO($conn,$this->dbUser,$this->dbPass,$options);
        }catch(PDOException $e){
            $this->error=$e->getMessage();
            echo $this->error;
    }

    }

    //Allows us to write queries
    public function query($sql){
        $this->statment=$this->dbHandler->prepare($sql); //执行一条预处理语句
    }

    //Bind values
    public function bind($parameter,$value,$type=null)
    {
        switch (is_null($type))
        {
            case is_int($value):
                $type =PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type =PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type =PDO::PARAM_NULL;
                break;
            default:
                $type =PDO::PARAM_STR;
                break;

        }
        $this->statment=bindValue($parameter,$value,$type);
    }

    //Execute the prepared statement
    public function execute()
    {
        return $this->statment->execute();
    }

    //Return an array
    public function resultSet()
    {
        $this->execute();
        return $this->statment->fetchAll(PDO::FETCH_OBJ);

    }
    //Return a speco for row as an object
    public function single()
    {
        $this->execute();
        return $this->statment->fetch(PDO::FETCH_OBJ);
    }
    //Get the row count
    public function rowCount()
    {
        return $this->statment->rowCount();
    }


}