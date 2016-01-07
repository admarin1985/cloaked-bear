<?php

namespace Buseta\TallerBundle\Manager;

use Buseta\TallerBundle\Entity\Reporte;
use Buseta\TallerBundle\Entity\TareaDiagnostico;
use Buseta\TallerBundle\Entity\TareaAdicional;
use Buseta\TallerBundle\Entity\Diagnostico;
use Buseta\TallerBundle\Entity\OrdenTrabajo;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class DiagnosticoManager
 * @package Buseta\TallerBundle\Manager
 */
class DiagnosticoManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;


    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param Session $session
     */
    function __construct(ObjectManager $em, Logger $logger, Session $session)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->session = $session;
    }

    /**
     * Crea un diagnostico a partir de un reporte
     *
     * @param Reporte $reporte
     * @return Boolean resultado
     */
    public function crearDiagnostico(Reporte $reporte)
    {
        try {
            //Crear nuevo Diagnostico a partir del Reporte seleccionado
            $diagnostico = new Diagnostico();
            $diagnostico->setNumero( $reporte->getNumero() );
            $diagnostico->setReporte($reporte);
            $diagnostico->setAutobus($reporte->getAutobus());
            $diagnostico->setCancelado(false);

            $this->em->persist($diagnostico);
            $this->em->flush();

            $this->session->getFlashBag()->add('success', sprintf('Se ha creado el Diagnóstico %s de forma satisfactoria.', $diagnostico->getNumero()));

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Diagnostico.Persist: %s', $e->getMessage()));

            return false;
        }
    }

    /**
     *
     * @param diagnostico $diagnostico
     * @param string $estado
     */
    public function cambiarEstado( Diagnostico $diagnostico , $estado = 'BO' )
    {
        //Cambia el estado
        $diagnostico->setEstado($estado);

        $this->em->persist($diagnostico);
        $this->em->flush();
    }

    public function cambiarCancelado( Diagnostico $diagnostico)
    {
        try{
            $cancelado = $diagnostico->getCancelado();
            if($cancelado === false){
                $diagnostico->setCancelado(true);
                $diagnostico->setEstado('CL');

                $this->em->persist($diagnostico);
                $this->em->flush();
            }

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Diagnostico.Persist: %s', $e->getMessage()));

            return false;
        }


    }

}
