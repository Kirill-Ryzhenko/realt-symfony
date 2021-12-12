<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Favorite;
use App\Form\EditUserType;
use App\Repository\AnnouncementRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile", methods={"GET"})
     */
    public function index(int $id): Response
    {
        $entityManager   = $this->getDoctrine()->getManager();
        $announcementsDB = $entityManager->getRepository(Announcement::class)->findBy(['id_user' => $id]);
        $favorites       = $entityManager->getRepository(Favorite::class)->findBy(['id_user' => $id]);

        $var = [];
        foreach ($favorites as $favi) {
            $var[] = $favi->getIdAnnouncement();
        }

        $announcements = [
            'sales'     => array_filter($announcementsDB, function ($el) {
                return $el->getType() === 'sale';
            }),
            'rents'     => array_filter($announcementsDB, function ($el) {
                return $el->getType() === 'rent';
            }),

        ];

        return $this->render('profile/profile.html.twig', [
            'sales'     => $announcements['sales'],
            'rents'     => $announcements['rents'],
            'favorites' => $var,
            'isProfile' => true,
        ]);
    }

    /**
     * @Route("/profile/edit/{id}", name="profile_edit", methods={"GET", "POST"})
     */
    public function edit(int $id, Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('profile', ['id' => $id]);
        }
        return $this->render('profile/edit_profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/remove/{id}", name="profile_remove")
     */
    public function remove(
        int                    $id,
        UserRepository         $userRepository,
        AnnouncementRepository $announcementRepository,
        FileUploader           $fileUploader,
        Session                $session
    ): Response {

        $photos = $announcementRepository->findPhotosByUser($id);
        $fileUploader->removePhotosFromUser($photos);
        $user = $userRepository->find($id);

        $session = new Session();
        $session->invalidate();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('index');

    }
}
