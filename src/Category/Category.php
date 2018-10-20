<?php
namespace Category;
	
class Category
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $attack;

    /**
     * @var int
     */
    private $defence;

    /**
     * @var float
     */
    private $chance;

     /**
     * @var int
     */
    private $cost;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return float
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * @return int
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @return int
     */
    public function getDefence()
    {
        return $this->defence;
    }


    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }


    /**
     * @param int $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int $type
     * @return Category
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param int $attack
     * @return Category
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;
        return $this;
    }

    /**
     * @param int $defence
     * @return Category
     */
    public function setDefence($defence)
    {
        $this->defence = $defence;
        return $this;
    }

    /**
     * @param float $chance
     * @return Category
     */
    public function setchance($chance)
    {
        $this->chance = $chance;
        return $this;
    }

    /**
     * @param cost $cost
     * @return Category
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }
}

