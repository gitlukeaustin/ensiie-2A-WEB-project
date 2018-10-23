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
        $rows = $this->connection->query("SELECT * from Game where id_j1=$id or id_j2=$id")->fetchAll(\PDO::FETCH_OBJ);
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
            $statement = $this->connection->prepare('INSERT INTO Game (id_j1,id_j2,status,cards,messages,id_winner,po) values(:id_j1, :id_j2, :status, :cards, :messages, :id_winner, :po )');
            $statement->bindParam(':id_j1',$gameArray['id_j1']);
            $statement->bindParam(':id_j2',$gameArray['id_j2']);
            $statement->bindParam(':status',$gameArray['status']);
            $statement->bindParam(':cards',$gameArray['cards']);
            $statement->bindParam(':messages',$gameArray['messages']);
            $statement->bindParam(':id_winner',$gameArray['id_winner']);
            $statement->bindParam(':po',$gameArray['po']);
            $statement->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

}
