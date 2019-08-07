<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\PlatoType;
use AppBundle\Form\CategoriaType;
use AppBundle\Form\IngredienteType;
use AppBundle\Entity\Plato;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Ingrediente;

 /**
     * @Route("/gestionPlatos")
     */
class GestionPlatosController extends Controller
{
    /**
     * @Route("/nuevoPlato", name="nuevoPlato")
     */
    public function nuevoPlatoAction(Request $request)
    {
        //se crea el plato
        $plato = new Plato();
        //contruccion del formulario para agregar un nuevo plato
        $form = $this->createForm(PlatoType::class, $plato);   
        //recogemos la informacion
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //rellenar el Entity plato
            $plato = $form->getData();
            $fotofile =$plato->getFoto();
            $fileName = $this->generateUniqueFileName().'.'.$fotofile->getExtension();
            $fotofile->move(
                $this->getParameter('platosImg_directory'),
                $fileName
            );
            $plato ->setFoto($fileName);
            $plato ->setFechaCreacion(new \DateTime());
            //almacenar el plato
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plato);
            $entityManager->flush();       
            return $this->redirectToRoute('plato',array('id' => $plato->getId()));
        }

        return $this->render('gestionPlatos/nuevoPlato.html.twig', array('form'=>$form->createView()));
      
    }
    /**
     * @return string
     */
    public function generateUniqueFileName()
    {
        return md5(uniqid());
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
     * @Route("/nuevoIngrediente", name="nuevoIngrediente")
     */
    public function nuevoIngredienteAction(Request $request)
    {
        //se crea el ingrediente
        $ingrediente = new Ingrediente();
        //contruccion del formulario para agregar un nuevo Ingrediente
        $form = $this->createForm(IngredienteType::class, $ingrediente);   
        //recogemos la informacion
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //rellenar el Entity ingrediente
            $ingrediente= $form->getData();
            //almacenar el ingrediente
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingrediente);
            $entityManager->flush();       
            return $this->redirectToRoute('ingrediente',array('id' => $ingrediente->getId()));
        }

        return $this->render('gestionPlatos/nuevoIngrediente.html.twig', array('form'=>$form->createView()));
      
    }

}