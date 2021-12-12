<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Complaint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_admin_login');
        }
        if ($authChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('index');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $announcements = $entityManager->getRepository(Announcement::class)->findBy(['banned' => true]);

        $complaints = $entityManager->getRepository(Complaint::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'complaint'     => $complaints,
            'announcements' => $announcements,
        ]);
    }
}
