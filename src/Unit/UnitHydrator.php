<?php
namespace Unit;

class UnitHydrator
{
    public function extract(\Unit\Unit $object): array
    {
        $data = [];
        if ($object->getId()) {
            $data['id'] = $object->getId();
        }
        if ($object->getIdCat()) {
            $data['id_cat'] = $object->getIdCat();
        }
        if ($object->getName()) {
            $data['name'] = $object->getName();
        }
        if ($object->getAtckBonus()) {
            $data['atck_bonus'] = $object->getAtckBonus();
        }
        if ($object->getDefBonus()) {
            $data['def_bonus'] = $object->getDefBonus();
        }
        if ($object->getChanceBonus()) {
            $data['chance_bonus'] = $object->getChanceBonus();
        }
        if ($object->getDescription()) {
            $data['description'] = $object->getDescription();
        }
        return $data;
    }
    public function hydrate(array $data, \Unit\Unit $emptyEntity): \Unit\Unit
    {
        return $emptyEntity
            ->setId($data['id'] ?? null)
            ->setIdCat($data['id_cat'] ?? null)
            ->setName($data['name'] ?? null)
            ->setAtckBonus($data['atck_bonus'] ?? null)
            ->setDefBonus($data['def_bonus'] ? $data['def_bonus'] : null)
            ->setChanceBonus($data['chance_bonus'] ? $data['chance_bonus'] : null)
            ->setDescription($data['description'] ? $data['description'] : null);
    }
}