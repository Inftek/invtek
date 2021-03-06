<?php

namespace MRS\InventarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MRS\InventarioBundle\Entity\Equipamento;
use MRS\InventarioBundle\Form\EquipamentoType;

/**
 * Equipamento controller.
 *
 * @Route("/cadastro/equipamento")
 */
class EquipamentoController extends Controller
{
    /**
     * Lists all Equipamento entities.
     *
     * @Route("/", name="cadastro_equipamento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipamentos = $em->getRepository('MRSInventarioBundle:Equipamento')->findAll();

        return $this->render('equipamento/index.html.twig', array(
            'equipamentos' => $equipamentos,
        ));
    }

    /**
     * Creates a new Equipamento entity.
     *
     * @Route("/new", name="cadastro_equipamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $equipamento = new Equipamento();
        $form = $this->createForm('MRS\InventarioBundle\Form\EquipamentoType', $equipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamento);
            $em->flush();

            $this->addFlash('notice','Criado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamento_show', array('id' => $equipamento->getId()));
        }

        return $this->render('equipamento/new.html.twig', array(
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Equipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamento_show")
     * @Method("GET")
     */
    public function showAction(Equipamento $equipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamento);

        return $this->render('equipamento/show.html.twig', array(
            'equipamento' => $equipamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Equipamento entity.
     *
     * @Route("/{id}/edit", name="cadastro_equipamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Equipamento $equipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamento);
        $editForm = $this->createForm('MRS\InventarioBundle\Form\EquipamentoType', $equipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamento);
            $em->flush();

            $this->addFlash('notice','Alterado com sucesso!');

            return $this->redirectToRoute('cadastro_equipamento_show', array('id' => $equipamento->getId()));
        }

        return $this->render('equipamento/edit.html.twig', array(
            'equipamento' => $equipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Equipamento entity.
     *
     * @Route("/{id}", name="cadastro_equipamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Equipamento $equipamento)
    {
        $form = $this->createDeleteForm($equipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipamento);
            $em->flush();
        }

        return $this->redirectToRoute('cadastro_equipamento_index');
    }

    /**
     * Creates a form to delete a Equipamento entity.
     *
     * @param Equipamento $equipamento The Equipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipamento $equipamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cadastro_equipamento_delete', array('id' => $equipamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
