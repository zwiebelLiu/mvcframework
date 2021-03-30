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

    //Feind user by email. Email is passed in by the Controller
    public function findUserByEmail($email){
        //Perepared statement
        $this->db->query('select * from users where user_email =:email');

        //Email param will be binded with the email variabale
        $this->db->bind(':email',$email);

        //check if email is already registered
        if($this->db->rowCount()>0){
            return true;
        }
        else
        {
            return false;
        }

    }

    public function register($data)
    {
        $this->db->query('Insert into users (user_name,user_email,password) values(:username,:email,:password)');
        $this->db->bind(':username',$data['username']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$data['password']);
        //Execute function

        if($this->db->execute())
        {
            return true;
        }
        else
         {
             return false;
         }

    }

    public function login($name,$password)
    {
        //Perepared statement
        $this->db->query('select * from users where user_name =:name');

        //bind value
        $this->db->bind(':name',$name);

        $row=$this->db->single();

        $hashedPassword=$row->password;

        if(password_verify($password,$hashedPassword))
        {
            return $row;
        }
        else
        {
            return false;
        }
    }


}