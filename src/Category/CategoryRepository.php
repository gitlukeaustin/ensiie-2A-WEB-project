<?php
namespace Category;

class CategoryRepository
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * CategoryRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll()
    {
        $rows = $this->connection->query('SELECT * FROM category ')->fetchAll(\PDO::FETCH_OBJ);
        $categorys = [];
        foreach ($rows as $row) {
            $category = new Category();
            $category
                ->setId($row->id)
                ->setType($row->type)
                ->setAttack($row->attack)
                ->setDefence($row->defence)
                ->setChance($row->chance)
                ->setCost($row->cost);

            $categorys[] = $category;
        }

        return $categorys;
    }


}
