<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CharacterController extends AbstractController
{
    //INDEX
    /**
     * Redirects to index Route
     * 
     * @Route("/character",
     *  name="character_redirect_index",
     *  methods={"GET","HEAD"})
     * 
     * @OA\Response(
     *     response=302,
     *     description="Redirect",
     * )
     * @OA\Tag(name="Character")
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }

    //INDEX
    /**
     * Displays available Characters
     * 
     * @Route("/character/index",
     *  name="character_index",
     *  methods={"GET", "HEAD"})
     
    * @OA\Response(
    *     response=200,
    *     description="Success",
    *     @OA\Schema(
    *         type="array",
    *         @OA\Items(ref=@Model(type=Character::class))
    *     )
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\Tag(name="Character")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAll();
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }
    
    //SHOW min intelligence
    /**
     * Displays Characters smartest than the input
     * 
     * @Route("/character/show_min_intelligence/{minIntelligence}",
     *  name="character_show_min_intelligence",
     *  requirements={"minIntelligence": "^([0-9])*$"},
     *  methods={"GET", "HEAD"})
     
    * @OA\Response(
    *     response=200,
    *     description="Success",
    *     @OA\Schema(
    *         type="array",
    *         @OA\Items(ref=@Model(type=Character::class))
    *     )
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )

    * @OA\Parameter(
    *     name="minIntelligence",
    *     in="path",
    *     description="minIntelligence for the Character",
    *     required=true
    * )

    * @OA\Tag(name="Character")
     */

    public function show_min_intelligence(int $minIntelligence)
    {
        $this->denyAccessUnlessGranted('characterShowMinIntelligence', null);
        $characters = $this->characterService->showMinIntelligence($minIntelligence);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    //MODIFY
    /**
     * Modifies the Character
     * 
     * @Route("/character/modify/{identifier}",
     *  name="character_modify",
     *  requirements={"identifier": "^([a-z0-9]{40})$"},
     *  methods={"PUT", "HEAD"}
    * )
    * 
    * @OA\Response(
    *     response=200,
    *     description="Success",
    *     @Model(type=Character::class)
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\Parameter(
    *     name="identifier",
    *     in="path",
    *     description="identifier for the Character",
    *     required=true
    * )
    * @OA\RequestBody(
    *     request="Character",
    *     description="Data for the Character",
    *     required=true,
    *     @OA\MediaType(
    *         mediaType="application/json",
    *         @OA\Schema(ref="#/components/schemas/Character")
    *     )
    * )
    * @OA\Tag(name="Character")
     */
    public function modify(Request $request, Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->modify($character, $request->getContent());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //DELETE
    /**
     * Deletes the Character
     * 
     * @Route("/character/delete/{identifier}",
     *  name="character_delete",
     *  requirements={"identifier": "^([a-z0-9]{40})$"},
     *  methods={"DELETE", "HEAD"}
     * )
     
    * @OA\Response(
    *     response=200,
    *     description="Success",
    *     @OA\Schema(
    *         @OA\Property(property="delete", type="boolean"),
    *     )
    * )
    * @OA\Response(
    *     response=403,
    *     description="Access denied",
    * )
    * @OA\Parameter(
    *     name="identifier",
    *     in="path",
    *     description="identifier for the Character",
    *     required=true
    * )
    * @OA\Tag(name="Character")
     */
    public function delete(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);
        $response = $this->characterService->delete($character);
        return new JsonResponse(array('delete' => $response));
    }

    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    // /**
    //  * @Route("/character",
    //  * name="character"),
    //  * methods={"GET", "HEAD"})
    //  */
    // public function index(): Response
    // {
    //     return $this->render('character/index.html.twig', [
    //         'controller_name' => 'CharacterController',
    //     ]);
    // }

    //DISPLAY
    /**
     * Displays the Character
     * 
     * @Route("/character/display/{identifier}",
     * name="character_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET", "HEAD"})
     * @Entity("character", expr="repository.findOneByIdentifier(identifier)")
     * 
     * @OA\Parameter(
     *     name="identifier",
     *     in="path",
     *     description="identifier for the Character",
     *     required=true,
     * )
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function display(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //CREATE
    /**
     * Creates the Character
     * 
     * @Route("/character/create",
     * name="character_create",
     * methods={"POST","HEAD"})
     *
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Character::class)
     * )
     * @OA\Response(
     *     response=403,
     *     description="Access denied",
     * )
     * @OA\RequestBody(
     *     request="Character",
     *     description="Data for the Character",
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/Character")
     *     )
     * )
     * @OA\Tag(name="Character")
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('characterCreate');

        $character = $this->characterService->create($request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //IMAGES
    /**
     * Returns images randomly
     * @Route("/character/images/{number}",
     *      name="character_images",
     *      requirements={"number": "^([0-9]{1,2})$"},
     *      methods={"GET", "HEAD"}* )
     */
    public function images(int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImages($number));
    }

    //IMAGES
    /**
     *  Returns images randomly using kind
     *  @Route("/character/images/{kind}/{number}",
     *      name="character_images_kind",
     *      requirements={"number": "^([0-9]{1,2})$", "kind": "^(dames|ennemies|ennemis|seigneurs)$"},
     *      methods={"GET", "HEAD"}
     *  )
     */
    public function imagesKind(string $kind, int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImagesKind($kind, $number));
    }
}
