<?php

namespace App\Controller\Admin;

use App\Entity\Editors;
use App\Form\EditorType;
use App\Repository\EditorsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/editor')]
class EditorController extends AbstractController
{
    #[Route('', name: 'admin_editor')]
    public function index(EditorsRepository $repository): Response
    {
        $editors = $repository->findAll();

        return $this->render('admin/editor/index.html.twig', [
            'editors' => $editors,
        ]);
    }

    #[Route('/new', name: 'admin_editor_new',  methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'admin_editor_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, ?Editors $editor): Response
    {
        $editor ??= new Editors();
        $form = $this->createForm(EditorType::class, $editor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($editor);
            $em->flush();
            return $this->redirectToRoute('admin_editor_show', ['id' => $editor->getId()]);
        }

        return $this->render('admin/editor/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_editor_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Editors $editor): Response
    {
        return $this->render('admin/editor/show.html.twig', [
            'editor' => $editor,
        ]);
    }

    #[Route('/{id}/remove', name: 'admin_editor_remove', requirements: ['id' => '\d+'])]
    public function remove(Editors $editor,EntityManagerInterface $em): Response
    {
        $em->remove($editor);
        $em->flush();

        return $this->redirectToRoute('admin_editor');
    }    
}
