<?php
    //Load the model and the view
class Controller{
    public function model($model){
        if(file_exists('../app/models/'.$model.'.php'))
        {
            require_once '../app/models/'.$model.'.php';
            return new $model();
        }
        else
        {
            echo 'Model does not exists';
        }
    }
    //Load the view (check for the file)
    public function view($view,$data=[]){
        if(file_exists('../app/views/'.$view.'.php'))
        {
            require_once '../app/views/'.$view.'.php';
        }
        else
        {
            die("View does not exists");
        }
    }
}