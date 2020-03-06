<?php
// src/Controller/.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class User extends AbstractController
{
    public function list()
    {
        // ...
    }


    public function User() {
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
    * @Route("User", name="user_page")
    */
    public function index() {
        // ...
        $mail = '';

        return $this->render('user.html.twig', [
            'page_title' => 'Titre',
            'category' => '...',
            'promotions' => ['...', '...'],
            'error' => '',
            'mail' => $mail,
        ]);
    }
    /**
    * @Route("User/register", name="user_register_page")
    */
    public function reg() {
        // ...
        return $this->render('register.html.twig', [
            'page_title' => 'Registre',
            'category' => '...',
            'promotions' => ['...', '...'],
        ]);
    }
}
