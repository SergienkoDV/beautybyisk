<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Day;
use App\Entity\Message;
use App\Entity\Time;
use App\Entity\User;
use App\Repository\MessageRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MasterController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user")
     */
    public function user($id)
    {
        $user =  $this->getDoctrine()->getRepository(User::class)->find($id);
        dump($user);
        $author = $this->getUser()->getId();
        $message = $this->getDoctrine()->getRepository(Message::class)->findBy(['poluch' => $id, 'author' => $author]);
        $messages = $this->getDoctrine()->getRepository(Message::class)->findBy(['poluch' => $author, 'author' => $id]);
        $mes = array_merge($message, $messages);
        foreach ($mes as $m){
        $date[] = $m->getDate();
        }
        if(count($mes)>1){
            array_multisort($date,SORT_DESC, $mes);
        }
        //dump(count($mes));
        return $this->render('user.html.twig', [
            'master' => $user,
            'message' => $mes,
        ]);
    }
    /**
     * @Route("/master/{id}", name="master")
     */
    public function index($id)
    {
        $master =  $this->getDoctrine()->getRepository(User::class)->find($id);
        $view = $master->getView();
        $view = ++$view;
        $views = $master->setView($view);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($views);
        $entityManager->flush();
        $price = $master->getPrices();
        $days = $master->getDays();
        $img = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('master/index.html.twig', [
            'master' => $master,
            'price' => $price,
            'days' => $days,
            'view' => $view,
        ]);
    }
    /**
     * @Route("/dateweek", name="dateweek")
     */
    public function date()
    {
        //$day = new DateTime(date("Ymd")); //получаем дату в формате год месяц день
        $date = new DateTime();
        $date = $date->add(new DateInterval('PT6H')); // +6 часов часовой пояс
        $day = &$date;
        $day = $day->add(new DateInterval('P7D'));// +неделя

        $week = new DateTime();
        $week->add(new DateInterval('P7DT6H'));
        $date = $date->setTime(8, 0);
        //$date = $date->add(new DateInterval('P7D'));
        //$date = $date->setTime(0, 0);
        //$date = $date->add(new DateInterval('PT6H'));
        //$date830 = $date->add(new DateInterval('P8h30i'));

        dump($date);
        dump($date);
        dump($week);
        return $this->render('profile/profile.html.twig');
    }

    /**
     * @Route("/addweek", name="week")
     */
    public function newDay()
    {
        $week = new DateTime();
        $week->add(new DateInterval('P7DT6H'))->setTime(0, 0);
        $day =new Day();
        $day->setDay($week);
        $day->setUser($this->getUser());
        //dump($day);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($day);
        $entityManager->flush();
        return $this->render('profile/profile.html.twig');
    }



    /**
     * @Route("/fortime/{id}", name="fortime")
     */
    public function broneTime($id)  //бронирование времени
    {
        if(empty($this->getUser())){
            return $this->redirectToRoute('app_login');
        }
        $time = $this->getDoctrine()->getRepository(Time::class)->find($id);
        $user = $this->getUser();
        $userId = $time->getDay()->getUser()->getId();
        $day = $time->getDay()->getTimes();
        foreach($day as $brone) {   // ищет в бд бронировал ли это пользователь еще за этот день
            $brone = $brone->getBrone();
            if($brone === $user) {   //если да то выкидываем его
                return $this->render('master/warning.html.twig');
            }
        }
            $time->setStatus(2);
            $time->setBrone($user);
            dump($time);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($time);
            $entityManager->flush();
            $this->redirectToRoute('master', ['id' => $userId]);


        return $this->redirectToRoute('master', ['id' => $userId]);

    }

}

