<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\Time;
use App\Entity\User;
use DateInterval;
use DatePeriod;
use DateTime;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddTimeController extends AbstractController
{
    /**
     * @Route("/fornextday/{id}", name="fornextday")
     */
    public function fornextDay($id) //добавляет новый 7-ой день
    {
        $day = new DateTime();
        $day->add(new DateInterval('P7DT6H'))->setTime(0, 0);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $newDay = new Day();
        $newDay->setUser($user);
        $newDay->setDay($day);
        $user->addDay($newDay);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($newDay);
        $entityManager->flush();
        return $this->redirectToRoute('forhour', ['id'=>$id]);
    }
    /**
     * @Route("/forday/{id}", name="forday")
     */
    public function forDay($id) //добавляет 7 дней в график
    {
        $begin = new DateTime();
        $begin->add(new DateInterval('PT6H'))->setTime(0, 0);
        $end = new DateTime();
        $end->add(new DateInterval('P7DT6H'))->setTime(0, 0);
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        //$id =1;
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        //$user = $users->getDays();
        foreach ($daterange as $date) {
            $newDay = new Day();
            $newDay->setUser($user);
            $newDay->setDay($date);
            $user->addDay($newDay);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newDay);
            $entityManager->flush();
        }
        $id = $this->getUser()->getId();
        return $this->redirectToRoute('forhour', ['id'=>$id]);
    }


    /**
     * @Route("/forhour/{id}", name="forhour")
     */
    public function forTime($id) //добавляет на каждый день по 12 часов
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $days = $user->getDays();
        foreach($days as $day){
            $date = $day->getDay();
            $begin = clone $date;
            $end = clone $date;
            $begin->add(new DateInterval('PT8H'));
            $end ->add(new DateInterval('PT20H'));
            $interval = new DateInterval('PT1H');
            $daterange = new DatePeriod($begin, $interval, $end);
            foreach ($daterange as $time) {
                $newTime = new Time();
                $newTime->setDay($day);
                $newTime->setStatus(0);
                $newTime->setTime($time);
                $day->addTime($newTime);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newTime);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('profile_index');
    }
    /**
     * @Route("/validweek", name="validweek")
     */
    public function deleteDay() //удаляет старые обьекты
    {
        $days = $this->getDoctrine()->getRepository(Day::class)->findAll();
        $currentday = new DateTime();
        $currentday->add(new DateInterval('PT6H'))->setTime(0, 0);
        foreach($days as $day){
            if($day->getDay() < $currentday) {
                dump($day);
                $time = $day->getTimes();
                foreach ($time as $timedelete){
                    //dump($timedelete);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($timedelete);
                    $entityManager->flush();
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($day);
                $entityManager->flush();
            }
        }
        //dump($days);
        return $this->render('profile/profile.html.twig');
    }

}
