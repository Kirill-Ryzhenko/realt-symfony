<?php

namespace App\Controller;

use App\Entity\SupportMessage;
use App\Entity\User;
use App\Form\SupportMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/support/message")
 */
class SupportMessageController extends AbstractController
{
    /**
     * @Route("/", name="support_message")
     */
    public function index(UserInterface $user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userId        = $user->getId();
        $messages      = $entityManager->getRepository(SupportMessage::class)->findBy(['id_user' => $userId]);

        return $this->render('support_message/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/new", name="support_message_new")
     */
    public function new(Request $request, UserInterface $user, ValidatorInterface $validator): Response
    {
        $message = new SupportMessage();

        $form = $this->createForm(SupportMessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userId        = $user->getId();
            $entityManager = $this->getDoctrine()->getManager();
            $userAuth      = $entityManager->getRepository(User::class)->find($userId);
            $message->setIdUser($userAuth);

            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('support_message');
        }

        $errors = $validator->validate($message);
        return $this->render('support_message/new_edit.html.twig', [
            'errors' => $errors,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="support_message_edit")
     */
    public function edit(int $id, Request $request, UserInterface $user, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message = $entityManager->getRepository(SupportMessage::class)->find($id);

        $form = $this->createForm(SupportMessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('support_message');
        }

        $errors = $validator->validate($message);
        return $this->render('support_message/new_edit.html.twig', [
            'errors' => $errors,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove/{id}", name="support_message_remove")
     */
    public function remove(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message = $entityManager->getRepository(SupportMessage::class)->find($id);
        $entityManager->remove($message);
        $entityManager->flush();
        return $this->redirectToRoute('support_message');
    }
}
