<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\Time;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BroneController extends AbstractController
{
    /**
     * @Route("profile/brone", name="brone")
     */
    public function EditBrone()
    {
        if(empty($this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $days = $user->getDays();

        return $this->render('profile/editbrone.html.twig', [
            'days' => $days,
        ]);
    }
    /**
     * @Route("foraddtime/{id}", name="foraddtime")
     */
    public function ForaddTime($id)
    {
        if(empty($this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        $time = $this->getDoctrine()->getRepository(Time::class)->find($id);
        $user = $this->getUser();
        $author = $time->getDay()->getUser();
        if($user = $author){
         $time->setStatus(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($time);
            $entityManager->flush();
            return $this->redirectToRoute('brone');
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("outputday/{id}", name="outputday")
     */
    public function OutPutDay($id)
    {
        $days = $this->getDoctrine()->getRepository(Day::class)->find($id);
        $times = $days->getTimes();
        foreach($times as $time){
            $status = $time->setStatus(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($status);
            $entityManager->flush();
        }
        return $this->redirectToRoute('brone');
    }
    /**
     * @Route("retime/{id}", name="retime")
     */
    public function reTime($id)
    {
        if(empty($this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        $time = $this->getDoctrine()->getRepository(Time::class)->find($id);
        $user = $this->getUser();
        $author = $time->getDay()->getUser();
        if($user = $author){
            $time->setStatus(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($time);
            $entityManager->flush();
            return $this->redirectToRoute('brone');
        }
        return $this->redirectToRoute('home');
    }
}
