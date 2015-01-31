<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


/**
 * PedidoCompraRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PedidoCompraRepository extends EntityRepository
{
    public function consecutivoLast()
    {
        $qb = $this->_em->createQueryBuilder();

        $q = $qb->select('p.consecutivo_compra')
            ->from('BusetaBodegaBundle:PedidoCompra', 'p')
            ->orderBy('p.consecutivo_compra','DESC')
            ->getQuery()
            ->setMaxResults(1);

        try {
            return $q->getSingleResult();
        } catch (NoResultException $e) {
            return false;
        }
    }

    public function busquedaAvanzada($page, $cantResult, $filter = array(), $orderBy = null) {
        $q = 'SELECT p FROM BusetaBodegaBundle:PedidoCompra p WHERE p.id != 0 AND p.deleted = false';

        //Obteniendo resto de la consulta dql
        $q.=$this->constructSubDQL($filter);

        //Estableciendo Order By
        if (empty($orderBy))
            $q.=' ORDER BY p.id DESC';
        else
            $q.= ' ORDER BY ' . $orderBy;

        $maxResult = $this->getNotDeletedMaxResult($filter);
        $firstResult = $page * $cantResult;

        if ($firstResult > $maxResult) {
            $firstResult = 0;
            $page = 0;
        }

        //Valores de navegación
        if($maxResult < $cantResult)
            $last = 0;
        elseif ($maxResult % $cantResult > 0)
            $last = floor($maxResult / $cantResult);
        else
            $last = floor($maxResult / $cantResult)-1;


        if($last < 0)
            $last = 0;
        $next = ($page != $last) ? true : false;
        $prev = ($page != 0) ? true : false;
        $first = ($page == 0) ? false : true;

        $query = $this->_em->createQuery($q);
        $query->setMaxResults($cantResult);
        $query->setFirstResult($firstResult);

        try {
            $results = $query->getResult();
            return array(
                'results' => $results,
                'paginacion' => array(
                    'next' => $next,
                    'prev' => $prev,
                    'first' => $first,
                    'last' => $last,
                ),
            );
        } catch (NoResultException $e) {
            return array(
                'results' => array(),
                'paginacion' => array(),
            );
        }
    }

    public function getNotDeletedMaxResult($filter) {
        $q = 'SELECT COUNT(p) FROM BusetaBodegaBundle:PedidoCompra p WHERE p.id != 0';
        $q.=$this->constructSubDQL($filter);

        $query = $this->_em->createQuery($q);
        try {
            return $query->getSingleScalarResult();
        } catch (NoResultException $e) {
            return false;
        }
    }

    public function constructSubDQL($filter) {
        $q = '';

        if (isset($filter['tercero']) && !empty($filter['tercero'])){

            $results = $this->_em->getRepository('BusetaBodegaBundle:Tercero')->searchByValor($filter['tercero']);

            if(count($results) !=0)
                $q.= " AND p.tercero = " . $results[0]->getId() . " ";
            else
                $q.= " AND p.tercero = -1 ";
        }

        if (isset($filter['almacen']) && !empty($filter['almacen'])){

            $results = $this->_em->getRepository('BusetaBodegaBundle:Bodega')->searchByValor($filter['almacen']);

            if(count($results) !=0)
                $q.= " AND p.almacen = " . $results[0]->getId() . " ";
            else
                $q.= " AND p.almacen = -1 ";
        }

        if (isset($filter['moneda']) && !empty($filter['moneda'])){

            $results = $this->_em->getRepository('BusetaNomencladorBundle:Moneda')->searchByValor($filter['moneda']);

            if(count($results) !=0)
                $q.= " AND p.moneda = " . $results[0]->getId() . " ";
            else
                $q.= " AND p.moneda = -1 ";
        }

        if (isset($filter['condiciones_pago']) && !empty($filter['condiciones_pago'])){

            $results = $this->_em->getRepository('BusetaTallerBundle:CondicionesPago')->searchByValor($filter['condiciones_pago']);

            if(count($results) !=0)
                $q.= " AND p.condiciones_pago = " . $results[0]->getId() . " ";
            else
                $q.= " AND p.condiciones_pago = -1 ";
        }

        if (isset($filter['importe_total_lineas']) && !empty($filter['importe_total_lineas']))
            $q.= " AND p.importe_total_lineas = ".$filter['importe_total_lineas']." ";

        if (isset($filter['importe_total']) && !empty($filter['importe_total']))
            $q.= " AND p.importe_total = ".$filter['importe_total']." ";

        if (isset($filter['numero_documento']) && !empty($filter['numero_documento']))
            $q.= " AND UPPER(p.numero_documento) LIKE '%" . strtoupper($filter['numero_documento']) . "%'";


        return $q;
    }
}
