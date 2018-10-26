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
        ];
    }

    public function dispatch()
    {
        try {
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

            if (isset($this->params['get']['action'])) {
                if ($this->params['get']['action'] == 'fetch_units') {
                    $unitRepository = new \Unit\UnitRepository($this->connection);
                    $unitHydro = new \Unit\UnitHydrator();
                    $units = $unitRepository->fetchAll();
                    $unitArray = [];
                    foreach ($units as $unit) {
                        $unitArray[] = $unitHydro->extract($unit);
                    }
                    //var_dump($unitArray);
                    echo json_encode($unitArray);
                    return true;
                } else if ($this->params['get']['action'] == 'fetch_categories') {
                    $catRepository = new \Category\CategoryRepository($this->connection);
                    $catHydro = new \Category\CategoryHydrator();
                    $cats = $catRepository->fetchAll();
                    $catArray = [];
                    foreach ($cats as $cat) {
                        $catArray[] = $catHydro->extract($cat);
                    }
                    //var_dump($catArray);
                    $simplearray = ["a", "b", "c"];
                    echo json_encode($catArray);
                    return true;
                } else if ($this->params['get']['action'] == 'send_selection') {
                    $selected = json_decode($this->params['post']['data'],true); // decode as array
                    $j1 = $_SESSION['user']; // $j1 = userHydro->hydrate($_SESSION['user'])
                    $no_p2 = true;
                    if($no_p2){
                        
                        $log = ['Aucun adversaire présent - lancement d\'un match simulé.'];
                        
                        $robot = ['login'=> 'robot'];
                        $cartesRobot = [['type'=>'Soldat','name'=>'Soldat','attack'=>2,'defence'=>2,'chance'=>0.9],
                            ['type'=>'Mur','name'=>'Mur','attack'=>0,'defence'=>2,'chance'=>0.9],
                            ['type'=>'Soldat','name'=>'Soldat','attack'=>2,'defence'=>2,'chance'=>0.9]];
                        
                        $sim = new Simulator();
                        $winner = $sim->simulate($selected,$cartesRobot,$j1,$robot);
                        //array_push($log,$sim->getLog()??['']);
                        foreach($sim->getLog()??[''] as $l){
                            $log[] = $l;
                        }
                        
                        if($winner == NULL){
                            $log[] = "Exéco.";
                        }
                        else{
                            $log[] = "Le joueur ".$winner['login']." a gagné!";
                        }
                        // mis a jour de la base du vainqueur
                    }
                    echo json_encode(['data' => $selected, 'log' => $log, 'adv' => $cartesRobot]);
                    return true;
                }
                return false;
            }
            return false;
        } catch (\Throwable $e) {
            throw($e);
            return false;
        }
    }
}