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
                } 
                else if ($this->params['get']['action'] == 'simulate') {
                    
                    $data = json_decode($this->params['post']['data'],true); // decode as array
                    $j1 = $_SESSION['user']; // $j1 = userHydro->hydrate($_SESSION['user'])
                    
                    $log = ['Aucun adversaire présent - lancement d\'un match simulé.'];
                    
                    $robot = ['login'=> 'robot'];
                    $cartesRobot = [['type'=>'Soldat','name'=>'Soldat','attack'=>2,'defence'=>2,'chance'=>0.9],
                        ['type'=>'Mur','name'=>'Mur','attack'=>0,'defence'=>2,'chance'=>0.9],
                        ['type'=>'Soldat','name'=>'Soldat','attack'=>2,'defence'=>2,'chance'=>0.9]];
                    
                    $sim = new Simulator();
                    $winner = $sim->simulate($data['selected'],$cartesRobot,$j1,$robot);
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
                    
                    echo json_encode(['data' => $data['selected'], 'animations' => $sim->getAnimations() ,'log' => $log, 'adv_cards' => $cartesRobot, 'adv' => $robot['login'], 'winner' => $sim->getWinner()['login']]);
                    return true;
                
                } 
                else if ($this->params['get']['action'] == 'send_selection') {
                    $data = json_decode($this->params['post']['data'],true); // decode as array
                    $j1 = $_SESSION['user']; // $j1 = userHydro->hydrate($_SESSION['user'])  
                    $gameRepository = new \Game\GameRepository($this->connection);
                    $gameHydrator = new \Game\GameHydrator();
                    $game = $gameRepository->findGameById($data['game']['id']);
                    $cards = $game->getCards();

                    if($cards == NULL ){
                        
                        $cardArray = json_encode([$j1['login'] => $data['selected'],$data['adv'] => '']);

                        $gameRepository->updateCards($data['game']['id'],$cardArray);

                        echo json_encode(['data' => $data['selected'], 'log' => '', 'resolved' => false]);
                    }
                    else{
                        $cardArray = json_decode($cards,true);
                        $sim = new Simulator();
                        $j2 = ['login'=> $data['adv']];
                        $winner = $sim->simulate($data['selected'],$cardArray[$data['adv']],$j1,$j2);
                        foreach($sim->getLog()??[''] as $l){
                            $log[] = $l;
                        }
                        
                        $cardsEv = [$j1['login'] => $data['selected'],$j2['login'] => $cardArray[$data['adv']]];

                        if($winner == NULL){
                            $log[] = "Exéco.";
                        }
                        else{
                            $gameRepository->updateWinner($data['game']['id'],$winner['login']);

                            $log[] = "Le joueur ".$winner['login']." a gagné!";
                        }
                        $gameRepository->updateMessages($data['game']['id'],json_encode(['log' => $log, 'animations' => $sim->getAnimations()]));
                        
                        $gameRepository->updateCards($data['game']['id'],json_encode($cardsEv));

                        
                        echo json_encode(['data' => $data['selected'], 'log' => $log, 'animations' => $sim->getAnimations(), 'resolved' => true, 'adv_cards' => $cardArray[$data['adv']], 'winner' => $sim->getWinner()]);

                    }
                    return true;
                } 
                else if ($this->params['get']['action'] == 'connect') {
                    $gameRepository = new \Game\GameRepository($this->connection);
                    $gameHydrator = new \Game\GameHydrator();
                    $j = $_SESSION['user'];
                    $game = $gameRepository->findPlayer($j);
                    $c = true;
                    $adv = '';
                    if(strlen($game->getIdPlayer2().'') == 0){
                        $c = false;
                    }
                    else{
                        $adv = $gameRepository->findOtherLogin($data['id'],$_SESSION['login']);
                    }
                    echo json_encode(['game' => $gameHydrator->extract($game), 'log' => '', 'connected' => $c,'adv' => $adv]);
                    return true;
                
                } else if ($this->params['get']['action'] == 'ping_server') {
                    $gameRepository = new \Game\GameRepository($this->connection);
                    $gameHydrator = new \Game\GameHydrator();

                    $data = json_decode($this->params['post']['data'],true);
                    $j = $_SESSION['user'];
                    
                    $game = $gameRepository->findGameById($data['id']);

                    $c = true;
                    $adv2 = '';
                    if(strlen($game->getIdPlayer2().'') == 0){
                        $c = false;
                    }
                    else{
                        $adv2 = $gameRepository->findOtherLogin($data['id'],$_SESSION['login']);
                    }
                    echo json_encode(['game' => $gameHydrator->extract($game), 'log' => '', 'connected' => $c, 'adv' => $adv2]);
                    return true;
                }
                else if ($this->params['get']['action'] == 'ping_resolution') {
                    $gameRepository = new \Game\GameRepository($this->connection);
                    $gameHydrator = new \Game\GameHydrator();

                    $data = json_decode($this->params['post']['data'],true);
                    
                    $game = $gameRepository->findGameById($data['game']['id']);
                    $log = json_decode($game->getMessages(),true);
                    $r = true;
                    if($log == NULL){
                        $r = false;
                    }
                    $winner = $gameRepository->findWinnerLogin($data['game']['id']);
                    echo json_encode(['game' => $gameHydrator->extract($game), 'log' => $log['log'], 'animations' => $log['animations'], 'resolved' => $r, 'winner' => $winner]);
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