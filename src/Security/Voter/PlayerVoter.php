<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Player;
use LogicException;

class PlayerVoter extends Voter
{
    public const CHARACTER_DISPLAY = 'playerDisplay';
    public const CHARACTER_CREATE = 'playerCreate';
    public const CHARACTER_INDEX = 'playerIndex';
    public const CHARACTER_MODIFY = 'playerModify';
    public const CHARACTER_DELETE = 'playerDelete';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE,
        self::CHARACTER_INDEX,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE,
    );

    protected function supports(string $attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Player && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'POST_VIEW'])
            && $subject instanceof \App\Entity\Player;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        //Defines access rights
        switch ($attribute) {
            case self::CHARACTER_DISPLAY:
            case self::CHARACTER_INDEX:
                return $this->canDisplay();
                break;
            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;
            case self::CHARACTER_MODIFY:
                return $this->canModify();
                break;
            case self::CHARACTER_DELETE:
                return $this->canDelete();
                break;
        }
        throw new LogicException('Invalid attribute: ' . $attribute);
    }

    /**
     * Checks if is allowed to dispaly
     */
    private function canDisplay()
    {
        return true;
    }

    /**
     * Checks if is allowed to create
     */
    private function canCreate()
    {
        return true;
    }

    /**
     * Checks if is allowed to modify
     */
    private function canModify()
    {
        return true;
    }

    /**
     * Checks if is allowed to modify
     */
    private function canDelete()
    {
        return true;
    }
}
