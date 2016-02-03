<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\BusetaBodegaBundle;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\SalidaBodegaProducto;
use Buseta\BodegaBundle\Form\Filter\SalidaBodegaFilter;
use Buseta\BodegaBundle\Form\Model\SalidaBodegaFilterModel;
use Buseta\BodegaBundle\Form\Type\SalidaBodegaProductoType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Form\Type\SalidaBodegaType;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Buseta\BodegaBundle\Event\BitacoraEvents;

/**
 * SalidaBodega controller.
 *
 * @Route("/salidabodega")
 */
class SalidaBodegaController extends Controller
{

    public function procesarSalidaBodegaAction($id)
    {

        $manager = $this->get('buseta.bodega.salidabodega.manager');

        if ($manager->procesar($id)){
            $this->get('session')->getFlashBag()->add('success', 'Se ha procesado la salida de bodega de forma correcta.');
            return $this->redirect( $this->generateUrl('salidabodega_show', array( 'id' => $id ) ) );
        }

        $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al procesar la salida de bodega.');

        return $this->redirect( $this->generateUrl('salidabodega_show', array( 'id' => $id ) ) );

    }

    /**
     * Creates a new SalidaBodega entity.
     * @param SalidaBodega $entity
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function completarSalidaBodegaAction(SalidaBodega $entity)
    {
        /*  @var  \Buseta\BodegaBundle\Entity\SalidaBodega  $entity */
        /*  @var  \Buseta\BodegaBundle\Entity\SalidaBodegaProducto  $salidaBodegaProducto */
        /*  @var  \Buseta\BodegaBundle\Entity\Producto  $producto*/
        /*  @var  \Buseta\BodegaBundle\Entity\Bodega  $bodega*/

        $em = $this->get('doctrine.orm.entity_manager');

        $fe = new FuncionesExtras();

        $almacenOrigen  = $entity->getAlmacenOrigen();

        $error=false;

        //Comparar la existencia de cantidad de productos disponibles en el almacen
        //a partir de la solicitud de salidabodega de productos entre almacenes
        //ciclo a traves de todos las salidas de bodega de productos para verificar y validar
        //la existencia fisica en el almacen de Origen del producto
        foreach ($entity->getSalidasProductos() as $salidaBodegaProducto) {
            $producto = $salidaBodegaProducto->getProducto();
            $cantidad = $salidaBodegaProducto->getCantidad();
            $cantidadDisponible = $fe->comprobarCantProductoAlmacen($producto, $almacenOrigen, $cantidad, $em);

            //Comprobar la existencia del producto en la bodega seleccionada
            if ($cantidadDisponible === 'No existe') {
                $error=true;
                //Fallo de validacion, al no existir el producto en el almacen de origen
                //volver al menu de de crear nuevo SalidaBodega
                $salidaBodegasProductoFormulario = $this->createForm(new SalidaBodegaProductoType());
                $form   = $this->createCreateForm($entity);
                $form->addError(new FormError( sprintf( "El producto %s no existe en la bodega seleccionada", $producto->getNombre()) ));
                return $this->render('BusetaBodegaBundle:SalidaBodega:new.html.twig', array(
                    'entity' => $entity,
                    'salidabodegasProductos' => $salidaBodegasProductoFormulario->createView(),
                    'form'   => $form->createView(),
                ));

            } elseif ($cantidadDisponible < 0) {
                $error=true;
                //Fallo de validacion, al no existir la cantidad solicitada del producto seleccionado en el almacen de origen
                //volver al menu de de crear nuevo SalidaBodega
                $salidaBodegasProductoFormulario = $this->createForm(new SalidaBodegaProductoType());
                $form   = $this->createCreateForm($entity);
                $form->addError(new FormError( sprintf("No existe en la bodega %s la cantidad de productos solicitados para el producto: %s", $almacenOrigen->getNombre(), $producto->getNombre()  )));
                return $this->render('BusetaBodegaBundle:SalidaBodega:new.html.twig', array(
                    'entity' => $entity,
                    'salidabodegasProductos' => $salidaBodegasProductoFormulario->createView(),
                    'form'   => $form->createView(),
                ));

            }
            //si no hay problema con la existencia del producto en la bodega de origen
            //ni con la cantidad de ese producto entonces sigo al siguiente producto
        }

        //Si no hubo error en la validacion de las existencias de ninguna linea de $salidabodegaproducto
        if (!$error) {
            $manager = $this->get('buseta.bodega.salidabodega.manager');
            $id = $entity->getId();
            $result = $manager->completar($id);
            if ($result===true){
                $this->get('session')->getFlashBag()->add('success', 'Se ha completado la salida de bodega de forma correcta.');
                return $this->redirect( $this->generateUrl('salidabodega_show', array( 'id' => $id ) ) );
            } else {
                $this->get('session')->getFlashBag()->add('danger',
                    sprintf('Ha ocurrido un error al completar la salida de bodega: %s', $result));
                return $this->redirect($this->generateUrl('salidabodega_show', array('id' => $id)));
            }
        }

    }

    /**
     * Updated automatically select AlmacenDestino when change select AlmacenOrigen.
     */
    public function select_almacenOrigen_almacenDestinoAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();
//        $almacenDestino = $em->getRepository('BusetaBodegaBundle:Bodega')->findBy(array(
//            'id' => $request->query->get('almacenOrigen_id')
//        ));

        $almacenDestino = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();

        $json = array();
        foreach ($almacenDestino as $almacenDestino) {
            if ($almacenDestino->getId() != $request->query->get('almacenOrigen_id')) {
                $json[] = array(
                    'id' => $almacenDestino->getId(),
                    'valor' => $almacenDestino->getNombre(),
                );
            }
        }

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    public function create_salidabodegaAction(Request $request)
    {
        $entity = new SalidaBodegasProductos();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Lists all SalidaBodega entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new SalidaBodegaFilterModel();

        $form = $this->createForm(new SalidaBodegaFilter(), $filter, array(
            'action' => $this->generateUrl('salidabodega'),
        ));

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:SalidaBodega')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:SalidaBodega')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:SalidaBodega:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new SalidaBodega entity.
     */
    public function createAction(Request $request)
    {
        $entity = new SalidaBodega();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $fechaSalidaBodega = new \DateTime();

            $request = $this->get('request');
            $datos = $request->request->get('buseta_bodegabundle_salida_bodega');

            //Comparar la existencia de cantidad de productos disponibles en el almacen
            //a partir de la solicitud de salidabodega de productos entre almacenes

            $idAlmacenOrigen  = $datos['almacenOrigen'];
            $idAlmacenDestino = $datos['almacenDestino'];

            if(isset($datos['salidas_productos'])) {

                $salidabodegas = $datos['salidas_productos'];

                $cantidadDisponible = 0;

                foreach ($salidabodegas as $salidabodega) {
                    $idProducto = $salidabodega['producto'];

                    $producto           = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
                    $almacen            = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
                    $cantidadProducto   = $salidabodega['cantidad'];

                    $fe = new FuncionesExtras();
                    $cantidadDisponible = $fe->comprobarCantProductoAlmacen($producto, $almacen, $cantidadProducto, $em);

                    //Comprobar la existencia del producto en la bodega seleccionada
                    if ($cantidadDisponible === 'No existe') {

                        //Volver al menu de de crear nuevo SalidaBodega
                        $salidabodegasProductos = $this->createForm(new SalidaBodegaProductoType());

                        $form   = $this->createCreateForm($entity);
                        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
                        $bodega   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);

                        $form->addError(new FormError("El producto '".$producto->getNombre()."' no existe en la bodega seleccionada"));

                        return $this->render('BusetaBodegaBundle:SalidaBodega:new.html.twig', array(
                            'entity' => $entity,
                            'salidabodegasProductos' => $salidabodegasProductos->createView(),
                            'form'   => $form->createView(),
                        ));
                    }
                    //Si no existe la cantidad solicitada en el almacen del producto seleccionado
                    elseif ($cantidadDisponible < 0) {
                        //Volver al menu de de crear nuevo SalidaBodega
                        $salidabodegasProductos = $this->createForm(new SalidaBodegaProductoType());

                        $form   = $this->createCreateForm($entity);
                        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
                        $bodega   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);

                        $form->addError(new FormError("No existe en la bodega '".$bodega->getNombre()."' la cantidad de productos solicitados para el producto: ".$producto->getNombre()));

                        return $this->render('BusetaBodegaBundle:SalidaBodega:new.html.twig', array(
                            'entity' => $entity,
                            'salidabodegasProductos' => $salidabodegasProductos->createView(),
                            'form'   => $form->createView(),
                        ));
                    }
                    //Si sí existe la cantidad del producto en la bodega seleccionada
                    else {
                        /*//Actualizar Bitácora - AlmacenOrigen
                        $bitacora = new BitacoraAlmacen();
                        $bitacora->setProducto($producto);
                        $bitacora->setFechaMovimiento($fechaSalidaBodega);
                        $origen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
                        $bitacora->setAlmacen($origen);
                        $bitacora->setCantMovida($salidabodega['cantidad']);
                        $bitacora->setTipoMovimiento('M-');
                        $em->persist($bitacora);
                        $em->flush();

                        //Actualizar Bitácora - AlmacenDestino
                        $bitacora = new BitacoraAlmacen();
                        $bitacora->setProducto($producto);
                        $bitacora->setFechaMovimiento($fechaSalidaBodega);
                        $destino = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenDestino);
                        $bitacora->setAlmacen($destino);
                        $bitacora->setCantMovida($salidabodega['cantidad']);
                        $bitacora->setTipoMovimiento('M+');
                        $em->persist($bitacora);
                        $em->flush();*/

                        $almacenOrigen    = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
                        $almacenDestino   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenDestino);

                        $centroCosto   = $em->getRepository('BusetaBusesBundle:Autobus')->find($datos['centro_costo']);
                        $ordenTrabajo   = $em->getRepository('BusetaTallerBundle:OrdenTrabajo')->find($datos['orden_trabajo']);

                        //Persistimos los salidabodegas
                        $entity->setCreatedBy($this->getUser()->getUsername());
                        $entity->setMovidoBy($this->getUser()->getUsername());
                        $entity->setCentroCosto($centroCosto);
                        $entity->setControlEntregaMaterial($datos['control_entrega_material']);
                        $entity->setObservaciones($datos['observaciones']);
                        $entity->setTipoOT($datos['tipo_ot']);
                        $entity->setOrdenTrabajo($ordenTrabajo);
                        $entity->setAlmacenOrigen($almacenOrigen);
                        $entity->setAlmacenDestino($almacenDestino);
                        $entity->setFecha($fechaSalidaBodega);

                        if($entity->getEstadoDocumento() == 'PR')
                        {
                            $entity->setEstadoDocumento('CO');
                        }
                        $em->persist($entity);
                        $em->flush();
                    }
                }

                return $this->redirect($this->generateUrl('salidabodega_show', array('id' => $entity->getId())));
            }

        }

        $form->addError(new FormError("Debe realizarse al menos una Salida de Producto"));

        return $this->render('BusetaBodegaBundle:SalidaBodega:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SalidaBodega entity.
     *
     * @param SalidaBodega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SalidaBodega $entity)
    {
        $form = $this->createForm(new SalidaBodegaType(), $entity, array(
            'action' => $this->generateUrl('salidabodega_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SalidaBodega entity.
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $paginator = $this->get('knp_paginator');

        $productos = $paginator->paginate(
            $productos,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        $entity = new SalidaBodega();

        $salidabodegasProductos = new SalidaBodegaProducto();
        $salidabodegasProductos = $this->createForm(new SalidaBodegaProductoType());

        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:SalidaBodega:new.html.twig', array(
            'entity' => $entity,
            'salidabodegasProductos' => $salidabodegasProductos->createView(),
            'productos' => $productos,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SalidaBodega entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:SalidaBodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalidaBodega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:SalidaBodega:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SalidaBodega entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:SalidaBodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalidaBodega entity.');
        }

        $salidabodegasProductos = $this->createForm(new SalidaBodegaProductoType());

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:SalidaBodega:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'salidabodegasProductos'   => $salidabodegasProductos->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a SalidaBodega entity.
     *
     * @param SalidaBodega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SalidaBodega $entity)
    {
        $form = $this->createForm('buseta_bodegabundle_salida_bodega', $entity, array(
            'action' => $this->generateUrl('salidabodega_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing SalidaBodega entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:SalidaBodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalidaBodega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('salidabodega_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:SalidaBodega:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SalidaBodega entity.
     *
     * @Route("/{id}/delete", name="salidabodega_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(SalidaBodega $salidaBodega, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($salidaBodega->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($salidaBodega);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Salida Bodega'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/SalidaBodega/delete_modal.html.twig', array(
            'entity' => $salidaBodega,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('salidabodega'));
    }

    /**
     * Creates a form to delete a SalidaBodega entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('salidabodega_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
