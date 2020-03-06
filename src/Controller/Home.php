<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->render('home.html.twig', [
            'page_title' => 'Mamazon',
            'category' => '...',
            'promotions' => ['...', '...'],
        ]);
    }
}
