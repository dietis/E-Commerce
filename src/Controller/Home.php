<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Store;
use App\Entity\Item;

class Home extends AbstractController
{
    public function list()
    {
        // ...
    }


    public function home() {
        $request = Request::createFromGlobals();
        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $response;
    }
    /**
    * @Route("/", name="home_page")
    */
    public function index() {
        // ...
        $all_store = $this->getDoctrine()->getRepository(Store::class)->findAll();
        $all_items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        return $this->render('home.html.twig', [
            'page_title' => 'Mamazon',
            'all_store' => $all_store,
            'all_items' => $all_items,
        ]);
    }
}
