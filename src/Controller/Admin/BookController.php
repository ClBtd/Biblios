<?php

namespace App\Controller\Admin;

use App\Entity\Books;
use App\Form\BookType;
use App\Repository\BooksRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'admin_book')]
    public function index(BooksRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render('admin/book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/new', name: 'admin_book_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'admin_book_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Books $book, Request $request, EntityManagerInterface $em): Response
    {
        $book ??= new Books();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('admin_book_show', ['id' => $book->getId()]);
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Books $book): Response
    {
        return $this->render('admin/book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/remove', name: 'admin_book_remove', requirements: ['id' => '\d+'])]
    public function remove(Books $book,EntityManagerInterface $em): Response
    {
        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('admin_book');
    }
    
}
