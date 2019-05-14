<?php

namespace App\Controller;

use App\Entity\Time;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatementController extends AbstractController
{
    /**
     * @Route("profile/statement", name="statement")
     */
    public function index()
    {
        $brone = $this->getUser()->getTimes();
        $master = $this->getUser()->getMaster();
        //dump($brone);
        if($master == 1){
            $user = $this->getUser();
            $days = $user->getDays();
            return $this->render('profile/statementmaster.html.twig', [
                'days' => $days
            ]);
        }

        return $this->render('profile/statement.html.twig', [
            'brone' => $brone
        ]);
    }
    /**
     * @Route("/confirm/acept/{id}", name="statementacept")
     */
    public function confirm($id)
    {
        $time =$this->getDoctrine()->getRepository(Time::class)->find($id);
        $time->setStatus(1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($time);
        $entityManager->flush();
        return $this->redirectToRoute('statement');
    }

    /**
     * @Route("/confirm/ignore/{id}", name="statementignore")
     */
    public function ignore($id)
    {
        $time =$this->getDoctrine()->getRepository(Time::class)->find($id);
        $time->setStatus(0);
        $time->setBrone(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($time);
        $entityManager->flush();
        return $this->redirectToRoute('statement');
    }
}
