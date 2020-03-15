<?php
// src/Controller/.php
namespace App\Controller;

use App\Entity\Item;
use App\Entity\Store;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use Symfony\Component\HttpKernel\KernelInterface;

use Symfony\Component\HttpFoundation\File\File;

class Item_gestion extends AbstractController
{
    /**
    * @Route("/Item_create", name="item_create_ajax")
    */
    public function add_item(Request $request, LoggerInterface $logger) {
        if ($request->isXMLHttpRequest()) {         
            $response = new JsonResponse();
            $response->setStatusCode(Response::HTTP_OK);
            $mastore = $request->request->all();
            $uploads = $request->files->get('photo');

            $logger->error('An error occurred ' . json_encode($mastore));
            if ($mastore) {
                $entityManager = $this->getDoctrine()->getManager();
                $newitem = new Item();
                if(!is_null($uploads)) {
                    $logger->info('Not nulled = ' . json_encode($uploads) . $uploads->getClientOriginalExtension());
    
                    $fileName = md5(uniqid()).'.'.$uploads->guessExtension();
    
                    // set your uploads directory
                    $uploadDir = $this->getParameter('kernel.project_dir') . '/public/images/';

                    $logger->info('There = ' . $this->getParameter('kernel.project_dir'));
                    if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
                        mkdir($uploadDir, 0775, true);
                    }
                    if ($uploads->move($uploadDir, $fileName)) { 
                        $output['uploaded'] = true;
                        $output['fileName'] = $fileName;
                        $logger->info('Image bien sauvegarder' . json_encode($output));
                        $newitem->setImage($fileName);
                    }
                }

                $newitem->setName($mastore['name']);
                $newitem->setPrice($mastore['price']);
                $newitem->setWeight($mastore['weight']);
                $newitem->setEnabled(1);


                //recup fk magasin (id)
                if ($mastore['store'] != 0) {
                    $fk_store = $this->getDoctrine()->getRepository(Store::class)->find($mastore['store']);
                    $newitem->addFkStore($fk_store);
                } else {
                    $fk_store = $this->getDoctrine()->getRepository(Store::class)->find(1);
                    $newitem->addFkStore($fk_store);
                }
                //recup id
                $lastItem = $this->getDoctrine()->getRepository(Item::class)->findOneBy([], ['IdItem' => 'desc']);
                if ($lastItem) {
                    $lastId = $lastItem->getIdItem();
                    $logger->info('Store bien ajouté;) après ' . $lastId);
                    $newitem->setIdItem($lastId+1);
                }
                else {
                    $newitem->setIdItem(1);
                }
                $entityManager->persist($newitem);
                $entityManager->flush();
            }
            return $response;
        }
        else
            return new Response('This is not ajax!', 400);
    }
}
