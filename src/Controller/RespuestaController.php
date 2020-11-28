<?php

namespace App\Controller;

use App\Entity\Respuesta;
use App\Form\RespuestaType;
use App\Repository\RespuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/respuesta")
 */
class RespuestaController extends AbstractController
{
    /**
     * @Route("/", name="respuesta_index", methods={"GET"})
     */
    public function index(RespuestaRepository $respuestaRepository): Response
    {
        return $this->render('respuesta/index.html.twig', [
            'respuestas' => $respuestaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="respuesta_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $respuestum = new Respuesta();
        $form = $this->createForm(RespuestaType::class, $respuestum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($respuestum);
            $entityManager->flush();

            return $this->redirectToRoute('respuesta_index');
        }

        return $this->render('respuesta/new.html.twig', [
            'respuestum' => $respuestum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="respuesta_show", methods={"GET"})
     */
    public function show(Respuesta $respuestum): Response
    {
        return $this->render('respuesta/show.html.twig', [
            'respuestum' => $respuestum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="respuesta_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Respuesta $respuestum): Response
    {
        $form = $this->createForm(RespuestaType::class, $respuestum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('respuesta_index');
        }

        return $this->render('respuesta/edit.html.twig', [
            'respuestum' => $respuestum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="respuesta_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Respuesta $respuestum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$respuestum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($respuestum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('respuesta_index');
    }
}
