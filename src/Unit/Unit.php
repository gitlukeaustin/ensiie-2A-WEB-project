<?php
namespace Unit;
	
class Unit
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $id_cat;

    /**
     * @var int
     */
    private $atckbonus;

    /**
     * @var int
     */
    private $defbonus;

    /**
     * @var float
     */
    private $chancebonus;

     /**
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIdCat()
    {
        return $this->id_cat;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getChanceBonus()
    {
        return $this->chancebonus;
    }

    /**
     * @return int
     */
    public function getAtckBonus()
    {
        return $this->atckbonus;
    }

    /**
     * @return int
     */
    public function getDefBonus()
    {
        return $this->defbonus;
    }


    /**
     * @param int $id
     * @return Unit
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int $name
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $id_cat
     * @return Unit
     */
    public function setIdCat($id_cat)
    {
        $this->id_cat = $id_cat;
        return $this;
    }

    /**
     * @param int $atckbonus
     * @return Unit
     */
    public function setAtckBonus($atckbonus)
    {
        $this->atckbonus = $atckbonus;
        return $this;
    }

    /**
     * @param int $defbonus
     * @return Unit
     */
    public function setDefBonus($defbonus)
    {
        $this->defbonus = $defbonus;
        return $this;
    }

    /**
     * @param float $chancebonus
     * @return Unit
     */
    public function setChanceBonus($chancebonus)
    {
        $this->chancebonus = $chancebonus;
        return $this;
    }

    /**
     * @param string $description
     * @return Unit
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}

