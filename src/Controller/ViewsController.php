<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ViewsController extends AbstractController
{
    /**
     * @Route("/views", name="views")
     */
    public function addView($id)
    {
        $view = $this->getDoctrine()->getRepository(User::class);
        $view = $view->find($id);

        return $this->render('views/index.html.twig', [
            'controller_name' => 'ViewsController',
        ]);
    }
}
