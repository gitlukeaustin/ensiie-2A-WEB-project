<?php
namespace Game;

class GameRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * CategoryRepository constructor.
     * @param \PDO $connection
     */

    /**
     * @var UserHydrator
     */
    protected $hydrator;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
        $this->hydrator = new GameHydrator();
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT * FROM Game ')->fetchAll(\PDO::FETCH_OBJ);

        $games = [];
        foreach ($rows as $row) {
            $games[] = $this->hydrator->hydrate($row,new \Game\Game());
        }
        return $games;
    }

    public function fetchAllByUser(\User\User $user)
    {
        $id=$user->getId();
        $rows = $this->connection->query("SELECT * from Game where (id_j1=$id or id_j2=$id) and id_winner is not null")->fetchAll(\PDO::FETCH_OBJ);
        $games = [];       
        foreach ($rows as $row) {
             $games[] = $this->hydrator->hydrate((array)$row,new \Game\Game());
        }
        return $games;
    }

    public function create(\Game\Game $game)
    {
        try {
            $gameArray = $this->hydrator->extract($game);
            $statement = $this->connection->prepare('INSERT INTO Game (id_j1,id_j2,status,id_winner,po) values(:id_j1, :id_j2, :status, :id_winner, :po )');
            $statement->bindParam(':id_j1',$gameArray['id_j1']);
            $statement->bindParam(':id_j2',$gameArray['id_j2']);
            $statement->bindParam(':status',$gameArray['status']);
            $statement->bindParam(':id_winner',$gameArray['id_winner']);
            $statement->bindParam(':po',$gameArray['po']);
            $statement->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function findPlayer($j){
        $q = $this->connection->prepare('SELECT * FROM find_game(:idj1)');
        $q->bindParam(':idj1',$j['id']);
        $q->execute();
        
        $rows = $q->fetchAll();
        $newGame = null;
        foreach ($rows as $row) {
            $newgame = new \Game\Game();
            $game = $this->hydrator->hydrate($row,clone $newgame);
        }
        
        return $game;
    }



    
    public function findGameById($id){
        $game = null;
        $statement = $this->connection->prepare('SELECT * FROM Game WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();

        $allGames = $statement->fetchAll();
        foreach ($allGames as $userData){
            $newGame = new \Game\Game();
            $game = $this->hydrator->hydrate($userData, clone $newGame);
        }
        return $game;
    }

    public function updateCards($gid,$cards){
        try{
            $q = $this->connection->prepare('UPDATE Game set cards = :c WHERE id = :gid');
            $q->bindParam(':c',$cards);
            $q->bindParam(':gid',$gid);
            $q->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }

    function updateMessages($gid,$message){
        try{
            $q = $this->connection->prepare('UPDATE Game set messages = :m WHERE id = :gid');
            $q->bindParam(':m',$message);
            $q->bindParam(':gid',$gid);
            $q->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }

    function updateWinner($gid,$login){
        try{
            $q = $this->connection->prepare('UPDATE Game set id_winner = (SELECT id from "User" WHERE login = :w) WHERE id = :gid');
            $q->bindParam(':w',$login);
            $q->bindParam(':gid',$gid);
            $q->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
 


    public function findOtherLogin($gid,$login){
        try{
            

            $q = $this->connection->prepare('SELECT u.login FROM "User" u JOIN Game g ON u.id = g.id_j2 WHERE g.id = :gid');
            $q->bindParam(':gid',$gid);
            $q->execute();
            $login = '';
            $l = $q->fetchColumn();
            if(strcmp($l,$_SESSION['login']) == 0){
                
                $q = $this->connection->prepare('SELECT u.login FROM "User" u JOIN Game g ON u.id = g.id_j1 WHERE g.id = :gid');
                $q->bindParam(':gid',$gid);
                $q->execute();
                return $q->fetchColumn();
            }
            else{
                return $l;
            }
        }
        catch(Exception $e){
            echo $e;
        }
    }

    public function findWinnerLogin($gid){
        try{   
            $q = $this->connection->prepare('SELECT u.login FROM "User" u WHERE u.id = (SELECT g.id_winner FROM Game g WHERE g.id = :gid)');
            $q->bindParam(':gid',$gid);
            $q->execute();
            $l = $q->fetchColumn();
            return $l;
        }
        catch(Exception $e){
            echo $e;
        }
    }


}
