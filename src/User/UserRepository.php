<?php
namespace User;

use User\User;
use User\UserHydrator;

class UserRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var UserHydrator
     */
    protected $hydrator;

    /**
     * UserRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
        $this->hydrator = new UserHydrator();
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT * FROM "User"')->fetchAll(\PDO::FETCH_OBJ);
        $users = [];
        foreach ($rows as $row) {
            $user = new User();
            //$salt = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
            //$encypted_pw = crypt($row->password, $salt);
            $user
                ->setId($row->id)
                ->setEmail($row->email)
                ->setLogin($row->login)
                ->setPassword($row->password)
                ->setEcts($row->ects)
                ->setIsAdmin($row->isAdmin)
                ->setIsActif($row->isActif);

            $users[] = $user;
        }

        return $users;
    }

    /**
     * @param $login
     * @return User
     */
    public function findOneByLogin($login){
        $user = null;
        $statement = $this->connection->prepare('SELECT * FROM "User" WHERE login = :login');
        $statement->bindParam(':login', $login);
        $statement->execute();

        $allUsers = $statement->fetchAll();
        foreach ($allUsers as $userData){
            $newUser = new User();
            $user = $this->hydrator->hydrate($userData, clone $newUser);
        }
        return $user;
    }

    
    public function findOneById($id){
        $user = null;
        $statement = $this->connection->prepare('SELECT * FROM "User" WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();

        $allUsers = $statement->fetchAll();
        foreach ($allUsers as $userData){
            $newUser = new User();
            $user = $this->hydrator->hydrate($userData, clone $newUser);
        }
        return $user;
    }

    /**
     * @param User $user
     */
    public function create(User $user){
        $userArray = $this->hydrator->extract($user);
        $statement = $this->connection->prepare('INSERT INTO "User"(login, password, email, isadmin, ects, isactif) values(:login, :password, :email, :isadmin, :ects, :isactif)');
        $statement->bindParam(':login',$userArray['login']);
        $statement->bindParam(':password',$userArray['password']);
        $statement->bindParam(':email',$userArray['email']);
        $statement->bindParam(':isadmin',$userArray['isadmin']);
        $statement->bindParam(':ects',$userArray['ects']);
        $statement->bindParam(':isactif', $userArray['isactif']);
        $statement->execute();
    }


    /**
     * @param $id
     */
    public function deleteUserById($id){

        $statement = $this->connection->prepare('UPDATE "User" SET isActif=false WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
    
        /* return some status */
    }

    /**
     * @return array
     */
    public function findTopTen(){
        $user = null;
        $rows = $this->connection->query('SELECT login,sum(CASE when id_winner is not null THEN 1 ELSE 0 END) as TotalGames,sum(CASE when id_winner=a.id THEN 1 ELSE 0 END ) wins, Case when (sum(CASE when id_winner is not null THEN 1 ELSE 0 END))!=0 then(CAST(sum(CASE when id_winner=a.id THEN 1 ELSE 0 END ) as float))/(sum(CASE when id_winner is not null THEN 1 ELSE 0 END)) else 0 end ratio FROM "User" a,Game b where a.id=b.id_j1 or a.id=b.id_j2 group by login order by ratio desc LIMIT 10;')->fetchAll(\PDO::FETCH_OBJ);
        return $rows;
    }

    public function modifyUserById($id, $login, $email){
        $statement = $this->connection->prepare('UPDATE "User" SET login = :login , email = :email WHERE id = :id');
        $statement->bindParam(':id', $id);
        $statement->bindParam(':login', $login);
        $statement->bindParam(':email', $email);
        $statement->execute();
    }

    public function getAllUsersList(){
        $statement = $this->connection->prepare('SELECT * FROM "User"');
        $statement->execute();

        $usersList = array();

        foreach ($statement->fetchAll() as $user){
            $newUser = new User();
            $user = $this->hydrator->hydrate($user, clone $newUser);

            array_push($usersList, $user);
        }

        return $usersList;
    } 

    public function getAllUsersListActivated(){
        $statement = $this->connection->prepare('SELECT * FROM "User" where isActif is true');
        $statement->execute();

        $usersList = array();

        foreach ($statement->fetchAll() as $user){
            $newUser = new User();
            $user = $this->hydrator->hydrate($user, clone $newUser);

            array_push($usersList, $user);
        }

        return $usersList;
    } 
}
