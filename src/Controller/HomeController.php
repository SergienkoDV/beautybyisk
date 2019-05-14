<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Profile;
use App\Entity\Section;
use App\Entity\User;
use App\Repository\ProfileRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function Home(Request $request)
    {
        // Retrieve the entity manager of Doctrine
        $em = $this->getDoctrine()->getManager();

        // Get some repository of data, in our case we have an Appointments entity
        $appointmentsRepository = $em->getRepository(Profile::class);

        // Find all the data on the Appointments table, filter your query as you need
        $allAppointmentsQuery = $appointmentsRepository->createQueryBuilder('p')
            ->where('p.id != :status')
            ->andWhere('p.category > 0')
            ->setParameter('status', 'canceled')
            ->getQuery();

        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator  = $this->get('knp_paginator');

        // Paginate the results of the query
        $pagination = $paginator->paginate(
        // Doctrine Query, not results
            $allAppointmentsQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
//dump($pagination);
        // Render the twig view
        return $this->render('home/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/worksheets/{id}", name="worksheets")
     */
    public function workSheets($id)
    {
        $profil = $this->getDoctrine()->getRepository(Section::class)->find($id);
        $profiles= $profil->getWorksheets();
        dump($profiles);
        return $this->render('home/search.html.twig',
            ['profiles'=> $profiles]);
    }
    /**
     * @Route("/menu}", name="menu")
     */
    public function menu()
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $section = $this->getDoctrine()->getRepository(Section::class)->findAll();
        return $this->render('home/menu.html.twig',[
            'categories' => $category,
            'sections' => $section
        ]);
    }
    /**
     * @Route("/support}", name="support")
     */
    public function support()
    {

        return $this->render('home/support.html.twig');
    }
}

