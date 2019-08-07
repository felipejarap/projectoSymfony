<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\ReservaType;
use AppBundle\Form\UsuarioType;


use AppBundle\Entity\Usuario;
use AppBundle\Entity\Reserva;


 /**
     * @Route("/gestionReservas")
     */
class GestionReservasController extends Controller
{
    /**
     * @Route("/nuevaReserva", name="nuevaReserva")
     */
    public function nuevoReservaAction(Request $request)
    {
        //se crea la reserva
        $reserva = new Reserva();
        //contruccion del formulario para agregar una reserva
        $form = $this->createForm(ReservaType::class, $reserva);   
        //recogemos la informacion
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //rellenar el Entity reserva
            $usuario=$this->getUser();
            $reserva->setUsuario($usuario);
            //almacenar la reserva
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reserva);
            $entityManager->flush();       
            return $this->redirectToRoute('reservas');
        }

        return $this->render('gestionReservas/nuevaReserva.html.twig', array('form'=>$form->createView()));
      
    }
    /**
     * @Route("/reservas/", name="reservas")
     */
    public function reservasAction(Request $request)
    {
        $reservaRepository = $this->getDoctrine()->getrepository(Reserva::class);
        $reservas = $reservaRepository->findByUsuario($this->getUser());
       return $this->render('gestionReservas/reservas.html.twig',array('reservas'=> $reservas));
      
    }

}