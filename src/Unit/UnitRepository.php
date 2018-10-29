<?php
namespace Unit;
class UnitRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * UserRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT * FROM unit')->fetchAll(\PDO::FETCH_OBJ);
        $units = [];
        foreach ($rows as $row) {
            $unit = new Unit();
            $unit
                ->setId($row->id)
                ->setName($row->name)
                ->setIdCat($row->id_cat)
                ->setAtckBonus($row->atckbonus)
                ->setDefBonus($row->defbonus)
                ->setChanceBonus($row->chancebonus)
                ->setDescription($row->description);

            $units[] = $unit;
        }

        return $units;
    }


}
