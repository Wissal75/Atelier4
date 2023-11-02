<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Form\AuthorType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/fetch', name: 'fetch')]
    public function fetch(AuthorRepository $repo): Response
    {
        $result = $repo ->findAll();
        return $this -> render('/author/fetch.html.twig',[
            'response' => $result
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(request $req, ManagerRegistry $mr): Response
    {
        $a = new Author();
        $form = $this -> CreateForm(AuthorType::class,$a);
        $form->add('Ajouter', SubmitType::class);
        $form -> handleRequest($req);
        if ($form->isSubmitted())
        {
            $em=$mr->getManager(); 
            $em->persist($a); 
            $em->flush(); 

            return $this-> redirectToRoute('fetch');
        }
        return $this -> render('/author/form.html.twig',[
            'f'=>$form-> CreateView()
        ]);

    }
    #[Route ('/edit/{id}', name:'edit')]
    public function edit(request $req, ManagerRegistry $mr, $id, AuthorRepository $repo): Response
    {
        $author = $repo -> find($id);
        $form = $this -> CreateForm(AuthorType::class,$author);
        $form->add('Ajouter', SubmitType::class);
        $form -> handleRequest($req);
        if ($form->isSubmitted())
        {
            $em=$mr->getManager(); 
            $em->persist($author); 
            $em->flush(); 

            return $this-> redirectToRoute('fetch');
        }
        return $this -> render('/author/form.html.twig',[
            'f'=>$form-> CreateView()
        ]);
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function remove(AuthorRepository $repo , $id, ManagerRegistry $mr): Response
    {
        $au=$repo->find($id);
        $em=$mr->getManager();
        $em->remove($au);
        $em->flush(); 

        return $this->redirectToRoute('fetch');
    }
}

