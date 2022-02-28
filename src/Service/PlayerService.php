<?php

namespace App\Service;

use DateTime;
use App\Entity\Player;
use App\Form\PlayerType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerRepository;
use Symfony\Component\Finder\Finder;
use LogicException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PlayerService implements PlayerServiceInterface
{
    private $em;
    private $playerRepository;
    private $formFactory;

    public function __construct(PlayerRepository $playerRepository, EntityManagerInterface $em, FormFactoryInterface $formFactory){
        $this->playerRepository = $playerRepository;
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $data)
    {
        //Use with {"firstname":"Tim","lastname":"Cléar","email":"truc@machin.fr","mirian":14}
        $player = new Player();
        $player
            ->setIdentifier(hash("sha1", uniqid()))
            ->setCreationDate(new DateTime())
            ->setModificationDate(new DateTime())
            ->setLastConnectionDate(new DateTime())
        ;
        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);

        $this->em->persist($player);
        $this->em->flush();

        return $player;
    }
    

    /**
     * {@inheritdoc}
     */
    public function isEntityFilled(Player $player)
    {
        if (null === $player->getFirstname() ||
            null === $player->getLastname() ||
            null === $player->getEmail() ||
            null === $player->getMirian() ||
            null === $player->getIdentifier() ||
            null === $player->getCreationDate() ||
            null === $player->getModificationDate() ||
            null === $player->getLastConnectionDate()) {
            throw new UnprocessableEntityHttpException('Missing data for Entity -> ' . json_encode($player->toArray()));
        }
    }
   
    /**
     * {@inheritdoc}
     */
    public function submit(Player $player, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $player, ['csrf_protection' => false]);
        $form->submit($dataArray, false);//With false, only submitted fields are validated

        //Gets errors
        $errors = $form->getErrors();
        foreach ($errors as $error) {
            throw new LogicException('Error ' . get_class($error->getCause()) . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters()));
        }
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
    public function modify(Player $player, string $data){
        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);
        $player
            // ->setFirstname('TIMothée')
            // ->setLastname('Cléar')
            // ->setEmail('timothee.clear@gmail.com')
            // ->setMirian(100000)
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