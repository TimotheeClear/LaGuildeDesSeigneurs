<?php
namespace App\Service;
use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */
    public function create();

    /**
     * Gets all the characters
     */
    public function getAll();

    /**
     * Modifies the character
     */
    public function modify(Character $character);

    /**
     * Delete the character
     */
    public function delete(Character $character);

    //CharacterServiceInterface
    /**
     *  Gets images randomly
     */
    public function getImages(int $number, ?string $kind = null);

    /**
     *  Gets images randomly using kind
     */
    public function getImagesKind(string $kind, int $number);

}