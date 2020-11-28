<?php

namespace App\Controller;

use App\Entity\Registro;
use App\Form\RegistroType;
use App\Repository\RegistroRepository;
use App\Repository\ValorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registro")
 */
class RegistroController extends AbstractController
{
    /**
     * @Route("/", name="registro_index", methods={"GET"})
     */
    public function index(RegistroRepository $registroRepository): Response
    {	
      $user_id = $this->getUser();
      if($user_id){
        return $this->render('registro/index.html.twig', [
            'registros' => $registroRepository->findAll(),
        ]);
      }else{
        return $this->redirectToRoute('app_login');
      }
        
    }

    /**
     * @Route("/new", name="registro_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
      $user_id = $this->getUser();
      if($user_id){
        $registro = new Registro();
        $form = $this->createForm(RegistroType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($registro);
            $entityManager->flush();

            return $this->redirectToRoute('registro_index');
        }

        return $this->render('registro/new.html.twig', [
            'registro' => $registro,
            'form' => $form->createView(),
        ]);
      }else{
        return $this->redirectToRoute('app_login');
      }
        
    }

    /**
     * @Route("/{id}", name="registro_show", methods={"GET"})
     */
    public function show(Registro $registro, ValorRepository $ValorRepository): Response
    {
      $user_id = $this->getUser();
      if($user_id){
        $respuestas = $registro->getRespuestas();
      	$respuestas_s = $registro->getRespuestaSimples();
        $respuestas_g = $registro->getRespuestaGrupos();
        return $this->render('registro/show.html.twig', [
            'registro' => $registro,
            'respuestas' => $respuestas,
          	'respuestas_s' =>$respuestas_s,
          	'respuestas_g' =>$respuestas_g
          	
        ]);
      }else{
        return $this->redirectToRoute('app_login');
      }
        
    }

    /**
     * @Route("/{id}/edit", name="registro_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Registro $registro): Response
    {
      $user_id = $this->getUser();
      if($user_id){
        $form = $this->createForm(RegistroType::class, $registro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('registro_index');
        }

        return $this->render('registro/edit.html.twig', [
            'registro' => $registro,
            'form' => $form->createView(),
        ]);
      }else{
        return $this->redirectToRoute('app_login');
      }
        
    }

    /**
     * @Route("/{id}", name="registro_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Registro $registro): Response
    {
      $user_id = $this->getUser();
      if($user_id){
        if ($this->isCsrfTokenValid('delete'.$registro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($registro);
            $entityManager->flush();
        }
		if($request->get('_route')=="encuesta_show"){
          return $this->redirectToRoute('encuesta_show');
        }else{
          return $this->redirectToRoute('registro_index');
        }
        
      }else{
        return $this->redirectToRoute('app_login');
      }
        
    }
 	
}
