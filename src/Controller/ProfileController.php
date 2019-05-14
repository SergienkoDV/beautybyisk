<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Message;
use App\Entity\Profile;
use App\Entity\Section;
use App\Entity\User;
use App\Entity\Worksheets;
use App\Form\ProfileType;
use App\Form\VisitorType;
use App\Repository\ProfileRepository;
use DateInterval;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


/**
 * @Route("/profiledit")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="profile_index", methods={"GET"})
     */
    public function index(ProfileRepository $profileRepository): Response
    {
        $profile = $this->getUser()->getProfile();
        if(empty($profile)){
          return $this->redirectToRoute('profile_new') ;
        }
        return $this->render('profile/index.html.twig', [
            'profile' => $profile,
        ]);
    }

    /**
     * @Route("/new", name="profile_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $profile = new Profile();
        $profile->setUser($user);
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $profile = $form->getData();
                /* @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $request->files->get('profile')['img'];
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('img_directory'),
                    $fileName
                );
                $profile->setImg($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();
            return $this->redirectToRoute('profile_section');
        }

        return $this->render('profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/section", name="profile_section", methods={"GET","POST"})
     */
    public function section(Request $request): Response
    {
        $profile = $this->getUser()->getProfile()->getCategory()->getSections(); //все возможные секции
        $form = $this->createFormBuilder()
            ->add('category', EntityType::class,  [
                'class' => Section::class,
                'choices' => $profile,
                'label' => 'Какие виды работ вы умеете выполнять?',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-check'],
                'choice_label' => 'name',
            ])
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $check = $form->getData();
            $works = $this->getUser()->getProfile()->getWorksheets();
            foreach ($works as $wor){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($wor);
                $entityManager->flush();
            }
            foreach ($check as $sect ) {
                foreach ($sect as $sec){

                    $work = new Worksheets();
                    $work->setMaster($this->getUser()->getProfile());
                    $work->setSection($sec);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($work);
                    $entityManager->flush();
                    //dump($sec);
            }
            }
            $id = $this->getUser()->getId();
            return $this->redirectToRoute('forday', ['id'=>$id]);
        }


        return $this->render('profile/section.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="profile_show", methods={"GET"})
     */
    public function show(Profile $profile): Response
    {
        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Profile $profile): Response
    {
        $master =$this->getUser()->getMaster();
        dump($master);
        if($master == 1){
        $form = $this->createForm(ProfileType::class, $profile);
        }
        else{
            $form = $this->createForm(VisitorType::class, $profile);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $file = $request->files->get('profile')['img'];
            if(!empty($file)){
            /* @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            $profile->setImg($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();
                return $this->redirectToRoute('profile_index', [
                    'id' => $profile->getId(),
                ]);
            }
            return $this->redirectToRoute('profile_index', [
                'id' => $profile->getId(),
            ]);
        }

        return $this->render('profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Profile $profile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_index');
    }

}
