<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Favorite;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/favorite", name="favorite")
     */
    public function index(Request $request): Response
    {
        $userId = $request->get('id_user');
        $announcementId = $request->get('id_announcement');

        $entityManager          = $this->getDoctrine()->getManager();
        $announcementRepository = $entityManager->getRepository(Announcement::class);
        $userRepository         = $entityManager->getRepository(User::class);
        $favoriteRepository     = $entityManager->getRepository(Favorite::class);

        $user         = $userRepository->find($userId);
        $announcement = $announcementRepository->find($announcementId);

        $favorite = $favoriteRepository->findOneBy(['id_user' => $user->getId(), 'id_announcement' => $announcement->getId()]);

        if (!$favorite) {
            $favorite = new Favorite();
            $favorite->setIdUser($user);
            $favorite->setIdAnnouncement($announcement);

            $entityManager->persist($favorite);
            $entityManager->flush();

            return $this->redirectToRoute('announcement_show', ["id" => $announcementId], Response::HTTP_SEE_OTHER);
        }
        $entityManager->remove($favorite);
        $entityManager->flush();

        return $this->redirectToRoute('announcement_show', ["id" => $announcementId], Response::HTTP_SEE_OTHER);
    }
}
