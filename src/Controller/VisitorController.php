<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\VisitorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitorController extends AbstractController
{
    /**
     * @Route("/visitornew", name="visitor_new")
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $profile = new Profile();
        $profile->setUser($user);
        $form = $this->createForm(VisitorType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profile = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('profile/visitornew.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/visitor", name="visitor")
     */
    public function visitor(Request $request): Response
    {
        $user = $this->getUser();
        return $this->render('visitor/visitor.html.twig');
    }

}
