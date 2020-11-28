<?php

namespace App\Controller;

use App\Entity\CategoriaEncuesta;
use App\Form\CategoriaEncuestaType;
use App\Repository\CategoriaEncuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categoria/encuesta")
 */
class CategoriaEncuestaController extends AbstractController
{
    /**
     * @Route("/", name="categoria_encuesta_index", methods={"GET", "POST"})
     */
    public function index(CategoriaEncuestaRepository $categoriaEncuestaRepository, Request $request): Response
    {	
      	$user_id = $this->getUser();
        $categoriaEncuestum = new CategoriaEncuesta();
        $form = $this->createForm(CategoriaEncuestaType::class, $categoriaEncuestum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
          	$categoriaEncuestum->setUser($user_id);
            $entityManager->persist($categoriaEncuestum);
            $entityManager->flush();

            return $this->redirectToRoute('categoria_encuesta_index');
        }
        return $this->render('categoria_encuesta/index.html.twig', [
            'categoria_encuestas' => $categoriaEncuestaRepository->findBy(['user' => $user_id]),
          	'categoria_encuestum' => $categoriaEncuestum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="categoria_encuesta_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
      	$user_id = $this->getUser();
        $categoriaEncuestum = new CategoriaEncuesta();
        $form = $this->createForm(CategoriaEncuestaType::class, $categoriaEncuestum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
          	$categoriaEncuestum->setUser($user_id);
            $entityManager->persist($categoriaEncuestum);
            $entityManager->flush();

            return $this->redirectToRoute('categoria_encuesta_index');
        }

        return $this->render('categoria_encuesta/new.html.twig', [
            'categoria_encuestum' => $categoriaEncuestum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoria_encuesta_show", methods={"GET"})
     */
    public function show(CategoriaEncuesta $categoriaEncuestum): Response
    {
        return $this->render('categoria_encuesta/show.html.twig', [
            'categoria_encuestum' => $categoriaEncuestum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoria_encuesta_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoriaEncuesta $categoriaEncuestum): Response
    {
        $form = $this->createForm(CategoriaEncuestaType::class, $categoriaEncuestum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_encuesta_index');
        }

        return $this->render('categoria_encuesta/edit.html.twig', [
            'categoria_encuestum' => $categoriaEncuestum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoria_encuesta_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoriaEncuesta $categoriaEncuestum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriaEncuestum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoriaEncuestum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categoria_encuesta_index');
    }
}
