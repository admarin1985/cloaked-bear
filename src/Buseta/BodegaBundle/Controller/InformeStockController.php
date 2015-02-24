<?php

namespace Buseta\BodegaBundle\Controller;


use Buseta\BodegaBundle\Entity\InformeStock;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Symfony\Component\HttpFoundation\Request;
use Buseta\BodegaBundle\Form\Model\InformeStockModel;
use Buseta\BodegaBundle\Form\Type\InformeStockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InformeStockController extends Controller
{

    /**
     * Lists all InformeStock entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $funcionesExtras = new FuncionesExtras();

        //Se actualiza la informacion del InformeStock
        $funcionesExtras->ActualizarInformeStock($em);

        $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();
        $entities = $em->getRepository('BusetaBodegaBundle:InformeStock')->findAll();

        /*$paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            5,
            array('pageParameterName' => 'page')
        );*/

        return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
            'entities' => $entities,
            'almacenes' => $almacenes,
        ));
    }


}
