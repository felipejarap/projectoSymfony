<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use AppBundle\Form\UsuarioType;
use AppBundle\Entity\Plato;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Ingrediente;
use AppBundle\Entity\Usuario;



class DefaultController extends Controller
{
    /**
     * @Route("/{pagina}", name="homepage")
     */
    public function homeAction(Request $request,$pagina=1)
    {
        
        // replace this example code with whatever you need
         //capturar repositorio de la tabla plato de la base de datos
         $platoRepository= $this->getDoctrine()->getrepository(Plato::class);
         $platos =$platoRepository->paginaPlato($pagina);
        return $this->render('frontal/index.html.twig',array('platos'=> $platos, 'paginaActual' => $pagina));
       //return new JsonResponse(['data'=>'weeeeeena']);
    }
     /**
     * @Route("/nosotros/", name="nosotros")
     */
    public function nosotrosAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('frontal/nosotros.html.twig');
       //return new JsonResponse(['data'=>'weeeeeena']);
    }
     /**
     * @Route("/contactar/{sitio}", name="contactar")
     */
    public function contactarAction(Request $request,$sitio='todos')
    {
        // replace this example code with whatever you need
        return $this->render('frontal/bares.html.twig',array("sitio" => $sitio));
       //return new JsonResponse(['data'=>'weeeeeena']);
    }
       /**
     * @Route("/plato/{id}", name="plato")
     */
    public function platoAction(Request $request,$id=null)
    {
        if($id != null )
        {
            $platoRepository= $this->getDoctrine()->getrepository(Plato::class);
            $plato = $platoRepository->find($id);
            return $this->render('frontal/plato.html.twig',array("plato" => $plato));
        }else{
            return $this->redirectToRoute('homepage');
        }
    }

     /**
     * @Route("/categoria/{id}", name="categoria")
     */
    public function categoriaAction(Request $request,$id=null)
    {
        if($id != null )
        {
            $categoriaRepository= $this->getDoctrine()->getrepository(Categoria::class);
            $categoria = $categoriaRepository->find($id);
            return $this->render('frontal/categoria.html.twig',array("categoria" => $categoria));
        }else{
            return $this->redirectToRoute('homepage');
        }
    }

      /**
     * @Route("/ingrediente/{id}", name="ingrediente")
     */
    public function ingredienteAction(Request $request,$id=null)
    {
        if($id != null )
        {
            $ingredienteRepository= $this->getDoctrine()->getrepository(Ingrediente::class);
            $ingrediente = $ingredienteRepository->find($id);
            return $this->render('frontal/ingrediente.html.twig',array("ingrediente" => $ingrediente));
        }else{
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/nuevaCategoria", name="nuevaCategoria")
     */
    public function nuevaCategoriaAction(Request $request)
    {
        //se crea la categoria
        $categoria = new Categoria();
        //contruccion del formulario para agregar una nueva Categoria
        $form = $this->createForm(CategoriaType::class, $categoria);   
        //recogemos la informacion
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //rellenar el Entity categoria
            $categoria = $form->getData();
            $fotofile =$categoria->getFoto();
            $fileName = $this->generateUniqueFileName().'.'.$fotofile->getExtension();
            $fotofile->move(
                $this->getParameter('platosImg_directory'),
                $fileName
            );
            $categoria ->setFoto($fileName);
            //almacenar la categoria
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();       
            return $this->redirectToRoute('categoria',array('id' => $categoria->getId()));
        }

        return $this->render('gestionPlatos/nuevaCategoria.html.twig', array('form'=>$form->createView()));
      
    }
    /**
     * @Route("/registro/", name="registro")
     */
    public function nuevoRegistroAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
         // 1) build the form
         $usuario = new Usuario();
         $form = $this->createForm(UsuarioType::class, $usuario);
 
         // 2) handle the submit (will only happen on POST)
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
 
             // 3) Encode the password (you could also do this via Doctrine listener)
             $password = $passwordEncoder->encodePassword($usuario, $usuario->getPlainPassword());
             $usuario->setPassword($password);

             $usuario->setUsername($usuario->getEmail());
            
             $usuario->setRoles(array('ROLE_USER'));

             // 4) save the User!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($usuario);
             $entityManager->flush();
 
            return $this->redirectToRoute('login');
        }

        return $this->render('frontal/registro.html.twig', array('form'=>$form->createView()));
    }

     /**
     * @Route("/login/", name="login")
     */
    public function LoginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render('frontal/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

}