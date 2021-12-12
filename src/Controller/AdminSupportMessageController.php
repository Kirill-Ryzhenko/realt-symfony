<?php

namespace App\Controller;

use App\Entity\SupportMessage;
use App\Entity\User;
use App\Form\AnswerSupportMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/admin/support/message", name="admin_support_message")
 */
class AdminSupportMessageController extends AbstractController
{
    /**
     * @Route("/", name="_all")
     */
    public function outAll(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $messages      = $entityManager->getRepository(SupportMessage::class)->findAll();
        return $this->render('support_message/all_message.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/{id}", name="_answer")
     */
    public function answer(int $id, Request $request, MailerInterface $mailer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message      = $entityManager->getRepository(SupportMessage::class)->find($id);

        $form = $this->createForm(AnswerSupportMessageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $entityManager->getRepository(User::class)->find($message->getId());
            $email = $user->getEmail();
            $task = $form->getData();
//            var_dump($task);
//            var_dump($user->getEmail());
            mail($email, 'Ответ техподдержки', $task['answer'], 'From: quasimodo_it@mail.ru');
echo "<p>{$task['answer']}</p>";
            $email = (new Email())
                ->from('quasimodo_it@mail.ru    ')
                ->to($user->getEmail())
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>${task[answer]}</p>');
//
            $mailer->send($email);
die();
            $entityManager->remove($message);
            $entityManager->flush();
            return $this->redirectToRoute('admin_support_message_all');
        }

        return $this->render('support_message/answer.html.twig', [
            'form' => $form->createView(),
//            'errors' => $errors,
            'message' => $message,
        ]);
    }
}
