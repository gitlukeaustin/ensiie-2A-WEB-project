<?php
namespace Category;

class CategoryHydrator
{
    public function extract(\Category\Category $object): array
    {
        $data = [];
        if ($object->getId()) {
            $data['id'] = $object->getId();
        }
        if ($object->getType()) {
            $data['type'] = $object->getType();
        }
        if ($object->getAttack()) {
            $data['attack'] = $object->getAttack();
        }
        if ($object->getDefence()) {
            $data['defence'] = $object->getDefence();
        }
        if ($object->getChance()) {
            $data['chance'] = $object->getChance();
        }
        if ($object->getCost()) {
            $data['cost'] = $object->getCost();
        }
        return $data;
    }
    public function hydrate(array $data, \Category\Category $emptyEntity): \Category\Category
    {
        return $emptyEntity
            ->setId($data['id'] ?? null)
            ->setType($data['type'] ?? null)
            ->setAttack($data['attack'] ?? 0)
            ->setDefence($data['defence'] ? $data['defence'] : null)
            ->setChance($data['chance'] ? $data['chance'] : null)
            ->setCost($data['cost'] ? $data['cost'] : null);
    }
}