<?php
namespace App\Listener;
use App\Event\PlayerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
Use DateTime;

class PlayerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(PlayerEvent::PLAYER_MODIFIED => 'PlayerModified',);
    }
    public function playerModified($event)
    {
        $player = $event->getPlayer();
        $player->setMirian($player->getMirian()-10);
    }
}