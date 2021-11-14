<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Properties;
use App\Repository\PropertiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $sales         = $entityManager->getRepository(Announcement::class)->findBy(
            ['type' => 'sale'],
            null,
            8
        );
        $rents         = $entityManager->getRepository(Announcement::class)->findBy(
            ['type' => 'rent'],
            null,
            8
        );
        return $this->render('default/index.html.twig', [
            'sales' => $sales,
            'rents' => $rents,
        ]);
    }
}
