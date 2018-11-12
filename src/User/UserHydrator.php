<?php

namespace User;


class UserHydrator
{

    public function extract(\User\User $object): array
    {
        $data = [];
        if ($object->getId()) {
            $data['id'] = $object->getId();
        }

        if ($object->getEmail()) {
            $data['email'] = $object->getEmail();
        }

        if ($object->getLogin()) {
            $data['login'] = $object->getLogin();
        }

        if ($object->getPassword()) {
            $data['password'] = $object->getPassword();
        }

        if ($object->getEcts()!== null) {
            $data['ects'] = $object->getEcts();
        }

        if ($object->isAdmin() !== null) {
            $data['isadmin'] = $object->isAdmin();
        }

        if ($object->isActif() !== null) {
            $data['isactif'] = $object->isActif();
        }
        return $data;
    }

    public function hydrate(array $data, \User\User $emptyEntity): \User\User
    {
        return $emptyEntity
            ->setId($data['id'] ?? null)
            ->setEmail($data['email'] ?? null)
            ->setLogin($data['login'] ?? null)
            ->setPassword($data['password'] ?? null)
            ->setEcts($data['ects'] ?? null)
            ->setIsAdmin($data['isadmin'] ?? null)
            ->setIsActif($data['isactif'] ?? null);
    }

}