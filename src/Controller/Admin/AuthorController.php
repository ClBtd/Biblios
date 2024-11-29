<?php

namespace App\Controller\Admin;

use App\Entity\Authors;
use App\Form\AuthorType;
use App\Repository\AuthorsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED')]
#[Route('/admin/author')]
class AuthorController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    #[Route('', name: 'admin_author')]
    public function index(AuthorsRepository $repository): Response
    {
        $authors = $repository->findAll();

        return $this->render('admin/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/new', name: 'admin_author_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'admin_author_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Authors $author, Request $request): Response
    {
        $author ??= new Authors();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($author);
            $this->em->flush();
            return $this->redirectToRoute('admin_author_show', ['id' => $author->getId()]);;
        }

        return $this->render('admin/author/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'admin_author_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Authors $author): Response
    {
        return $this->render('admin/author/show.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/{id}/remove', name: 'admin_author_remove', requirements: ['id' => '\d+'])]
    public function remove(Authors $author): Response
    {
        $this->em->remove($author);
        $this->em->flush();

        return $this->redirectToRoute('admin_author');
    }
}
