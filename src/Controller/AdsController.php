<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\User;
use App\Form\AdsType;
use App\Repository\AdsRepository;
use DateInterval;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdsController extends Controller
{
    /**
     * @Route("/ads", name="ads")
     */
    public function index()
    {
        $ads = $this->getDoctrine()->getRepository(Ads::class)->findByExampleField('all');
        dump($ads);
        return $this->render('ads/index.html.twig', [
            'ads' => $ads
        ]);
    }
    /**
     * @Route("/ads/{id}", name="ads_show")
     */
    public function show($id)
    {
        $ads = $this->getDoctrine()->getRepository(Ads::class)->find($id);
        dump($ads);
        return $this->render('ads/show.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * @Route("/addads", name="ads_add")
     */
    public function NewAds(Request $request)
    {
        $form = $this->createForm(AdsType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $ads = new Ads();
            $ads = $form->getData();
            $ads->setAuthor($this->getUser());
            $date = new \DateTime();
            $date = $date->add(new DateInterval('PT5H'));
            $ads->setDate($date);
            $file = $request->files->get('ads')['img'];
            /* @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            $ads->setImg($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ads);
            $entityManager->flush();
            return $this->redirectToRoute('ads');
        }
        return $this->render('ads/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
