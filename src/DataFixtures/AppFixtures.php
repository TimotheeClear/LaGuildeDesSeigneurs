<?php

namespace App\DataFixtures;

use App\Entity\Character;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $character = new Character();
            $character
                ->setKind('Seigneur')
                ->setName('Gorthol' . $i)
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
                ->setName('Eldalótë' . $i)
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
        }

        $manager->flush();
    }
}
