<?php


class Users extends Controller
{

    public function __construct()
    {
        $this->userModel=$this->model('User');
    }

    public function login()
    {
        $data=[
            'title'=>'Login Page',
            'username'=>'',
            'password'=>'',
            'usernameError'=>'',
            'passwordError'=>''
        ];

        //check for post
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //Sanitize post data
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data=[
                'username' =>trim($_POST['username']),
                'password' =>trim($_POST['password']),
                'usernameError' =>'',
                'passwordError' =>'',
            ];
            //Validate username
            if(empty($data['username']))
            {
                $data['usernameError']="Please enter username";
            }

            //Validate password
            if(empty($data['password']))
            {
                $data['passwordError']="Please enter password";
            }

            if(empty($data['usernameError'])&&empty($data['passwordError'])) {
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                }
                else
                {
                    $data['passwordError']="Password or username is incorrect. Try again";

                }
            }
            $data=[
                'username'=>'',
                'password'=>''
            ];

        }
        $this->view('users/login',$data);
    }

    public function createUserSession($user)
    {
        session_start();
        $_SESSION['user_id']=$user->user_id;
        $_SESSION['user_name']=$user->user_name;
        $_SESSION['user_email']=$user->user_email;
        header('location:'. URLROOT.'/pages/index');
    }


    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        header('location:'. URLROOT.'/users/login');
    }


    public function register()
    {
        $data=[

            'username'=>'',
            'email'=>'',
            'password'=>'',
            'confirmPassword'=>'',
            'usernameError'=>'',
            'emailError'=>'',
            'passwordError'=>'',
            'confirmPasswordError'=>'',
        ];


        if($_SERVER['REQUEST_METHOD']=='POST'){
            //santize post data
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data=[

                'username'=>trim($_POST['username']),
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'confirmPassword'=>trim($_POST['confirmPassword']),
                'usernameError'=>'',
                'emailError'=>'',
                'passwordError'=>'',
                'confirmPasswordError'=>''
            ];
            //Validate username on letters/nummbers
            $nameValidation ="/^[a-zA-Z0-9]*$/";
            if(empty($data['username']))
            {
                $data['usernameError'] ='please enter username';
             }
            elseif(!preg_match($nameValidation,$data['username']))
            {
                $data['usernameError'] ='username can only letters with nummers';
            }


            if(empty($data['email']))
            {
                $data['email'] ='please enter email';
            }
            elseif(!filter_var($data['email'],FILTER_SANITIZE_EMAIL))
            {
                $data['emailError'] ='please enter the correct format ';
            }
            else
            {
                //Check if email exists
                if($this->userModel->findUserByEmail($data['email']))
                {
                    $data['emailError'] ='Email is alreaay take ';
                }

            }

            //Validate password on length and numeric values
            $passwordValidation ="/^(.{0,7}|[a-z]*|[^\d]*)$/i";
            if(empty($data['password'])){
                $data['passwordError']='please enter password';
            }
            elseif (strlen($data['password'])<6){
                $data['passwordError'] ='password must be at least 6 characters';
            }
            elseif(!preg_match($nameValidation,$data['password']))
            {
                $data['passwordError'] ='password must have a least one numerric value ';
            }

            //Validate confirm password
            if(empty($data['confirmPassword'])){
                $data['confirmPasswordError']='please enter confirmPassword';
            }else
            {
                if($data['password']!==$data['confirmPassword'])
                {
                    $data['confirmPasswordError']='Password do not match ';
                }
            }

            //Make Sure that errors are empty
            if(empty($data['usernameError'])&&
                empty($data['emailError'])&&
                empty($data['passwordError'])&&
                empty($data['confirmPasswordError']))
            {
                //Hash password
                $data['password']=password_hash($data['password'],PASSWORD_DEFAULT);

                //Register user from model function
                if($this->userModel->register($data)){
                    //Redirect to the login page
                    header('location:'.URLROOT.'/users/login');
                }
                else
                {
                 die ('ERROR');
                }


            }
        }

        $this->view('users/register',$data);


    }

}