<?php

class GameController
{
    /**
     * @var \PDO
     */
    private $params;
    private $url;
    private $connection;
    private $unitRepository;
    private $unitHydro;
    private $catHydro;
    private $catRepository;
    private $sim;
    private $gameRepository;
    private $gameHydrator;

    public function __construct($connection)
    {
        $this->connection = $connection;
        //$this->url = explode('/', $_SERVER['REQUEST_URI']);
        $this->params = [
            'get' => $_GET,
            'post' => $_POST
        ];
        $this->unitRepository = new \Unit\UnitRepository($this->connection);
        $this->unitHydro = new \Unit\UnitHydrator();
        $this->catRepository = new \Category\CategoryRepository($this->connection);
        $this->catHydro = new \Category\CategoryHydrator();
        $this->sim = new Simulator();
        $this->gameRepository = new \Game\GameRepository($this->connection);
        $this->gameHydrator = new \Game\GameHydrator();
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
                    $units = $this->unitRepository->fetchAll();
                    $unitArray = [];
                    foreach ($units as $unit) {
                        $unitArray[] = $this->unitHydro->extract($unit);
                    }
                    echo json_encode($unitArray);
                    return true;
                } else if ($this->params['get']['action'] == 'fetch_categories') { 
                    $cats = $this->catRepository->fetchAll();
                    $catArray = [];
                    foreach ($cats as $cat) {
                        $catArray[] = $this->catHydro->extract($cat);
                    }
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
        
                    $winner = $this->sim->simulate($data['selected'],$cartesRobot,$j1,$robot);
                    //array_push($log,$sim->getLog()??['']);
                    foreach($this->sim->getLog()??[''] as $l){
                        $log[] = $l;
                    }
                    
                    if($winner == NULL){
                        $log[] = "Exéco.";
                    }
                    else{
                        $log[] = "Le joueur ".$winner['login']." a gagné!";
                    }
                    
                    echo json_encode(['data' => $data['selected'], 'animations' => $this->sim->getAnimations() ,'log' => $log, 'adv_cards' => $cartesRobot, 'adv' => $robot['login'], 'winner' => $this->sim->getWinner()['login']]);
                    return true;
                
                } 
                else if ($this->params['get']['action'] == 'send_selection') {
                    $data = json_decode($this->params['post']['data'],true); // decode as array
                    $j1 = $_SESSION['user']; // $j1 = userHydro->hydrate($_SESSION['user'])  
                    $game = $this->gameRepository->findGameById($data['game']['id']);
                    $cards = $game->getCards();

                    if($cards == NULL ){
                        
                        $cardArray = json_encode([$j1['login'] => $data['selected'],$data['adv'] => '']);

                        $this->gameRepository->updateCards($data['game']['id'],$cardArray);

                        echo json_encode(['data' => $data['selected'], 'log' => '', 'resolved' => false]);
                    }
                    else{
                        $cardArray = json_decode($cards,true);
                        $j2 = ['login'=> $data['adv']];
                        $winner = $this->sim->simulate($data['selected'],$cardArray[$data['adv']],$j1,$j2);
                        foreach($this->sim->getLog()??[''] as $l){
                            $log[] = $l;
                        }
                        
                        $cardsEv = [$j1['login'] => $data['selected'],$j2['login'] => $cardArray[$data['adv']]];

                        if($winner == NULL){
                            $log[] = "Exéco.";
                        }
                        else{
                            $this->gameRepository->updateWinner($data['game']['id'],$winner['login']);

                            $log[] = "Le joueur ".$winner['login']." a gagné!";
                        }
                        $this->gameRepository->updateMessages($data['game']['id'],json_encode(['log' => $log, 'animations' => $this->sim->getAnimations()]));
                        
                        $this->gameRepository->updateCards($data['game']['id'],json_encode($cardsEv));

                        
                        echo json_encode(['data' => $data['selected'], 'log' => $log, 'animations' => $this->sim->getAnimations(), 'resolved' => true, 'adv_cards' => $cardArray[$data['adv']], 'winner' => $this->sim->getWinner()]);

                    }
                    return true;
                } 
                else if ($this->params['get']['action'] == 'connect') {
                    $j = $_SESSION['user'];
                    $game = $this->gameRepository->findPlayer($j);
                    $connected = true;
                    $adv = '';
                    if(strlen($game->getIdPlayer2().'') == 0){
                        $connected = false;
                    }
                    else{
                        $adv = $this->gameRepository->findOtherLogin($game->getId(),$_SESSION['login']);
                    }
                    echo json_encode(['game' => $this->gameHydrator->extract($game), 'log' => '', 'connected' => $connected,'adv' => $adv]);
                    return true;
                
                } else if ($this->params['get']['action'] == 'ping_server') {
                    $data = json_decode($this->params['post']['data'],true);
                    $j = $_SESSION['user'];
                    
                    $game = $this->gameRepository->findGameById($data['id']);

                    $connected = true;
                    $adv2 = '';
                    if(strlen($game->getIdPlayer2().'') == 0){
                        $connected = false;
                    }
                    else{
                        $adv2 = $this->gameRepository->findOtherLogin($data['id'],$_SESSION['login']);
                    }
                    echo json_encode(['game' => $this->gameHydrator->extract($game), 'log' => '', 'connected' => $connected, 'adv' => $adv2]);
                    return true;
                }
                else if ($this->params['get']['action'] == 'ping_resolution') {

                    $data = json_decode($this->params['post']['data'],true);
                    
                    $game = $this->gameRepository->findGameById($data['game']['id']);
                    $log = json_decode($game->getMessages(),true);
                    $resolved = true;
                    if($log == NULL){
                        $resolved = false;
                    }
                    $winner = $this->gameRepository->findWinnerLogin($data['game']['id']);
                    echo json_encode(['game' => $this->gameHydrator->extract($game), 'log' => $log['log'], 'animations' => $log['animations'], 'resolved' => $resolved, 'winner' => $winner]);
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