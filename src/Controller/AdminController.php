<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin", name="admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_view")
     */
    public function index()
    {
        return $this->render('admin.html.twig');
    }
    /**
     * @Route("/adminrole", name="adminrole")
     */
    public function adminRole()
    {
        $user = $this->getUser();
        $role = $user->getRoles();
        $role[] = 'ROLE_ADMIN';
        $user->setRoles($role);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->render('master/index.html.twig');
    }
    /**
     * @Route("/recall", name="admin_recall")
     */
    public function recall()
    {
        return $this->render('admin.html.twig');
    }
}
