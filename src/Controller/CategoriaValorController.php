<?php

namespace App\Controller;

use App\Entity\CategoriaValor;
use App\Form\CategoriaValorType;
use App\Repository\CategoriaValorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categoria/valor")
 */
class CategoriaValorController extends AbstractController
{
    /**
     * @Route("/", name="categoria_valor_index", methods={"GET", "POST"})
     */
    public function index(CategoriaValorRepository $categoriaValorRepository, Request $request): Response
    {
        $user_id = $this->getUser();
        $categoriaValor = new CategoriaValor();
        $form = $this->createForm(CategoriaValorType::class, $categoriaValor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
          	$categoriaValor->setUser($user_id);
            $entityManager->persist($categoriaValor);
            $entityManager->flush();
			
            return $this->redirectToRoute('categoria_valor_index');
        }
        return $this->render('categoria_valor/index.html.twig', [
            'categoria_valors' => $categoriaValorRepository->findBy(['user' => $user_id]),
            'categoria_valor' => $categoriaValor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="categoria_valor_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
      	$user_id = $this->getUser();
        $categoriaValor = new CategoriaValor();
        $form = $this->createForm(CategoriaValorType::class, $categoriaValor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
          	$categoriaValor->setUser($user_id);
            $entityManager->persist($categoriaValor);
            $entityManager->flush();
			
            return $this->redirectToRoute('categoria_valor_index');
        }

        return $this->render('categoria_valor/new.html.twig', [
            'categoria_valor' => $categoriaValor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoria_valor_show", methods={"GET"})
     */
    public function show(CategoriaValor $categoriaValor): Response
    {
        return $this->render('categoria_valor/show.html.twig', [
            'categoria_valor' => $categoriaValor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoria_valor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoriaValor $categoriaValor): Response
    {
        $form = $this->createForm(CategoriaValorType::class, $categoriaValor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_valor_index');
        }

        return $this->render('categoria_valor/edit.html.twig', [
            'categoria_valor' => $categoriaValor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoria_valor_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoriaValor $categoriaValor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriaValor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoriaValor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categoria_valor_index');
    }
}
