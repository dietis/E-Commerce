<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\NewItemType;
use App\Entity\Item;
use Symfony\Component\HttpFoundation\Request;

class NewItemController extends AbstractController
{
    /**
     * @Route("/new/item", name="new_item")
     */
    public function index(Request $request)
    {
        $item = new Item(); 
        
        
        $form = $this->createForm(NewItemType::class, $item, [
            'action' => $this->generateUrl('new_item'),
        ]);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //var_dump($item); die;

            $em = $this->getDoctrine()->getManager();

            $em->persist($item);
            $em->flush();
        }
        
        
        return $this->render('new_item/index.html.twig', [
            'item_form' => $form->createView(),
        ]);
    }
}
