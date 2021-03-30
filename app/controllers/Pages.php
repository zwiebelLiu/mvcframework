<?php


class Pages extends Controller
{

    public function __construct()
    {
         $this->userModel=$this->model('User');
        $users=$this->model('User')->getUsers();
      // var_dump($users);
    }

    public function index()
    {
        $users=$this->model('User')->find(1);

        $data=[
            'title'=>'Home page',
            'users'=>$users
        ];
        $this->view('pages/index',$data);
    }

    public function about()
    {
        $this->view('pages/about');
    }
}