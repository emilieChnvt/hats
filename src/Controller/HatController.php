<?php

namespace App\Controller;

use App\Entity\Hat;
use App\Form\HatType;
use App\Repository\HatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HatController extends AbstractController
{
    #[Route('/hats', name: 'hats')]
    public function index(HatRepository $hatRepository): Response
    {
        return $this->render('hat/index.html.twig', [
            'hats'=> $hatRepository->findAll(),
        ]);
    }

    #[Route('/hat/show/{id}', name: 'show_hat', priority: -1)]
    public function show(Hat $hat): Response
    {
        if(!$hat){
            return $this->redirectToRoute('hats');
        }
        return $this->render('hat/show.html.twig', [
            'hat' => $hat,
        ]);
    }

    #[Route('/hat/create', name: 'create_hat', methods: ['GET', 'POST'])]
    public function create( EntityManagerInterface $manager, Request $request): Response
    {
        $hat = new Hat();
        $hatForm = $this->createForm(HatType::class, $hat);
        $hatForm->handleRequest($request);
        if($hatForm->isSubmitted() && $hatForm->isValid()){
            $manager->persist($hat);
            $manager->flush();
            return $this->redirectToRoute('hats');
        }
        return $this->render('hat/create.html.twig', [
            'hatForm' => $hatForm->createView(),
        ]);
    }


}

