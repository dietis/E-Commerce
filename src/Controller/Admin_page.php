<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin_page extends AbstractController
{
    public function list()
    {
        // ...
    }

    /**
    * @Route("/", name="admin_page")
    */
    public function index() {
        // ...
        return $this->render('admin.html.twig', [
            'page_title' => 'Admin Template',
        ]);
    }
}
