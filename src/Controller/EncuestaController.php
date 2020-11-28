<?php

namespace App\Controller;

use App\Entity\Encuesta;
use App\Entity\Pregunta;
use App\Entity\Seleccion;
use App\Entity\Grupo;
use App\Entity\CategoriaEncuesta;
use App\Entity\Registro;
use App\Entity\Respuesta;
use App\Entity\RespuestaGrupo;
use App\Entity\RespuestaSimple;
use App\Entity\Valor;
use App\Form\EncuestaType;
use App\Repository\EncuestaRepository;
use App\Repository\CategoriaValorRepository;
use App\Repository\CategoriaEncuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
/**
* @Route("/encuesta")
*/
class EncuestaController extends AbstractController
{
  /**
  * @Route("/", name="encuesta_index", methods={"GET"})
  */
  public function index(Request $request, EncuestaRepository $encuestaRepository, CategoriaEncuestaRepository $CategoriaEncuestaRepository): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      $query_category = $request->query->get('category');
      $query_status = $request->query->get('query_status');
      return $this->render('encuesta/index.html.twig', [
        'encuestas' => $encuestaRepository->findBy(['user'=>$user_id]),
        'categorias' => $CategoriaEncuestaRepository->findBy(['user'=>$user_id]),
        'query_category' => $query_category,
        'query_status' => $query_status
      
      ]);
    }else{
      return $this->redirectToRoute('app_login');
    }

  }
  

  /**
  * @Route("/global", name="encuesta_analytics", methods={"GET"})
  */
  public function encuesta_analytics(EncuestaRepository $encuestaRepository, CategoriaValorRepository $CategoriaValorRepository, CategoriaEncuestaRepository $CategoriaEncuestaRepository): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      return $this->render('encuesta/global.html.twig', [
        'encuestas' => $encuestaRepository->EncuestaAnalytics($user_id),
        'categorias_v' => $CategoriaValorRepository->findBy(['user'=>$user_id]),
        'categorias_e' => $CategoriaEncuestaRepository->findBy(['user'=>$user_id]),
      
      ]);
    }else{
      return $this->redirectToRoute('app_login');
    }

  }

  /**
  * @Route("/enviado", name="encuesta_success", methods={"GET"}, options={"expose"=true})
  */
  public function success(EncuestaRepository $encuestaRepository): Response
  {

      return $this->render('encuesta/success.html.twig');

  }

  /**
  * @Route("/new", name="encuesta_new", methods={"GET","POST"})
  */
  public function new(Request $request, SluggerInterface $slugger): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      $encuestum = new Encuesta();
      
      $form = $this->createForm(EncuestaType::class, $encuestum);
      $form->handleRequest($request);
      $entityManager = $this->getDoctrine()->getManager();
      if ($form->isSubmitted() && $form->isValid()) {
        $brochureFile = $form->get('banner')->getData();
        if ($brochureFile) {
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);

            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $brochureFile->move(
                    $this->getParameter('banner_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                throw new Exception("Ha ocurrido un error al subir la imagen $e");
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $encuestum->setBanner($newFilename);
        }
        $encuestum->setUser($user_id);
        $entityManager->persist($encuestum);
        $entityManager->flush();
      
        
        return $this->redirectToRoute('encuesta_index');
      }

      return $this->render('encuesta/new.html.twig', [
        'encuestum' => $encuestum,
        'form' => $form->createView(),
      ]);
    }else{
      return $this->redirectToRoute('app_login');
    }

  }
  
  /**
  * @Route("/duply/{id}", name="encuesta_duply", methods={"GET"})
  */
  public function duply(Encuesta $encuesta, Request $request): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      $encuesta_new = new Encuesta();
      
      $entityManager = $this->getDoctrine()->getManager();
      $descripcion_e = $encuesta->getDescripcion();
      $banner_e = $encuesta->getBanner();
      $categoria_e = $encuesta->getCategoria();
      $color_e = $encuesta->getBackground();
      $instructivo_e = $encuesta->getInstructivo();
      $encuesta_new->setDescripcion($descripcion_e);
      $encuesta_new->setBanner($banner_e);
      $encuesta_new->setCategoria($categoria_e);
      $encuesta_new->setInstructivo("$instructivo_e");
      $encuesta_new->setBackground($color_e);
      $encuesta_new->setUser($user_id);
      $entityManager->persist($encuesta_new);
      $entityManager->flush();
      $preguntas = $encuesta->getPregunta();
      $valores = $encuesta->getValors();
      $valores_a = array();
      $idx = 0;
      foreach ($valores as $valor) {
        $encuesta_new->addValor($valor);
      }
      
      foreach ($preguntas as $pregunta) {
        $pregunta_new = new Pregunta();
        $selecciones = $pregunta->getSeleccion();
        $grupos = $pregunta->getGrupos(); 
        $descripcion_p = $pregunta->getDescripcion();
        $type_p = $pregunta->getType();
        $posicion_p = $pregunta->getPosicion();
        $pregunta_new->addEncuesta($encuesta_new);
        $pregunta_new->setDescripcion($descripcion_p);
        $pregunta_new->setType($type_p);
        $pregunta_new->setPosicion($posicion_p);
        $entityManager->persist($pregunta_new);
        $entityManager->flush();
        
        foreach ($selecciones as $seleccion_p) {
          $seleccion = new Seleccion();
          $descripcion_s = $seleccion_p->getDescripcion();
          $valor_id = $seleccion_p->getValor();
          $seleccion->addPregunta($pregunta_new);
          $seleccion->setDescripcion($descripcion_s);
          $seleccion->setValor($valor_id);
          $entityManager->persist($seleccion);
          $entityManager->flush();
        }
        foreach ($grupos as $grupo_p) {
          $grupo = new Grupo();
          $descripcion_s = $grupo_p->getDescripcion();
          $grupo->setPregunta($pregunta_new);
          $grupo->setDescripcion($descripcion_s);
          
          $entityManager->persist($grupo);
          $entityManager->flush();
        }
        
      }
      return $this->redirectToRoute('encuesta_index');
      
    	 
    }
    else{
      return $this->redirectToRoute('app_login');
    }

  }
  
  /**
  * @Route("/status/{id}", name="encuesta_status", methods={"GET"})
  */
  public function status(Encuesta $encuesta, Request $request): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      $entityManager = $this->getDoctrine()->getManager();
      $status = $encuesta->getStatus();
      if ($status == 1) {
        $action = 0;
      } else {
        $action = 1;
      }
      $encuesta->setStatus($action);
      $entityManager->persist($encuesta);
      $entityManager->flush();
    
    
      return $this->redirectToRoute('encuesta_index');
      
    	 
    }
    else{
      return $this->redirectToRoute('app_login');
    }

  }
  
  /**
  * @Route("/{id}", name="encuesta_show", methods={"GET"})
  */
  public function show(Request $request, Encuesta $encuestum, EncuestaRepository $encuestaRepository, CategoriaValorRepository $CategoriaValorRepository): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      	$query_category_valor = $request->query->get('category_valor');
      	$query_clasificacion = $request->query->get('query_clasificacion');
    	return $this->render('encuesta/show.html.twig', [
        
        'encuesta' => $encuestum,
        'categorias_v' => $CategoriaValorRepository->findBy(['user'=>$user_id]),
        'query_category_valor' => $query_category_valor,
        'query_clasificacion' => $query_clasificacion
        
    	]);
    }
    else{
      return $this->redirectToRoute('app_login');
    }

  }

  

  /**
  * @Route("/{id}/registro", name="encuesta_client",options={"expose"=true}, methods={"GET", "POST"})
  */
  public function show_cliente(Request $request, Encuesta $encuestum): Response
  {
    $preguntas = $encuestum->getPregunta();
    if($request->isXMLHttpRequest()){
          $registro = new Registro();

          $data = $request->request->get('data');
          if (isset($data["respuestas_seleccion"]["selecciones"])) {
            $selecciones_r = $data["respuestas_seleccion"]["selecciones"];
          }

          if (isset($data["respuestas_simples"]["simples"])) {
            $simples_r = $data["respuestas_simples"]["simples"];
          }

          if (isset($data["respuestas_clasificacion"]["clasificacion"])) {
            $clasificacion_r = $data["respuestas_clasificacion"]["clasificacion"];
          }

          $nombre = $data["nombre"];
          $pais = $data["pais"];
          $entityManager = $this->getDoctrine()->getManager();
          $registro->setNombre($nombre);
          $registro->setPais($pais);
          $registro->setEncuesta($encuestum);
          if ($encuestum->getCategoria()) {
            $registro->setCategoria($encuestum->getCategoria());
          }
          
          $entityManager->persist($registro);
          $entityManager->flush();
          $idx1 = 1;
          $idx2 = 1;
          $idx3 = 1;
          foreach($preguntas as $pregunta) {
            if ($pregunta->getType() == 'simple') {
              $respuesta = new RespuestaSimple();
              $descripcion = $simples_r[$idx1]['id_r'];
              $respuesta->setDescripcion($descripcion);
              $respuesta->setEncuesta($encuestum);
              $respuesta->setPregunta($pregunta);
              $respuesta->setRegistro($registro);
              $entityManager->persist($respuesta);
              $entityManager->flush();
              $idx1++;
            }
            if ($pregunta->getType() == 'seleccion') {
              $respuesta = new Respuesta();
              $seleccion = $entityManager->getRepository(Seleccion::class)->find($selecciones_r[$idx2]['id_s']);
              $respuesta->setSeleccion($seleccion);
              $respuesta->setEncuesta($encuestum);
              $respuesta->setPregunta($pregunta);
              $respuesta->setRegistro($registro);
              $entityManager->persist($respuesta);
              $entityManager->flush();
              $idx2++;
            }
            if ($pregunta->getType() == 'clasificacion') {
              $respuesta = new RespuestaGrupo();
              $grupo = $entityManager->getRepository(Grupo::class)->find($clasificacion_r[$idx3]['id_c']);
              $respuesta->setGrupo($grupo);
              $respuesta->setEncuesta($encuestum);
              $respuesta->setPregunta($pregunta);
              $respuesta->setRegistro($registro);
              $entityManager->persist($respuesta);
              $entityManager->flush();
              $idx3++;
            }

          }

          return new JsonResponse("Guardada registro con Exito");
    }



    return $this->render('encuesta/client.html.twig', [
      	'encuesta' => $encuestum,
        'preguntas' => $preguntas,
    ]);
  }



  /**
  * @Route("/{id}/edit", name="encuesta_edit", options={"expose"=true}, methods={"GET","POST"})
  */
  public function edit(Request $request, Encuesta $encuestum, $id, SluggerInterface $slugger,CategoriaEncuestaRepository $CategoriaEncuestaRepository): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      $form = $this->createForm(EncuestaType::class, $encuestum);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $brochureFile = $form->get('banner')->getData();
        if ($brochureFile) {
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);

            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $brochureFile->move(
                    $this->getParameter('banner_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                throw new Exception("Ha ocurrido un error al subir la imagen $e");
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $encuestum->setBanner($newFilename);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('encuesta_edit', array('id'=>$id));
      }
      return $this->render('encuesta/edit.html.twig', [
        'categorias' =>$CategoriaEncuestaRepository->findBy(['user'=>$user_id]),
        'encuesta' => $encuestum,
        'form' => $form->createView(),
      ]);
    }else{
      return $this->redirectToRoute('app_login');
    }

  }

  /**
  * @Route("/{id}", name="encuesta_delete",methods={"DELETE"} )
  */
  public function delete(Request $request, Encuesta $encuestum): Response
  {
    $user_id = $this->getUser();
    if($user_id){
      if ($this->isCsrfTokenValid('delete'.$encuestum->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($encuestum);
      $entityManager->flush();

      return $this->redirectToRoute('encuesta_index');
    }
    }else{
      return $this->redirectToRoute('app_login');
    }



  }

  /**
  * @Route("/addordelete", options={"expose"=true}, name="addordelete_encuesta")
  */
  public function addordelete_encuesta(Request $request){
    if($request->isXmlHttpRequest()){

      $id_v = $request->request->get('id_v');
      $id_e = $request->request->get('id_e');
      $status = $request->request->get('status');
      
      $entityManager = $this->getDoctrine()->getManager();
      $encuesta = $entityManager->getRepository(Encuesta::class)->find($id_e);
      $valor = $entityManager->getRepository(Valor::class)->find($id_v);

      if ($status == 0) {
        $valor->RemoveEncuestum($encuesta);
        foreach ($valor->getSeleccions() as $seleccion) {
          $valor->removeSeleccion($seleccion);
          foreach ($seleccion->getRespuestas() as $respuesta) {
            $seleccion->removeRespuesta($respuesta);
          }
        }
            
        
      
      } else {
        $valor->addEncuestum($encuesta);
      }
      $entityManager->persist($valor);
      $entityManager->flush();

      
      return new JsonResponse($status);
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }
  
  /**
  * @Route("/orden", options={"expose"=true}, name="order_encuesta")
  */

  public function orderencuesta(Request $request){

    if($request->isXmlHttpRequest()){

      $data = $request->request->get('data');
      $posiciones = $data['posiciones'];
      $id_e = $data['id_e'];
      $entityManager = $this->getDoctrine()->getManager();
      for ($idx=0; $idx < count($posiciones); $idx++) {
        $pregunta = $entityManager->getRepository(Pregunta::class)->find($posiciones[$idx]["posicion"]);
      
        $pregunta->setPosicion($idx);
        $entityManager->flush();


      }

      return new JsonResponse($posiciones);
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }

  /**
  * @Route("/delete", name="delete_pregunta", options={"expose"=true})
  */
  public function deletepregunta(Request $request): Response
  {
    if($request->isXMLHttpRequest()){
      $id = $request->request->get('id_p');

      $entityManager = $this->getDoctrine()->getManager();
      $pregunta = $entityManager->getRepository(Pregunta::class)->find($id);
      $selecciones = $pregunta->getSeleccion();
      foreach ($selecciones as $seleccion){

          $entityManager->remove($seleccion);


      }
      $entityManager->remove($pregunta);
      $entityManager->flush();
      return new JsonResponse('Eliminado');
    } else{
      throw new Exception('Estas tratando de hackearme?');
    }
  }

  /**
  * @Route("/save", options={"expose"=true}, name="save_pregunta")
  */
  public function savepregunta(Request $request){
    if($request->isXmlHttpRequest()){

      $data = $request->request->get('data');
      $pregunta_id = $data['pregunta']['id'];
      $pregunta_d = $data['pregunta']['descripcion'];
      if (isset($data['selecciones'])) {
        $selecciones_r = $data['selecciones'];
      }
      if (isset($data['grupos'])) {
        $grupos_r = $data['grupos'];
      }
      $entityManager = $this->getDoctrine()->getManager();
      $pregunta = $entityManager->getRepository(Pregunta::class)->find($pregunta_id);
      $pregunta->setDescripcion($pregunta_d);
      $selecciones = $pregunta->getSeleccion();
      $grupos = $pregunta->getGrupos();
      $idx = 0;
      $type = $pregunta->getType();
      if ($type=="clasificacion") {
        if (isset($data['grupos'])) {
          foreach ($grupos as $grupo) {
              $grupo->setDescripcion($grupos_r[$idx]['descripcion_g']);
              $idx++;
          }
        }
      }
      if ($type=="seleccion") {
        if (isset($data['selecciones'])) {
          foreach ($selecciones as $seleccion) {
              $valor_id = $entityManager->getRepository(Valor::class)->find($selecciones_r[$idx]['id_v']);
              $seleccion->setDescripcion($selecciones_r[$idx]['descripcion_s']);
              $seleccion->setValor($valor_id);
              $idx++;
          }
        }
      }
      $entityManager->flush();
      return new JsonResponse($data);
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }

  
  /**
  * @Route("/save_e", options={"expose"=true}, name="save_encuesta")
  */
  public function saveencuesta(Request $request){
    if($request->isXmlHttpRequest()){

      $id = $request->request->get('id_e');
      $descripcion = $request->request->get('descripcion');
      $instructivo = $request->request->get('instructivo');
      $color = $request->request->get('color');
      $id_c = $request->request->get('id_c');
      $entityManager = $this->getDoctrine()->getManager();
      $encuesta = $entityManager->getRepository(Encuesta::class)->find($id);
      $categoria = $entityManager->getRepository(CategoriaEncuesta::class)->find($id_c);
      $encuesta->setDescripcion($descripcion);
      $encuesta->setInstructivo($instructivo);
      $encuesta->setCategoria($categoria);
      $encuesta->setBackground($color);
      $entityManager->flush();

      return new JsonResponse("Guardado Exitosamente");
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }
  /**
  * @Route("/duply", options={"expose"=true}, name="duply_pregunta")
  */
  public function duplypregunta(Request $request){
    if($request->isXmlHttpRequest()){

      $id_e = $request->request->get('id_e');
      $id_p = $request->request->get('id_p');
      $pregunta = new Pregunta();

      $entityManager = $this->getDoctrine()->getManager();
      $pregunta_o = $entityManager->getRepository(Pregunta::class)->find($id_p);
      $encuesta = $entityManager->getRepository(Encuesta::class)->find($id_e);
      $selecciones = $pregunta_o->getSeleccion();
      $grupos = $pregunta_o->getGrupos();
      foreach ($selecciones as $seleccion_r){
          $seleccion = new Seleccion();
          if($seleccion_r->getValor()){
            $id_v = $entityManager->getRepository(Valor::class)->find($seleccion_r->getValor()->getId());
          }else{
            $id_v = null;
          }
          $seleccion->setValor($id_v);
          $descripcion_s = $seleccion_r->getDescripcion();
          $seleccion->addPregunta($pregunta);
          $seleccion->setDescripcion($descripcion_s);
          $entityManager->persist($seleccion);

      }
      foreach ($grupos as $grupo_r){
          $grupo = new Grupo();

          $descripcion_s = $grupo_r->getDescripcion();
          $grupo->setPregunta($pregunta);
          $grupo->setDescripcion($descripcion_s);
          $entityManager->persist($grupo);

      }
      $descripcion = $pregunta_o->getDescripcion();
      $type = $pregunta_o->getType();
      $posicion = $pregunta_o->getPosicion();
      $posicion++;
      $pregunta->addEncuesta($encuesta);
      $pregunta->setDescripcion($descripcion);
      $pregunta->setType($type);
      $pregunta->setPosicion($posicion);


      $entityManager->persist($pregunta);
      $entityManager->flush();

      return new JsonResponse('Duplicado Exitosamente');
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }
  
  /**
  * @Route("/add", options={"expose"=true}, name="add_pregunta")
  */
  public function addpregunta(Request $request){
    if($request->isXmlHttpRequest()){

      $id = $request->request->get('id');
      $type = $request->request->get('type');
      if ($type==0) {
        $type = "simple";
      }
      if($type==1) {
        $type = "seleccion";
      }
      if ($type==2) {
        $type = "clasificacion";
      }
      $pregunta = new Pregunta();

      $entityManager = $this->getDoctrine()->getManager();
      $encuesta = $entityManager->getRepository(Encuesta::class)->find($id);

      $pregunta->addEncuesta($encuesta);
      $pregunta->setType($type);
      $pregunta->setPosicion(count($encuesta->getPregunta()) + 1);
      $entityManager->persist($pregunta);
      $entityManager->flush();

      return new JsonResponse('Registrado Exitosamente');
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }
   


  /**
  * @Route("/add_s", options={"expose"=true}, name="add_seleccion")
  */
  public function addseleccion(Request $request){
    if($request->isXmlHttpRequest()){

      $id = $request->request->get('id_p');
      $seleccion = new Seleccion();

      $entityManager = $this->getDoctrine()->getManager();
      $pregunta = $entityManager->getRepository(Pregunta::class)->find($id);
      $seleccion->addPregunta($pregunta);

      $entityManager->persist($seleccion);

      $entityManager->flush();

      return new JsonResponse('Registrado Exitosamente');
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }
  /**
  * @Route("/add_g", options={"expose"=true}, name="add_grupo")
  */
  public function addgrupo(Request $request){
    if($request->isXmlHttpRequest()){

      $id = $request->request->get('id_p');
      $grupo = new Grupo();

      $entityManager = $this->getDoctrine()->getManager();
      $pregunta = $entityManager->getRepository(Pregunta::class)->find($id);
      $grupo->setPregunta($pregunta);

      $entityManager->persist($grupo);

      $entityManager->flush();

      return new JsonResponse('Registrado Exitosamente');
    }
    else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }

  /**
  * @Route("/delete_s", options={"expose"=true}, name="delete_seleccion")
  */
  public function deleteseleccion(Request $request){
    if($request->isXMLHttpRequest()){
      $id = $request->request->get('id_s');

      $entityManager = $this->getDoctrine()->getManager();
      $seleccion = $entityManager->getRepository(Seleccion::class)->find($id);
      $entityManager->remove($seleccion);
      $entityManager->flush();
      return new JsonResponse('Eliminado');
    } else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }
  /**
  * @Route("/delete_g", options={"expose"=true}, name="delete_grupo")
  */
  public function deletegrupo(Request $request){
    if($request->isXMLHttpRequest()){
      $id = $request->request->get('id_g');

      $entityManager = $this->getDoctrine()->getManager();
      $grupo = $entityManager->getRepository(Grupo::class)->find($id);
      $entityManager->remove($grupo);
      $entityManager->flush();
      return new JsonResponse('Eliminado');
    } else{
      throw new Exception('Estas tratando de hackearme?');
    }

  }
  /**
  * @Route("/load", name="load_preguntas", options={"expose"=true})
  */
  public function loadpreguntas(Request $request) {
     if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
      $id = $request->request->get('id_e');
      $entityManager = $this->getDoctrine()->getManager();
      $encuesta = $entityManager->getRepository(Encuesta::class)->find($id);
      $preguntas = $encuesta->getPregunta();
      $valores = $this->getUser()->getValors();
      $valores_ep = array();
      $valores_e = $encuesta->getValors();
      $preguntas_p = array();
      $valores_p = array();
      $idx = 0;
      $idx3 = 0;
      $idx4 = 0;
      $encuesta_p = array(
        'id_e' =>$encuesta->getId(),
        'descripcion' =>$encuesta->getDescripcion(),
      );
      if ($encuesta->getValors()) {
        foreach ($valores_e as $valor){
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
            
          );
          $valores_ep[$idx4++] = $temp;
        }
      }
      
      
      foreach ($valores as $valor){
        $active = false;
        
          foreach($valor->getEncuesta() as $encuesta_v){
            if ($encuesta_v->getId() == $encuesta->getId()) {
              $active = true;
              break;
            } else{
              $active = false;
            }
          }
        
        
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
          'active' => $active,
        );
        $valores_p[$idx3++] = $temp;
      }
      foreach($preguntas as $pregunta) {
        $idx2 = 0;
        $selecciones_p = array();
        if ($pregunta->getSeleccion()) {
          $selecciones = $pregunta->getSeleccion();
          foreach ($selecciones as $seleccion){
            if($seleccion->getValor()){
              $id_v = $seleccion->getValor()->getId();
              $valor_d =$seleccion->getValor()->getDescripcion();
            }else{
              $id_v = null;
              $valor_d = "vacio";
            }

            $temp = array(
              'id_s' => $seleccion->getId(),

              'id_v' => $id_v,
              'descripcion' => $seleccion->getDescripcion(),
              'valor' => $valor_d,
            );
            $selecciones_p[$idx2++] = $temp;
          }
        }
        $idx3 = 0;
        $grupos_p = array();
        if ($pregunta->getGrupos()) {
          $grupos = $pregunta->getGrupos();
          foreach ($grupos as $grupo){
            $temp = array(
              'id_g' => $grupo->getId(),
              'descripcion' => $grupo->getDescripcion(),
            );
            $grupos_p[$idx3++] = $temp;
          }
        }
        $temp = array(
          'id_p' => $pregunta->getId(),
          'descripcion' => $pregunta->getDescripcion(),
          'type' => $pregunta->getType(),
          'selecciones' => $selecciones_p,
          'grupos' => $grupos_p,

        );
        $preguntas_p[$idx++] = $temp;

      }
      $temp = array(
        'preguntas' =>$preguntas_p,
        'valores' => $valores_p,
        'valores_e' => $valores_ep,
        'encuesta' => $encuesta_p,
      );

      $jsonData = $temp;
      return new JsonResponse($jsonData);

    }  else{
      throw new Exception('Estas tratando de hackearme?');
    }
  }
}
