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
        //$this->url = explode('/', $_SERVER['REQUEST_URI']);
        $this->params = [
            'get' => $_GET,
            'post' => $_POST
            //'session' => $_SESSION
        ];
    }

    public function dispatch(){
        try{
            //$controllerFactoryName = 'Factory\Controller\\'.$this->url[1].'Controller';
            //$actionName = $this->url[2].'Action';

            //$controller = new $controllerName();  
            //$viewModel = $controller->$actionName();
            //include(__DIR__.'../../../view/' . $this->url[1] . '/' . $this->url[2]);
            //return $controller->$actionName();

            //array (size=2)
            //'get' => 
            //  array (size=1)
            //    'action' => string 'fetch_units' (length=11)

            if(isset($this->params['get']['action'])){
                if($this->params['get']['action']=='fetch_units'){
                    $unitRepository = new \Unit\UnitRepository($this->connection);
                    $unitHydro = new \Unit\UnitHydrator();
                    $units = $unitRepository->fetchAll();
                    $unitArray = [];
                    foreach($units as $unit){
                        $unitArray[] = $unitHydro->extract($unit);
                    }
                    //var_dump($unitArray);
                    echo json_encode($unitArray);
                    return true;
                }
                else if($this->params['get']['action']=='fetch_categories'){
                    $catRepository = new \Category\CategoryRepository($this->connection);
                    $catHydro = new \Category\CategoryHydrator();
                    $cats = $catRepository->fetchAll();
                    $catArray = [];
                    foreach($cats as $cat){
                        $catArray[] = $catHydro->extract($cat);
                    }
                    //var_dump($catArray);
                    $simplearray = ["a","b","c"];
                    echo json_encode($catArray);
                    return true;
                } 
                else if($this->params['get']['action']=='send_selection'){
                     $selected = json_decode($this->params['post']['data']);
                    
                    echo json_encode(['data' => $selected, 'log' => 'Séléction envoyé.']);
                    return true;
                } 
                return false;
            } 
            return false;
        }
        catch(\Throwable $e){
            throw($e);
            return false;
        }
    }

}
?>    