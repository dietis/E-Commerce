<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Store;
use App\Entity\Item;
use App\Entity\ShoppingCart;
use Psr\Log\LoggerInterface;


class Cart_gestion extends AbstractController
{
    /**
    * @Route("/cart/add_item_ajax", name="add_item_to_cart_ajax")
    */
    public function item_to_cart(Request $request, LoggerInterface $logger) {
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $userid = $user->getId();
            $entityManager = $this->getDoctrine()->getManager();

            if (!$user->getUserShoppingCart()) {
                $shcart = new ShoppingCart();
                $lastsc = $this->getDoctrine()->getRepository(ShoppingCart::class)->findOneBy([], ['IdShopping_cart' => 'desc']);
                if ($lastsc) {
                    $lastId = $lastsc->getIdShoppingCart();
                    $shcart->setIdShoppingCart($lastId+1);
                    $logger->info('New shopping cart not first');
                }
                else {
                    $shcart->setIdShoppingCart(1);
                    $logger->info('New shopping cart first');
                }
                $shcart->setFkUser($user);
                $entityManager->persist($shcart);
                $entityManager->flush();
            }
            else {
                    $logger->info('Shopping cart aldready existing');
            }

            $response = new JsonResponse();
            $response->setStatusCode(Response::HTTP_OK);
            $all_items = $this->getDoctrine()->getRepository(Item::class)->findAll();
            $all_carts = $this->getDoctrine()->getRepository(ShoppingCart::class)->findAll();

            foreach ($all_carts as $cart) {
                if ($cart->getFkUser() == $user) {
                    $logger->error('testXXX');
                    $mavar = $request->request->all();
                    $item = $this->getDoctrine()->getRepository(Item::class)->find($mavar['id']);
                    $cart->addFkItem($item);
                    foreach ($cart->getFkItem() as $item) {
                        $logger->error('testZZZ');
                        
                    }
                    $entityManager->persist($cart);
                    $entityManager->flush();
                }
                //user->getUserShoppingCart()getFkUser
            }
            //$logger->error('test1 ');
            return $response;
        }
        else
            return new Response('This is not ajax!', 400);
    }

    /**
    * @Route("/cart", name="cart_home")
    */
    public function index() {
        // ...
        $all_store = $this->getDoctrine()->getRepository(Store::class)->findAll();
        $all_items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        $all_carts = $this->getDoctrine()->getRepository(ShoppingCart::class)->findAll();
        $user = $this->getUser();
        return $this->render('cart.html.twig', [
            'page_title' => 'Mamazon',
            'all_store' => $all_store,
            'all_items' => $all_items,
            'all_carts' => $all_carts,
            'user' => $user,
        ]);
    }

    /**
    * @Route("/cart/paying", name="validate_checkout")
    */
    public function Checkout(Request $request, LoggerInterface $logger) {
        $response = new JsonResponse();
        $response->setStatusCode(Response::HTTP_OK);
        $all_items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        $all_carts = $this->getDoctrine()->getRepository(ShoppingCart::class)->findAll();
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->isXMLHttpRequest()) {         
            foreach ($all_carts as $cart) {
            if ($cart->getFkUser() == $user) {
                $mavar = $request->request->all();
                //$item = $this->getDoctrine()->getRepository(Item::class)->find($mavar['id']);
                foreach ($cart->getFkItem() as $item) {
                    $cart->removeFkItem($item);
                }
                $entityManager->persist($cart);
                $entityManager->flush();
            }
        }
            //user->getUserShoppingCart()getFkUser
        return $response;
    }
    else
        return new Response('This is not ajax!', 400);
    }

    /**
    * @Route("/cart/delete", name="remove_item_to_cart_ajax")
    */
    public function delete_cart_item(Request $request, LoggerInterface $logger) {
        $response = new JsonResponse();
        $response->setStatusCode(Response::HTTP_OK);
        $all_items = $this->getDoctrine()->getRepository(Item::class)->findAll();
        $all_carts = $this->getDoctrine()->getRepository(ShoppingCart::class)->findAll();
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->isXMLHttpRequest()) {         
            foreach ($all_carts as $cart) {
            if ($cart->getFkUser() == $user) {
                $mavar = $request->request->all();
                $item = $this->getDoctrine()->getRepository(Item::class)->find($mavar['id']);
                $cart->removeFkItem($item);
                $entityManager->persist($cart);
                $entityManager->flush();
            }
        }
            //user->getUserShoppingCart()getFkUser
        return $response;
    }
    else
        return new Response('This is not ajax!', 400);
    }
}
