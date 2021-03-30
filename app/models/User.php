<?php


 class User
{
    private $db;
    public function __construct()
    {
        $this->db=new Database();

    }

      public function getUsers()
    {
        $this->db->query("select * from users");

        $result=$this->db->resultSet();
        return $result;
        //var_dump($result);
    }

    public function find($id)
    {
        $this->db->query("select * from users where user_id=$id");
        $result=$this->db->single();
        return $result;
    }


}