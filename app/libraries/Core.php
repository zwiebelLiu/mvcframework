<?php
//Core app Class
class core{
    protected $currentController='';
    protected $currentMethod='index';
    protected $params= [];

    public function __construct()
    {
        $url=$this->getUrl();
        if(!$url)
        {
            return 0;
        }

        //Look in contrlloers for first value,ucwordes will capitalize first.
        if(file_exists('../app/controllers/'.ucwords($url[0]).'.php'))
        {
            // will set a neu controller
            $this->currentController=ucwords($url[0]);
            unset($url[0]);
        }

        require_once '../app/controllers/'.$this->currentController.'.php';

        $this->currentController =new $this->currentController;

        //check for second part of the URL
        if(isset($url[1]))
        {
            //method_exists: check if class function  检查类的方法是否存在
            if(method_exists($this->currentController,$url[1]))
            {
                $this->currentMethod=$url[1];
                unset($url[1]);
            }

        }
        //Get parameters
        $this->params=$url ? array_values($url):[];

        //Call a callback with array of parame调用回调函数，并把一个数组参数作为回调函数的参数
        call_user_func_array([$this->currentController,$this->currentMethod],[$this->params]);

    }

    public function  getUrl()
    {
        if(isset($_GET['url'])){
            $url=rtrim($_GET['url'],'/');
            //Allow to filter variables as string使用特定的过滤器过滤一个变量
            //FILTER_SANITIZE_URL-->Remove all characters except letters, digits and $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.

            $url=filter_var($url,FILTER_SANITIZE_URL);
            //breaking it into an array
            $url=explode('/',$url);
            //var_dump($url);
            return $url;
        }

    }


}
