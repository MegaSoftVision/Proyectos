<?php

namespace App\Controller;

use App\Entity\Valor;
use App\Entity\CategoriaValor;
use App\Form\ValorType;
use App\Repository\ValorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/valor")
 */
class ValorController extends AbstractController
{
    /**
     * @Route("/", name="valor_index", methods={"GET"})
     */
    public function index(ValorRepository $valorRepository): Response
    {
        $user_id = $this->getUser();
        if($user_id){
          return $this->render('valor/index.html.twig', [
              'valors' => $valorRepository->findAll(),
          ]);
        }else{
          return $this->redirectToRoute('app_login');
        }
        
    }

    /*--------------------START Valor AJAX-------------------*/

    /**
    * @Route("/load", name="load_valores", options={"expose"=true})
    */
    public function loadvalores(Request $request) {
       if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
        $user_id = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        
        $valores = $user_id->getValors();
        $categorias = $user_id->getCategoriaValors();
        $valores_p = array();
        $categorias_p = array();
        $idx = 0;
        foreach ($valores as $valor){
          if ($valor->getCategoria()) {
            $categoria_id = $valor->getCategoria()->getId();
            $categoria_d = $valor->getCategoria()->getDescripcion();
          }else{
            $categoria_d = 'Sin Categoria';
            $categoria_id = null;
          }
          $temp = array(
            'id_v' => $valor->getId(),
            'descripcion' => $valor->getDescripcion(),
            'color' => $valor->getColor(),
            'categoria_id' => $categoria_id,
            'categoria_d' => $categoria_d,
            'date_create' => $valor->getDateCreate()->format('d-m-Y'),
          );
          $valores_p[$idx++] = $temp;
        }
        $idx2 = 0;
        foreach ($categorias as $categoria ) {
          $temp = array(
            'id_c' => $categoria->getId(),
            'descripcion' => $categoria->getDescripcion(),
          );
          $categorias_p[$idx2++] = $temp;
        }
        $temp = array(
          'valores' => $valores_p,
          'categorias' => $categorias_p,
        );
  
        $jsonData = $temp;
        return new JsonResponse($jsonData);
  
      }else{
        throw new Exception('Estas tratando de hackearme?');
      }
    }
    
    /**
    * @Route("/add_v", options={"expose"=true}, name="add_valor")
    */
    public function addvalor(Request $request){
      if($request->isXmlHttpRequest()){
        $user_id = $this->getUser();
        $valor = new Valor();
  
        $entityManager = $this->getDoctrine()->getManager();
        $valor->setUser($user_id);
        $entityManager->persist($valor);
        
  
        $entityManager->flush();
  
        return new JsonResponse('Registrado Exitosamente');
      }
      else{
        throw new Exception('Estas tratando de hackearme?');
      }
  
    }
    
    /**
    * @Route("/save_v", options={"expose"=true}, name="save_valor")
    */
    public function savevalor(Request $request){
      if($request->isXmlHttpRequest()){
  
        $id = $request->request->get('id_v');
        $descripcion = $request->request->get('descripcion');
        $color = $request->request->get('color');
        $id_c = $request->request->get('id_c');
        $entityManager = $this->getDoctrine()->getManager();
        $categoria = $entityManager->getRepository(CategoriaValor::class)->find($id_c);
        $valor = $entityManager->getRepository(Valor::class)->find($id);
        $valor->setDescripcion($descripcion);
        $valor->setColor($color);
        $valor->setCategoria($categoria);
        $entityManager->flush();
  
        return new JsonResponse("Guardado Exitosamente");
      }
      else{
        throw new Exception('Estas tratando de hackearme?');
      }
  
    }
    
    /**
    * @Route("/duply_v", options={"expose"=true}, name="duply_valor")
    */
    public function duplyvalor(Request $request){
      if($request->isXmlHttpRequest()){
  
        $id = $request->request->get('id_v');
        $valor = new Valor();
        $entityManager = $this->getDoctrine()->getManager();
        $valor_d = $entityManager->getRepository(Valor::class)->find($id);
        $descripcion = $valor_d->getDescripcion();
        $color = $valor_d->getColor();
        $categoria = $valor_d->getCategoria();
        $user = $valor_d->getUser();
        
        $valor->setDescripcion($descripcion);
        $valor->setColor($color);
        $valor->setCategoria($categoria);
        $valor->setUser($user);
        $entityManager->persist($valor);
        $entityManager->flush();
  
        return new JsonResponse('Duplicado Exitosamente');
      }
      else{
        throw new Exception('Estas tratando de hackearme?');
      }
  
    }
  
    /**
    * @Route("/delete_v", options={"expose"=true}, name="delete_valor")
    */
    public function deletevalor(Request $request){
      if($request->isXMLHttpRequest()){
        $id = $request->request->get('id_v');
  
        $entityManager = $this->getDoctrine()->getManager();
        $valor = $entityManager->getRepository(Valor::class)->find($id);
        $entity = $valor->getDescripcion();
  
  
        try {
          $status = true;
          $entityManager->remove($valor);
          $entityManager->flush();
          return new JsonResponse(  $content = array(
              "action" => "Eliminado",
              "entidad" => $entity,
              "status" => $status,
            ));
  
        } catch (\Exception $e) {
          $status = false;
          return new JsonResponse(  $content = array(
              "action" => "Eliminado",
              "entidad" => $entity,
              "status" => $status,
            ));
        }
  
      } else{
        throw new Exception('Estas tratando de hackearme?');
      }
  
    }
    /*--------------------END Valor AJAX-------------------*/
}
