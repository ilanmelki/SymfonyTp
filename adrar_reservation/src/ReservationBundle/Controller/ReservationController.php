<?php

namespace ReservationBundle\Controller;

use ReservationBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * Reservation controller.
 *
 * @Route("reservation")
 */
class ReservationController extends Controller
{
    /**
     * Lists all reservation entities.
     *
     * @Route("/", name="reservation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservations = $em->getRepository('ReservationBundle:Reservation')->findAll();

        return $this->render('reservation/index.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    /**
     * Creates a new reservation entity.
     *
     * @Route("/new", name="reservation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm('ReservationBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //var_dump($reservation->getDate()). '<br>';

           //var_dump($reservation->getFormateur()). '<br>';
            $em = $this->getDoctrine()->getManager();

            $reservations = $em->getRepository('ReservationBundle:Reservation')->findAll();

            //var_dump($reservations[0]->getDate()). '<br>';
            //var_dump(count($reservations));
            for ($i=0; $i<count($reservations); $i++){
                //var_dump(count($reservations));
                if((isset($reservations[0]))&&($reservations[$i]->getDate()==$reservation->getDate())&&($reservations[$i]->getHoraire()==$reservation->getHoraire())){
                if($reservations[$i]->getFormateur()==$reservation->getFormateur()){
                    $reservation=$reservations[$i];
                    $erreur= 'vous avez déjà une réservation pendant ces horaires. ';
                    return $this->redirectToRoute('reservation_error', array('id' => $reservation->getId(), 'erreur'=>$erreur));

                }else if ($reservations[$i]->getSalle()==$reservation->getSalle()){
                    $reservation=$reservations[$i];
                    $erreur= 'cette salle est déja reservée. ' ;
                    return $this->redirectToRoute('reservation_error', array('id' => $reservation->getId(), 'erreur'=>$erreur));
                }else if ($reservations[$i]->getPromo()==$reservation->getPromo()){
                    $reservation=$reservations[$i];
                    $erreur= 'cette classe a déjà un cours pendant ces horaires. ';
                    return $this->redirectToRoute('reservation_error', array('id' => $reservation->getId(), 'erreur'=>$erreur));
                }
            }
            }
            if($i=count($reservations)){
                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();
                return $this->redirectToRoute('reservation_show', array('id' => $reservation->getId()));
            }

        }

        return $this->render('reservation/new.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a reservation entity errors.
     *
     * @Route("/{id}/{erreur}", name="reservation_error")
     * @Method("GET")
     */
    public function erreurAction(Reservation $reservation,string $erreur)
    {

        /*var_dump($reservation->getDate()). '<br>';
        var_dump($reservation->getHoraire()). '<br>';
        var_dump($reservation->getFormateur()). '<br>';*/
        //$deleteForm = $this->createDeleteForm($reservation);
        return $this->render('reservation/erreur.html.twig', array(
            'reservation' => $reservation,
            'erreur'=>$erreur,
        ));
    }

    /**
     * Finds and displays a reservation entity.
     *
     * @Route("/{id}", name="reservation_show")
     * @Method("GET")
     */
    public function showAction(Reservation $reservation)
    {
        /*var_dump($reservation->getDate()). '<br>';
        var_dump($reservation->getHoraire()). '<br>';
        var_dump($reservation->getFormateur()). '<br>';*/
        $deleteForm = $this->createDeleteForm($reservation);

        return $this->render('reservation/show.html.twig', array(
            'reservation' => $reservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     * @Route("/{id}/edit", name="reservation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('ReservationBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reservation entity.
     *
     * @Route("/{id}", name="reservation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reservation $reservation)
    {
        $form = $this->createDeleteForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }

    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
