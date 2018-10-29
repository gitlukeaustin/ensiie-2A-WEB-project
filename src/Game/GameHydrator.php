<?php
namespace Game;

class GameHydrator
{
    public function extract(\Game\Game $object): array
    {
        $data = [];
        if ($object->getId()) {
            $data['id'] = $object->getId();
        }
        if ($object->getIdWinner()) {
            $data['id_winner'] = $object->getIdWinner();
        }
        if ($object->getIdPlayer1()) {
            $data['id_j1'] = $object->getIdPlayer1();
        }
        if ($object->getIdPlayer2()) {
            $data['id_j2'] = $object->getIdPlayer2();
        }
        if ($object->getPo()) {
            $data['po'] = $object->getPo();
        }
        if ($object->getStatus()) {
            $data['status'] = $object->getStatus();
        }
        if ($object->getCards()) {
            $data['cards'] = $object->getCards();
        }
        if ($object->getMessages()) {
            $data['messages'] = $object->getMessages();
        }
        if ($object->getCreatedAt()) {
            $data['createdat'] = $object->getCreatedAt();
        }
        
        return $data;
    }

    public function hydrate(array $data, \Game\Game $emptyGame): \Game\Game
    {
        return $emptyGame
            ->setId($data['id'] ?? null)
            ->setIdWinner($data['id_winner'] ?? null)
            ->setIdPlayer1($data['id_j1'] ?? null)
            ->setIdPlayer2($data['id_j2'] ?? null)
            ->setPo($data['po'] ?? null)
            ->setStatus($data['status'] ?? null)
            ->setCards($data['cards'] ?? null)
            ->setCreatedAt(join('-',array_reverse(explode('-',$data['createdat']))) ?? null)
            ->setMessages($data['messages'] ?? null);
    }
}