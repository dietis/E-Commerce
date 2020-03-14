<?php
// src/Controller/.php
namespace App\Controller;

use App\Entity\Store;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class Store_gestion extends AbstractController
{
    /**
    * @Route("/Store_create", name="store_create_ajax")
    */
    public function add_store(Request $request, LoggerInterface $logger) {
        if ($request->isXMLHttpRequest()) {         
            $response = new JsonResponse();
            $response->setStatusCode(Response::HTTP_OK);

            $mastore = $request->request->all();

            $logger->error('An error occurred ' . json_encode($mastore));
            if ($mastore) {
                $entityManager = $this->getDoctrine()->getManager();
                $newstore = new Store();
                $newstore->setName($mastore['name']);
                $newstore->setDescription($mastore['description']);
                $newstore->setEnabled($mastore['state']);
                $newstore->setCreatedAt(new \DateTime());
                $newstore->setUpdatedAt(new \DateTime());

                //recup id
                $lastStore = $this->getDoctrine()->getRepository(Store::class)->findOneBy([], ['IdStore' => 'desc']);
                if ($lastStore) {
                    $lastId = $lastStore->getIdStore();
                    $logger->info('Store bien ajouté;) après ' . $lastId);
                    $newstore->setIdStore($lastId+1);
                }
                else {
                    $newstore->setIdStore(1);
                }
                $entityManager->persist($newstore);
                $entityManager->flush();
            }
            return $response;
        }
        else
            return new Response('This is not ajax!', 400);
    }
}
