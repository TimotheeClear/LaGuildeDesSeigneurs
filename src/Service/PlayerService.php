<?php

namespace App\Service;

use DateTime;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerRepository;

class PlayerService implements PlayerServiceInterface
{
    private $em;
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository, EntityManagerInterface $em){
        $this->playerRepository = $playerRepository;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $player = new Player();
        $player
            ->setFirstname('Timothée')
            ->setLastname('Cléar')
            ->setEmail('timothee.clear@gmail.com')
            ->setMirian(100000)
            ->setIdentifier(hash("sha1", uniqid()))
            ->setCreationDate(new DateTime())
            ->setModificationDate(new DateTime())
            ->setLastConnectionDate(new DateTime())
        ;

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $playersFinal = array();
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $playersFinal[] = $player->toArray();
        }
        return $playersFinal;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Player $player){
        $player
            ->setFirstname('TIMothée')
            ->setLastname('Cléar')
            ->setEmail('timothee.clear@gmail.com')
            ->setMirian(100000)
            ->setModificationDate(new DateTime())
        ;

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Player $player){
        
        $this->em->remove($player);
        $this->em->flush();

        return true;
    }

}