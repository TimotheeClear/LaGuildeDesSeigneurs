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
     * Gets all the characters smartest (>=) than the input
     */
    public function showMinIntelligence(int $minIntelligence);

    /**
     * Modifies the character
     */
    public function modify(Character $character, string $data);

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

    /**
     *  Serialize the object(s)
     */
    public function serializeJson($data);
    
    /**
     * Creates the character from html form
     */
    public function createFromHtml(Character $character);
}
