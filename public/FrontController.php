<?php

class FrontController
{
    /**
     * @var \PDO
     */
    private $params;
    private $url;
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->url = explode('/', $_SERVER['REQUEST_URI']);
        $this->params = [
            'get' => $_GET,
            'post' => $_POST
        ];
    }

    public function dispatch()
    {
        try {
            //$controllerFactoryName = 'Factory\Controller\\'.$this->url[1].'Controller';
            $actionName = $this->url[1];
            //include(__DIR__.'../../../view/' . $this->url[1] . '/' . $this->url[2]);

            if (method_exists($this,$actionName) && isset($_SESSION['uniqid']) && isset($_SESSION['login'])){
                $this->$actionName();
            }
            else{
                $this->default();
            }

        } catch (\Throwable $e) {
            throw($e);
            return false;
        }
    }

    public function acceuil(){
        echo '<html>';
        require 'navBar.php';
        echo 'Acceuil';
        echo '</html>';
    }

    public function jeu(){
        $headers = ['<script type="text/javascript" src="js/jeu.js?ver=9" ></script>',
    	'<link rel="stylesheet" href="css/jeu.css?ver=6">'];
        echo '<html>';
        require 'navBar.php';
        readfile('html/jeu.html');
        echo '</html>';
    }

    public function guide(){
        echo '<html>';
        require 'navBar.php';
        echo 'Guide';
        echo '</html>';
    }

    public function historique(){
        $headers = ['<link rel="stylesheet" href="css/histo.css"/>'];
        require 'historique.php';
    }

    public function leaderboard(){
        $headers = ['<link rel="stylesheet" href="css/rank.css"/>'];
        include 'leaderBoard.php';
    }

    public function compte(){
        $headers = ['<link href="../css/compte.css" rel="stylesheet"></link>'];
        include 'compte.php';
    }

    public function login(){
        if($this->url[2] == 'disconnect') {
            session_destroy();
            session_start();
            $this->default();
        }
        include 'login.php';
    }

    public function default(){
        if(isset($_SESSION['uniqid']) && isset($_SESSION['login'])){
            $this->jeu();
        }
        else{            
            readfile('html/login.html');
        }
    }

    public function delete(){
        require 'delete.php';
    }
}
