<?php

namespace App\Controller;

use App\Entity\Properties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/properties", name="admin_properties_")
 */
    class AdminPropertiesController extends AbstractController
{
    /**
     * @Route("/", name="all")
     */
    public function properties(): Response
    {
        $entityManager     = $this->getDoctrine()->getManager();
        $properties = $entityManager->getRepository(Properties::class)->findAll();

        return $this->render('admin/properties.html.twig', [
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"POST"})
     */
    public function addProperties(Request $request): Response
    {
        $property = new Properties();
        $query   = $request->request->all();
        $property->setTitle($query['new_property']);
        $property->setType($query['type']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($property);
        $entityManager->flush();

        return $this->redirectToRoute('admin_properties_all');
    }

    /**
     * @Route("/remove/{id}", name="delete", methods={"GET"})
     */
    public function removeProperties(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $property      = $entityManager->getRepository(Properties::class)->find($id);
        $entityManager->remove($property);
        $entityManager->flush();

        return $this->redirectToRoute('admin_properties_all');
    }
}
