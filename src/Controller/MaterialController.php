<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MaterialController extends AbstractController
{
    #[Route('/material/create', name: 'create_material')]
    public function create(Material $material, EntityManagerInterface $manager, Request $request): Response
    {
        $material = new Material();
        $materialForm = $this->createForm(MaterialType::class, $material);
        $materialForm->handleRequest($request);
        if ($materialForm->isSubmitted() && $materialForm->isValid()) {
            $manager->persist($material);
            $manager->flush();
            return $this->redirectToRoute('hats');
        }
        return $this->render('material/index.html.twig', [
            'materialForm' => $materialForm->createView(),
        ]);
    }
}
