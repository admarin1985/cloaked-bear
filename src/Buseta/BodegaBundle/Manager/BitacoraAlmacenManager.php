<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\InputStack;
use Buseta\BodegaBundle\Entity\OutputStack;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Buseta\BodegaBundle\BusetaBodegaMovementTypes;

class BitacoraAlmacenManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param ValidatorInterface $validator
     */
    function __construct(ObjectManager $em, Logger $logger, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    public function createRegistry(BitacoraEventModel $model, $flush=false)
    {
        try {
            $fe = new FuncionesExtras();
            if($fe->movementTypeComparePlus($model->getMovementType()) && $model->getMovementType() != BusetaBodegaMovementTypes::MOVEMENT_TO){
                $registry = new BitacoraAlmacen();
                $registry->setAlmacen($model->getWarehouse());
                $registry->setProducto($model->getProduct());
                $registry->setFechaMovimiento($model->getMovementDate());
                $registry->setCantidadMovida($model->getMovementQty());
                $registry->setTipoMovimiento($model->getMovementType());
                $registry->setPrecioUnitario($model->getPrecioUnitario());
                if ($model->getQuantityOrder()) {
                    $registry->setCantidadOrden($model->getQuantityOrder());
                }
                if ($model->getCallback() !== null) {
                    call_user_func($model->getCallback(), $registry);
                }
                $this->em->persist($registry);

                $inputStackRegistry = new InputStack();
                $inputStackRegistry->setBitacora($registry);
                $inputStackRegistry->setQuantity($model->getMovementQty());
                $inputStackRegistry->setRemainingQuantity($model->getMovementQty());
                $this->em->persist($inputStackRegistry);

                if ($flush) {
                    $this->em->flush();
                }

                $model->setBitacoraLine($registry);
            }
            else{
                $bodega = $model->getWarehouse();
                if($model->getMovementType() === BusetaBodegaMovementTypes::MOVEMENT_TO){
                    $bodega = $model->getFromWarehouse();
                }
                $entradas = $fe->getEntradasDisponiblesProductoBodegaFIFO($model->getProduct(), $bodega, $model->getMovementQty(), $model->getMovementType(), $this->em);
                $costo = 0;
                $registry = null;
                foreach($entradas as $entrada){
                    if($costo != $entrada['costo']){
                        $costo = $entrada['costo'];
                        $registry = new BitacoraAlmacen();
                        $registry->setAlmacen($model->getWarehouse());
                        $registry->setProducto($model->getProduct());
                        $registry->setFechaMovimiento($model->getMovementDate());
                        $registry->setCantidadMovida($entrada['cantidad']);
                        $registry->setTipoMovimiento($model->getMovementType());
                        $registry->setPrecioUnitario($costo);
                        if ($model->getQuantityOrder()) {
                            $registry->setCantidadOrden($model->getQuantityOrder());
                        }
                        if ($model->getCallback() !== null) {
                            call_user_func($model->getCallback(), $registry);
                        }
                        $this->em->persist($registry);
                    }
                    else{
                        $registry->setCantidadMovida($registry->getCantidadMovida() + $entrada['cantidad']);
                    }

                    if ($fe->movementTypeCompareMinus($model->getMovementType())) {
                        //$registry->setCantidadMovida($entrada['cantidad']);
                        $outputStackRegistry = new OutputStack();
                        $outputStackRegistry->setBitacora($registry);
                        $outputStackRegistry->setQuantity($entrada['cantidad']);
                        $outputStackRegistry->setInputStack($entrada['inputStack']);
                        $this->em->persist($outputStackRegistry);
                    }
                    else{
                        $inputStackRegistry = new InputStack();
                        $inputStackRegistry->setBitacora($registry);
                        $inputStackRegistry->setQuantity($model->getMovementQty());
                        $inputStackRegistry->setRemainingQuantity($model->getMovementQty());
                        $this->em->persist($inputStackRegistry);
                    }
                    if ($flush) {
                        $this->em->flush();
                    }

                    $model->setBitacoraLine($registry);
                }
            }

            return true;
        } catch(\Exception $e) {
            $this->logger->critical(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));

            return false;
        }
    }

    public function legacyCreateRegistry(BitacoraAlmacen $bitacora)
    {
        try {
            //el validator valida por los assert de la entity
            $validationOrigen = $this->validator->validate($bitacora);
            if ($validationOrigen->count() === 0) {
                $this->em->persist($bitacora);

                return true;
            } else {
                $errors = '';
                foreach ($validationOrigen->getIterator() as $param => $error) {
                    $errors .= sprintf('%s: %s. ', $param, $error);
                }
                $this->logger->error(sprintf('BitacoraAlmacen.Validation: %s', $errors));

                return false;
            }
        } catch (\Exception $e) {
            $this->logger->error(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));
            //hacer rollback en el futuro
            return false;
        }
    }
}
