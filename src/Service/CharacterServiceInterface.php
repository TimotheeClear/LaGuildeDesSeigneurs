<?php
namespace App\Service;
use App\Entity\Character;

interface CharacterServiceInterface
{
    /**
     * Creates the character
     */
    public function create(string $data);

    /*** Checks if the entity has been well filled*/
    public function isEntityFilled(Character $character);

    /*** Submits the data to hydrate the object*/
    public function submit(Character $character, $formName, $data);

    /**
     * Gets all the characters
     */
    public function getAll();

    /**
     * Modifies the character
     */
    public function modify(Character $character,  string $data);

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