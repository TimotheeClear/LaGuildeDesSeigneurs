<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class CharacterController extends AbstractController
{
    /**
     * @Route("/character",
     *  name="character_redirect_index",
     *  methods={"GET","HEAD"})
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/character/index",
     *  name="character_index",
     *  methods={"GET", "HEAD"})
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAll();
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    //MODIFY
    /**
     * @Route("/character/modify/{identifier}",
     *  name="character_modify",
     *  requirements={"identifier": "^([a-z0-9]{40})$"},
     *  methods={"PUT", "HEAD"}
     * )
     */
    public function modify(Request $request, Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->modify($character, $request->getContent());
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //DELETE
    /**
     * @Route("/character/delete/{identifier}",
     *  name="character_delete",
     *  requirements={"identifier": "^([a-z0-9]{40})$"},
     *  methods={"DELETE", "HEAD"}
     * )
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

    /**
     * @Route("/character/display/{identifier}",
     * name="character_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET", "HEAD"})
     * @Entity("character", expr="repository.findOneByIdentifier(identifier)")
     */
    public function display(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    /**
     * @Route("/character/create",
     * name="character_create",
     * methods={"POST","HEAD"})
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
