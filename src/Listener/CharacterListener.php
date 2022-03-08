<?php
namespace App\Listener;
use App\Event\CharacterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
Use DateTime;

class CharacterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(CharacterEvent::CHARACTER_CREATED => 'characterCreated',);
    }
    public function characterCreated($event)
    {
        $character = $event->getCharacter();
        if($character->getCreation() >= new DateTime('07-03-2022') && $character->getCreation() <= new DateTime('10-03-2022')){
            $character->setLife(20);
        }
    }
}