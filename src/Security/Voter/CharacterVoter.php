<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Character;
use LogicException;

class CharacterVoter extends Voter
{
    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_INDEX = 'characterIndex';
    public const CHARACTER_MODIFY = 'characterModify';
    public const CHARACTER_DELETE = 'characterDelete';
    public const CHARACTER_MIN_INTELLIGENCE = 'characterShowMinIntelligence';
    public const CHARACTER_MIN_LIFE = 'characterShowMinLife';
    public const CHARACTER_SAME_CASTE = 'characterShowSameCaste';
    public const CHARACTER_SAME_KNOWLEDGE = 'characterShowSameKnowledge';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE,
        self::CHARACTER_INDEX,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE,
        self::CHARACTER_MIN_INTELLIGENCE,
        self::CHARACTER_MIN_LIFE,
        self::CHARACTER_SAME_CASTE,
        self::CHARACTER_SAME_KNOWLEDGE,
    );

    protected function supports(string $attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'POST_VIEW'])
            && $subject instanceof \App\Entity\Character;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        //Defines access rights
        switch ($attribute) {
            case self::CHARACTER_DISPLAY:
            case self::CHARACTER_MIN_INTELLIGENCE:
            case self::CHARACTER_MIN_LIFE:
            case self::CHARACTER_SAME_CASTE:
            case self::CHARACTER_SAME_KNOWLEDGE:
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
