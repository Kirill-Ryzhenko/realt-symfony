<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Complaint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComplaintController extends AbstractController
{
    /**
     * @Route("/complaint", name="complaint")
     */
    public function index(Request $request): Response
    {
        $announcementId = $request->get('id_announcement');
        $description    = $request->get('description');

        $entityManager          = $this->getDoctrine()->getManager();
        $announcementRepository = $entityManager->getRepository(Announcement::class);
        $announcement           = $announcementRepository->find($announcementId);

        $complaint = new Complaint();
        $complaint->setDescription($description);
        $complaint->setIdAnnouncement($announcement);

        $entityManager->persist($complaint);
        $entityManager->flush();

        return $this->redirectToRoute('announcement_show', ["id" => $announcementId], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/complaint/ban/{id}", name="complaint-ban")
     */
    public function ban(Request $request, int $id): Response
    {
        $entityManager       = $this->getDoctrine()->getManager();
        $complaintRepository = $entityManager->getRepository(Complaint::class);
        $complaint           = $complaintRepository->find($id);

        $announcement = $entityManager->getRepository(Announcement::class)->find($complaint->getIdAnnouncement());
        $announcement->setBanned(true);

        $entityManager->persist($announcement);
        $entityManager->flush();

        $entityManager->remove($complaint);
        $entityManager->flush();

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("/complaint/unban/{id}", name="complaint-unban")
     */
    public function unban(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $announcement = $entityManager->getRepository(Announcement::class)->find($id);
        $announcement->setBanned(false);

        $entityManager->persist($announcement);
        $entityManager->flush();

        return $this->redirectToRoute('admin_index');
    }
}
