<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookController extends AbstractController
{


    #[Route('/fetch', name:'fetch')]
    public function fetch(BookRepository $repo): Response
    {
        $result = $repo ->findAll();
        return $this -> render('/book/fetch.html.twig',[
            'response' => $result
        ]);
    }

    #[Route('/addB', name:'addB')]
    public function add(request $request, ManagerRegistry $mr): Response
    {
        $book = new Book();
        $form = $this-> CreateForm(BookType::class, $book);
        $form -> add('Save', SubmitType::class);
        $form -> handleRequest($request);
        if($form-> isSubmitted()){
            $em=$mr->getManager();
            $em->persist($book);
            $em->flush();
            
            return $this-> redirectToRoute('fetch');
        }
        return $this -> render('book/form.html.twig',[
            'f'=>$form->CreateView()
        ]);
        
    }

    #[Route('/editb/{ref}', name:'edit')]
    public function edit(request $request, ManagerRegistry $mr, BookRepository $repo, $ref): Response
    {
        $b = $repo ->find($ref);
        $form = $this-> CreateForm(BookType::class, $b);
        $form -> add('Save', SubmitType::class);
        $form -> handleRequest($request);
        if($form-> isSubmitted()){
            $em=$mr->getManager();
            $em->persist($b);
            $em->flush();
            
            return $this-> redirectToRoute('fetch');
        }
        return $this -> render('book/form.html.twig',[
            'f'=>$form->CreateView()
        ]);
        
    }

#[Route('/delete{ref}', name:'delete')]
public function delete($ref, ManagerRegistry $mr, BookRepository $repo): Response
{
    $bk=$repo->find($ref);
    $em=$mr->getManager();
    $em->remove($bk);
    $em->flush();

    return $this -> redirectToRoute('fetch');
}

#[Route('/show/{ref}', name: 'show')]
public function show( $ref, BookRepository $repo): Response
{
   
    $book = $repo->find($ref);
    return $this->render('book/show.html.twig', [
        'response' => $book,
    ]);
}

}
