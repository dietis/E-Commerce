<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Store;
use App\Entity\Item;

class Admin_page extends AbstractController
{
    public function list()
    {
        // ...
    }

    /**
    * @Route("/admin", name="admin_page")
    */
    public function index() {
        $all_store = $this->getDoctrine()->getRepository(Store::class)->findAll();
        $all_items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        // ...
        return $this->render('admin.html.twig', [
            'page_title' => 'Admin Template',
            'all_store' => $all_store,
            'all_items' => $all_items,
        ]);
    }
}
