<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use DateInterval;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("profile/message", name="message")
     */
    public function ShowMessage()
    {
        $messages = $this->getUser()->getMessage();
        return $this->render('profile/message.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("profile/message/send", name="sendmessage")
     */
    public function ShowSendMessage()
    {
        $messages = $this->getUser()->getMessages();
        return $this->render('profile/sendmesage.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/message/{id}", name="newmessage")
     */
    public function NewMessage(Request $request, $id)
    {
        $form = $this->createFormBuilder(null)
        ->add('text', TextType::class, ['label' => ' ',
            'required' => true,
            'attr' => [
                'label' => false,
                'class' => 'form-control message_form_text',
                'placeholder' => 'Текст сообщения'
            ]
        ] )
        ->getForm();
        $form->handleRequest($request);
        if ($request->isXMLHttpRequest()) {
            $text = $request->request->get('text');
            $message = new Message();
            $poluch = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id); //находим получателя
            $user = $this->getUser(); // свой профиль
            $message->setAuthor($user); //делаем себя автором письма
            $message->setText($text); //устанавливаем текст в сообщение
            $message->setPoluch($poluch); // добавляем получателя письма
            $date = new \DateTime();
            $date = $date->add(new DateInterval('PT5H'));
            $message->setDate($date); //добавляем время
            $poluch->addMessage($message); //добавляем письмо получателю
            $user->addMessages($message);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('message');
        }
        return $this->render('message.html.twig', [
            'Form' => $form->createView(),
            'master_id' => $id
        ]);
    }
    /**
     * @Route("deletemessage/{id}", name="deletemessage")
     */
    public function deleteMessage(Request $request, $id)
    {
        if ($request->isXMLHttpRequest()) {
            $message = $request->request->get('id');
            $message = $this->getDoctrine()->getRepository(Message::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
            return $this->redirectToRoute('message');
        }

    }
    /**
     * @Route("deletemessagesend/{id}", name="deletemessage")
     */
    public function deleteSendMessage($id)
    {
        $message = $this->getDoctrine()->getRepository(Message::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($message);
        $entityManager->flush();
        return $this->redirectToRoute('sendmessage');
    }

}

