<?php

namespace Buseta\BodegaBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Buseta\BodegaBundle\Form\Model\BitacoraAlmacenFilterModel;

/**
 * BitacoraAlmacenRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BitacoraAlmacenRepository extends EntityRepository
{

    public function filter(BitacoraAlmacenFilterModel $filter = null)
    {
        $qb = $this->createQueryBuilder('p');
        $query = $qb->where($qb->expr()->eq(true,true));

        if($filter) {
            if ($filter->getProducto() !== null && $filter->getProducto() !== '') {
                $query->andWhere($query->expr()->eq('p.producto', ':producto'))
                    ->setParameter('producto', $filter->getProducto());
            }
            if ($filter->getCategoriaProd() !== null && $filter->getCategoriaProd() !== '') {
                $query->andWhere($query->expr()->eq('p.categoriaProducto', ':categoriaprod'))
                    ->setParameter('categoriaprod', $filter->getCategoriaProd());
            }
            if ($filter->getAlma() !== null && $filter->getAlma() !== '') {
                $query->andWhere($qb->expr()->eq('p.almacen',':alma'))
                    ->setParameter('alma',  $filter->getAlma() );
            }
            if ($filter->getFechaInicio() !== null && $filter->getFechaInicio() !== '') {
                $query->andWhere($qb->expr()->gte('p.fechaMovimiento',':fechaInicio'))
                    ->setParameter('fechaInicio', $filter->getFechaInicio());
            }
            if ($filter->getFechaFin() !== null && $filter->getFechaFin() !== '') {
                $query->andWhere($qb->expr()->lte('p.fechaMovimiento',':fechaFin'))
                    ->setParameter('fechaFin', $filter->getFechaFin());
            }
        }

        $query->orderBy('p.id', 'ASC');

        try {
            return $query->getQuery();
        } catch (NoResultException $e) {
            return array();
        }
    }



}
