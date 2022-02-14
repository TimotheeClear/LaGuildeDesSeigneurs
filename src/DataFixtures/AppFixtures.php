<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Player;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
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
        $manager->persist($player);

        $player = new Player();
        $player
            ->setFirstname('Simon')
            ->setLastname('Parrot')
            ->setEmail('simon.parrot@gmail.com')
            ->setMirian(100000)
            ->setIdentifier(hash("sha1", uniqid()))
            ->setCreationDate(new DateTime())
            ->setModificationDate(new DateTime())
            ->setLastConnectionDate(new DateTime())
        ;
        $manager->persist($player);

        $character = new Character();
        $character
            ->setKind('Seigneur')
            ->setName('Gorthol')
            ->setSurname('Haume de terreur')
            ->setCaste('Chevalier')
            ->setKnowledge('Diplomatie')
            ->setIntelligence(110)
            ->setLife(11)
            ->setImage('/images/gorthol.jpg')
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new DateTime())
        ;
        $manager->persist($character);

        $character = new Character();
        $character
            ->setKind('Dame')
            ->setName('Eldalótë')
            ->setSurname('Fleur elfique')
            ->setCaste('Elfe')
            ->setKnowledge('Arts')
            ->setIntelligence(150)
            ->setLife(10)
            ->setImage('/images/eldalote.jpg')
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new DateTime())
        ;
        $manager->persist($character);


        $manager->flush();
    }
}
