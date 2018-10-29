<?php
namespace User;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $ects;

    /**
     * @var boolean
     */
    private $isAdmin;

    /**
     * @var boolean
     */
    private $isActif;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getEcts()
    {
        return $this->ects;
    }

    /**
     * @param int $ects
     * @return User
     */
    public function setEcts($ects)
    {
        $this->ects = $ects;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActif()
    {
        return $this->isActif;
    }

    /**
     * @param bool $isActif
     * @return User
     */
    public function setIsActif($isActif)
    {
        $this->isActif = $isActif;
        return $this;
    }
}