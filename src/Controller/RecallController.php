<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Recall;
use App\Entity\User;
use App\Form\RecaallType;
use DateInterval;
use Symfony\Component\DependencyInjection\Tests\Compiler\D;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RecallController extends AbstractController
{
    /**
     * @Route("/recall", name="recall")
     */
    public function index(Request $request)
    {
        $recalls = $this->getDoctrine()->getRepository(Recall::class)->findAll();
        $form = $this->createForm(RecaallType::class);
        $form->handleRequest($request);
        if ($request->isXMLHttpRequest()) {
           $text = $request->request->get('text');
            $recall = new Recall();
            $recall->setUser($this->getUser());
            $recall->setDate(new  \DateTime());
            $recall->setMaster($this->getDoctrine()->getRepository(User::class)->find(3));
            $recall->setText($text);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recall);
            $entityManager->flush();
            return new Response($this->redirectToRoute('home'), 200);
        }
       //$text = XMLHttpRequest();
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('base.html.twig', [
                'form' => $form->createView()
            ]);
        }
        return $this->render('recall/index.html.twig', [
            'form' => $form->createView(),
            'recalls' => $recalls
        ]);
    }

    /**
     * @Route("/test/{id}", name="test")
     */
    public function test(Request $request, $id)
    {
        $recall = new Recall();
        $master = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('text', TextAreaType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control form_recalls',
                    'rows' => 2
                ]
            ] )
            ->getForm();
        $recal = $master->getRecalls();
        $form->handleRequest($request);
        if ($request->isXMLHttpRequest()) {
            $text = $request->request->get('text');
            $date = new \DateTime();
            $date->add(new DateInterval('PT6H'));
            $recall->setDate($date);
            $user = $this->getUser();
            $recall->setUser($user);
            $recall->setMaster($master);
            $recall->setText($text);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recall);
            $entityManager->flush();
            return $this->render('recall/test.html.twig',[
                'form' => $form->createView(),
                'id' => $id,
                'user' => $recal,
            ]);
        }
        return $this->render('recall/test.html.twig',[
            'form' => $form->createView(),
            'id' => $id,
            'user' => $recal
            ]);
    }

}
