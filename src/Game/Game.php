<?php
namespace Game;

class Game
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $id_j1;

    /**
     * @var int
     */
    private $id_j2;

    /**
     * @var int
     */
    private $id_winner;

    /**
     * @var int
     */
    private $po;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $cards;

    /**
     * @var string
     */
    private $messages;

    /**
     * @var date
     *
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Game
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdWinner()
    {
        return $this->id_winner;
    }

    /**
     * @param int $id
     * @return Game
     */
    public function setIdWinner($id)
    {
        $this->id_winner = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdPlayer1()
    {
        return $this->id_j1;
    }

    /**
     * @param int $id
     * @return Game
     */
    public function setIdPlayer1($id)
    {
        $this->id_j1 = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdPlayer2()
    {
        return $this->id_j2;
    }

    /**
     * @param int $id
     * @return Game
     */
    public function setIdPlayer2($id)
    {
        $this->id_j2 = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPo()
    {
        return $this->po;
    }

    /**
     * @param int $id
     * @return Game
     */
    public function setPo($po)
    {
        $this->po = $po;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string status
     * @return Game
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param string cards
     * @return Game
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param string msg
     * @return Game
     */
    public function setMessages($msg)
    {
        $this->messages = $msg;
        return $this;
    }

    /**
     * @return date
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param date date
     * @return Game
     */
    public function setCreatedAt($date) {
        $this->createdAt=$date;
        return $this;
    }
}
