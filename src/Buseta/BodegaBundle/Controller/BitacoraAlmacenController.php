<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BodegaBundle\Form\Filter\BitacoraAlmacenFilter;
use Buseta\BodegaBundle\Form\Model\BitacoraAlmacenFilterModel;
use Buseta\BodegaBundle\Form\Model\BitacoraAlmacenModel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Form\Type\BitacoraAlmacenType;
use Buseta\BodegaBundle\Extras\FuncionesExtras;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * BitacoraAlmacen controller.
 *
 * @Route("bodega/bitacoraalmacen")
 */
class BitacoraAlmacenController extends Controller
{

    /**
     * Lists all BitacoraAlmacen entities.
     *
     * @Route("/", name="bitacoraalmacen")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new BitacoraAlmacenFilterModel();

        $form = $this->createForm(new BitacoraAlmacenFilter(), $filter, array(
            'action' => $this->generateUrl('bitacoraalmacen'),
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:BitacoraAlmacen:index.html.twig', array(
            'entities' => $entities,
            'filter_form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing BitacoraAlmacen entity.
     *
     * @Route("/{id}/show", name="bitacoraalmacen_show", methods={"GET"}, options={"expose":true})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BitacoraAlmacen entity.');
        }

        return $this->render('BusetaBodegaBundle:BitacoraAlmacen:show.html.twig', array(
            'entity' => $entity
        ));
    }


    /**
     * @param BitacoraAlmacen $bitacoraAlmacen
     *
     * @Route("/{id}/data.{format}", name="productos_get_product_data", requirements={"format": "json|txt"}, defaults={"format":"json"}, options={"expose": true})
     * @Method({"GET"})
     */
    public function getBitacoraAlmacenDataAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $qb = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')
            ->createQueryBuilder('BitacoraAlmacen');

        /** @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacoraalmacen */
        $producto = $qb->select('producto,uom,categoriaProducto')
            ->leftJoin('BitacoraAlmacen.uom', 'uom')
            ->leftJoin('BitacoraAlmacen.categoriaProducto', 'categoriaProducto')
            ->where($qb->expr()->eq('BitacoraAlmacen', ':id'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();

        if (!$producto) {
            return new JsonResponse('No existe la BitacoraAlmacen con id: ' . $id, 404);
        }

        $data = array(
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'codigo' => $producto->getCodigo(),
        );

        // Select UOM
        if ($producto->getUom()) {
            $data['uom'] = array(
                'id' => $producto->getUom()->getId(),
                'value' => $producto->getUom()->getValor(),
            );
        }

        return new JsonResponse($data);
    }


    //A partir de aqui los metodos requeridos para el AJAX que llama desde el formulario de Producto

    /**
     * Displays a form to edit an existing BitacoraAlmacen entity.
     *
     * @Route("/listarporproducto/{id}", name="bitacoraalmacen_listarpor_producto", methods={"GET"}, options={"expose":true})
     */
    public function listAction(Producto $producto, Request $request)
    //Esta es la variante para que fucione con formulario de filtro
    {
        /*Esta variante es para el formulario de busqueda*/
        $filter = new BitacoraAlmacenFilterModel();

        $form = $this->createForm(new BitacoraAlmacenFilter(), $filter, array(
            //   'action' => $this->generateUrl('bitacoraalmacen'),
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->filter();
        }

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaBodega/Producto/BitacoraAlmacen/list_template.html.twig', array(
            'entities' => $entities,
            'filter_form' => $form->createView(),
            'producto' => $producto,
        ));

    }


    /*    public function listarPorProductoAction(Producto $producto, Request $request)
        {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraAlmacen')
                ->findBy(array('producto' => $producto));

            $entities = $this->get('knp_paginator')
                ->paginate(
                    $entities,
                    $request->query->get('page', 1),
                    10
                );

            return $this->render('@BusetaBodega/Producto/BitacoraAlmacen/list_template.html.twig', array(
                'entities' => $entities,
                'producto' => $producto,
            ));
        }*/



}
