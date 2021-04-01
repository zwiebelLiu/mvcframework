<?php


class Post
{
    private $db;
    public function __construct()
    {
        $this->db=new Database();
    }

    public function findAllPost()
    {
        $this->db->query("select * from posts order by created_at desc");
       return $result=$this->db->resultSet();
    }

    public function create($data)
    {
        $this->db->query("INSERT INTO `posts`( `user_id`, `title`, `body`, `created_at`) VALUES (:user_id, :title, :body, now())");

        $this->db->bind(':user_id',$data['user_id']);
        $this->db->bind(':title',$data['title']);
        $this->db->bind(':body',$data['body']);


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function findPost($id)
    {

        $this->db->query("select * from posts where id= :id");
        $this->db->bind(':id',(int) $id[0]);
        $row = $this->db->single();

        return $row;
    }

    public function update($data)
    {
        //var_dump($data);
        $this->db->query("UPDATE `posts` SET `title`=:title,`body`=:body WHERE  id= :id");

        $this->db->bind(':id',(int) $data['posts']->id);
        $this->db->bind(':title',$data['title']);
        $this->db->bind(':body',$data['body']);


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function deletePost($id) {
        $this->db->query('DELETE FROM posts WHERE id = :id');

        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
