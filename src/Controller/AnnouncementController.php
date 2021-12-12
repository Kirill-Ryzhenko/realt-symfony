<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Complaint;
use App\Entity\Favorite;
use App\Entity\Properties;
use App\Entity\User;
use App\Form\AnnouncementType;
use App\Form\FilterAnnouncementType;
use App\Repository\AnnouncementRepository;
use App\Service\AnnouncementFilter;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/announcement")
 */
class AnnouncementController extends AbstractController
{
    /**
     * @Route("/{id}", name="announcement_show", methods={"GET"})
     * @Route("/{id}/{idComplaint}", name="announcement_show_complaint", methods={"GET"})
     */
    public function show(int $id, AnnouncementRepository $announcementRepository, AuthorizationCheckerInterface $authChecker, UserInterface $user, int $idComplaint = null): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $announcement  = $announcementRepository->findAnnouncementUser($id);
        $isFavorite    = false;
        if ($authChecker->isGranted('ROLE_USER')) {
            $userId   = $user->getId();
            $userAuth = $entityManager->getRepository(User::class)->find($userId);
            $favorite = $entityManager->getRepository(Favorite::class)->findOneBy(['id_user' => $userId, 'id_announcement' => $id]);
            if ($favorite)
                $isFavorite = true;
        }

        $isBanned  = $announcement[0]->getBanned();
        $complaint = null;
        if ($idComplaint != null) {
            $complaint = $entityManager->getRepository(Complaint::class)->find($idComplaint);
        }

        return $this->render('announcement/show.html.twig', [
            'announcement' => $announcement[0],
            'isFavorite'   => $isFavorite,
            'complaint'    => $complaint,
            'isBanned'     => $isBanned,
        ]);
    }

    /**
     * @Route("/new/{type}", name="announcement_new", methods={"GET","POST"})
     */
    public function new(string $type, Request $request, FileUploader $fileUploader, UserInterface $user = null): Response
    {
        $announcement = new Announcement();
        $announcement->setType($type);

        $form = $this->createForm(AnnouncementType::class, $announcement, [
            'typeAnnouncement' => $type,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files     = $form->get('photos')->getData();
            $filenames = $fileUploader->upload($files);
            $announcement->setPhotos($filenames);

            $userId = null !== $user ? $user->getId() : null;

            $entityManager = $this->getDoctrine()->getManager();
            $userAuth      = $entityManager->getRepository(User::class)->find($userId);
            $announcement->setIdUser($userAuth);

            $entityManager->persist($announcement);
            $entityManager->flush();

            return $this->redirectToRoute('profile', ["id" => $userId], Response::HTTP_SEE_OTHER);
        }

        return $this->render('announcement/new.html.twig', [
            'title'        => 'Продать квартиру',
            'announcement' => $announcement,
            'form'         => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="announcement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Announcement $announcement, FileUploader $fileUploader, UserInterface $user): Response
    {
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPhoto = $request->request->get('photos_edit');
            $newPhoto     = $form->get('photos')->getData();

            $newFilenames = $fileUploader->upload($newPhoto);
            $removeFiles  = array_diff($announcement->getPhotos(), $currentPhoto);
            $filenames    = array_merge($currentPhoto, $newFilenames);
            $fileUploader->removePhotos($removeFiles);

            $announcement->setPhotos($filenames);
            $this->getDoctrine()->getManager()->flush();

            $userId = $user->getId();
            return $this->redirectToRoute('profile', ["id" => $userId], Response::HTTP_SEE_OTHER);
        }

        return $this->render('announcement/edit.html.twig', [
            'announcement' => $announcement,
            'form'         => $form->createView(),
            'photos'       => $announcement->getPhotos(),
        ]);
    }

    /**
     * @Route("/catalog/{type}", name="announcement_filter", methods={"GET"})
     */
    public function filter($type, AnnouncementFilter $announcementFilter, Request $request): Response
    {
        if ($type !== ('sale' || 'rent')) {
            $this->redirectToRoute('index');
        }

        $entityManager          = $this->getDoctrine()->getManager();
        $announcementRepository = $entityManager->getRepository(Announcement::class);

        $defaultParameters = $announcementRepository->getParametersForFiltration($type);

        $query          = $request->query->all();
        $templateParams = $announcementFilter->generateParamsTemplate($type, $query, $defaultParameters);
        $paramsDB       = $announcementFilter->generateParamsDB($type, $query, $defaultParameters);
        $currentPage    = $announcementFilter->getCurrentPage($query);

        $select              = $entityManager->getRepository(Properties::class)->findAll();
        $announcementsOnPage = 8;
        $announcements       = $announcementRepository->getFiltrationAnnouncement($paramsDB);
        $count               = count($announcements);
        $countPage           = ceil($count / $announcementsOnPage);
//        $skip                = ($currentPage - 1) * $announcementsOnPage;

        return $this->render('announcement/filter.html.twig', [
            'announcements'     => $announcements,
            'defaultParameters' => $defaultParameters,
            'count_page'        => $countPage,
            'currant_page'      => $currentPage,
            'params'            => $templateParams,
            'select'            => $select,
        ]);
    }

    /**
     * @Route("/remove/{id}", name="announcement_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Announcement $announcement, FileUploader $fileUploader): Response
    {
        if ($this->isCsrfTokenValid('delete' . $announcement->getId(), $request->request->get('_token'))) {
            $fileUploader->removePhotos($announcement->getPhotos());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($announcement);
            $entityManager->flush();
        }
        $userId = $request->get('user_id');
        return $this->redirectToRoute('profile', ["id" => $userId], Response::HTTP_SEE_OTHER);
    }
}
