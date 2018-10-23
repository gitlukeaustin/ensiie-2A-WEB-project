<?php
namespace User;

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
                ->setIsAdmin($row->isAdmin);

            $users[] = $user;
        }

        return $users;
    }

    /**
     * @param $login
     * @return \User\User
     */
    public function findOneByLogin($login){
        $user = null;
        $statement = $this->connection->prepare('SELECT * FROM "User" WHERE login = :login');
        $statement->bindParam(':login', $login);
        $statement->execute();

        $allUsers = $statement->fetchAll();
        foreach ($allUsers as $userData){
            $newUser = new \User\User();
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
            $newUser = new \User\User();
            $user = $this->hydrator->hydrate($userData, clone $newUser);
        }
        return $user;
    }

    /**
     * @param \User\User $user
     */
    public function create(\User\User $user){
        $userArray = $this->hydrator->extract($user);
        $statement = $this->connection->prepare('INSERT INTO "User"(login, password, email, isadmin, ects) values(:login, :password, :email, :isadmin, :ects)');
        $statement->bindParam(':login',$userArray['login']);
        $statement->bindParam(':password',$userArray['password']);
        $statement->bindParam(':email',$userArray['email']);
        $statement->bindParam(':isadmin',$userArray['isadmin']);
        $statement->bindParam(':ects',$userArray['ects']);
        $statement->execute();
    }


    /**
     * @param $id
     */
    public function deleteUserById($id){

        $statement = $this->connection->prepare('DELETE FROM "User" WHERE id = :id;');
        $statement->bindParam(':id', $id);
        $statement->execute();
    
        /* return some status */
    }


}
