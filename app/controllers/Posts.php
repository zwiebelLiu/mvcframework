<?php


class Posts extends Controller
{
    public function __construct()
    {
        $this->postModel=$this->model('Post');
        //$users=$this->model('User')->getUsers();
        // var_dump($users);
    }


    public function index()
    {
        $posts=$this->postModel->findAllPost();
        $data=[
            'posts'=>$posts
          ];

        $this->view('posts/index',$data);
    }

    public function create()
    {

        if(!isLoggedIn()){
            header("Location:".URLROOT."/posts");
        }
        $data=[
            'title'=>'',
            'body'=>'',
            'user_id'=>$_SESSION['user_id'],
            'titleError'=>'',
            'bodyError'=>''];
        if($_SERVER['REQUEST_METHOD']=='POST')
        {

            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data=[
                'title'=>trim($_POST['title']),
                'body' =>trim($_POST['body']),
                'user_id'=>$_SESSION['user_id'],
                'titleError'=>'',
                'bodyError'=>''
            ];
            if(empty($data['title']))
            {
                $data['titleError']="Please enter Title";
            }
            if(empty($data['body']))
            {
                $data['bodyError']="Please enter content";
            }

            if(empty($data['titleError'])&&empty($data['bodyError']))
            {
                if($this->postModel->create($data))
                {
                    header("Location:".URLROOT."/posts");
                }
                else
                {
                   die('something went wrong,');
                }

            }
            else
            {
                $this->view('posts/create',$data);
            }

        }


        $this->view('posts/create',$data);
    }

    public function update($id)
    {

        $post = $this->postModel->findPost($id);
       /*

        if (!isLoggedIn()) {
            header("Location: " . URLROOT . "/posts");
        } elseif ($post->user_id != $_SESSION['user_id']) {
            header("Location: " . URLROOT . "/posts");
        }
*/
        $data = [
            'posts' => $post,
            'title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => '',

        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [

                'posts' => $post,
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'titleError' => '',
                'bodyError' => ''
            ];

            if (empty($data['title'])) {
                $data['titleError'] = 'The title of a post cannot be empty';
            }

            if (empty($data['body'])) {
                $data['bodyError'] = 'The body of a post cannot be empty';
            }

            if ($data['title'] == $this->postModel->findPost($id)->title) {
                $data['titleError'] == 'At least change the title!';
            }

            if ($data['body'] == $this->postModel->findPost($id)->body) {
                $data['bodyError'] == 'At least change the body!';
            }

            if (empty($data['titleError']) && empty($data['bodyError'])) {

                if ($this->postModel->update($data)) {
                    header("Location: " . URLROOT . "/posts");
                } else {
                    die("Something went wrong, please try again!");
                }
            } else {
                $this->view('posts/edit', $data);
            }
        }

        $this->view('posts/edit', $data);
    }
    public function delete($id) {

        $post = $this->postModel->findPost($id);
/*
        if(!isLoggedIn()) {
            header("Location: " . URLROOT . "/posts");
        } elseif($post->user_id != $_SESSION['user_id']){
            header("Location: " . URLROOT . "/posts");
        }
*/
        $data = [
            'post' => $post,
            'title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if($this->postModel->deletePost($id)) {
                header("Location: " . URLROOT . "/posts");
            } else {
                die('Something went wrong!');
            }
        }
    }

}
