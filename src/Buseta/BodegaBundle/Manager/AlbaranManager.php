<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Event\FilterAlbaranEvent;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;

/**
 * Class AlbaranManager
 *
 * @package Buseta\BodegaBundle\Manager
 */
class AlbaranManager extends AbstractBodegaManager
{
    /**
     * Process Albaran instance
     *
     * @param Albaran $albaran
     *
     * @return bool|string
     */
    public function procesar(Albaran $albaran)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::ALBARAN_PRE_PROCESS)) {
                $preProcessEvent = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(BusetaBodegaEvents::ALBARAN_PRE_PROCESS, $preProcessEvent);

                if ($preProcessEvent->getError()) {
                    $error = $preProcessEvent->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($albaran, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::ALBARAN_POST_PROCESS)) {
                $postProcessEvent = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(BusetaBodegaEvents::ALBARAN_POST_PROCESS, $postProcessEvent);

                if ($postProcessEvent->getError()) {
                    $error = $postProcessEvent->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                // Try and commit the transaction, aqui puede ocurrir un error
                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Orden de Entrada no procesada debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf(
                    'Ha ocurrido un error al completar Orden de Entrada. Detalles: {message: %s, class: %s, line: %d}',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );
        }

        $this->rollbackTransaction();

        return false;
    }

    /**
     * Set albaran status as Completed
     *
     * @param Albaran $albaran
     *
     * @return bool
     */
    public function completar(Albaran $albaran)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::ALBARAN_PRE_COMPLETE)) {
                $preCompleteEvent = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(BusetaBodegaEvents::ALBARAN_PRE_COMPLETE, $preCompleteEvent);

                if ($preCompleteEvent->getError()) {
                    $error = $preCompleteEvent->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($albaran, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_COMPLETE, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::ALBARAN_POST_COMPLETE)) {
                $posCompleteEvent = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(BusetaBodegaEvents::ALBARAN_POST_COMPLETE, $posCompleteEvent);

                if ($posCompleteEvent->getError()) {
                    $error = $posCompleteEvent->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                // Try and commit the transaction, aqui puede ocurrir un error
                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Orden de Entrada no completada debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->critical(
                sprintf(
                    'Ha ocurrido un error al completar Orden de Entrada. Detalles: {message: %s, class: %s, line: %d}',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );
        }

        $this->rollbackTransaction();

        return false;
    }

    /**
     * Rollback document status to draft
     *
     * @param Albaran $albaran
     *
     * @return bool|string
     */
    public function revertir(Albaran $albaran)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($albaran->getEstadoDocumento() !== BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS) {
                $this->logger->error(
                    sprintf(
                        'El estado de Orden Entrada con id %d no se corresponde con el estado previo para revertir.',
                        $albaran->getId()
                    )
                );

                throw new NotValidStateException();
            }

            // Change state Borrador(PR) to Procesado(BO)
            $this->cambiarEstado($albaran, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_DRAFT, $error);

            if (!$error) {
                $this->em->flush();

                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf(
                'No se ha podido revertir Orden de Entrada a su anterior estado debido a errores previos: %s',
                $error
            ));
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf(
                    'Ha ocurrido un error al revertir Orden Entrada desde estado %s. Detalles: {message: %s, class: %s, line: %d}',
                    $e->getMessage()
                )
            );
        }

        $this->rollbackTransaction();

        return false;
    }

    /**
     * Change Albaran document status
     *
     * @param Albaran $albaran
     * @param string $estado
     * @param boolean|string $error
     *
     * @return bool|string
     */
    private function cambiarEstado(Albaran $albaran, $estado, &$error)
    {
        try {
            $albaran->setEstadoDocumento($estado);
            //$this->em->persist($albaran);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->critical(
                sprintf('Ha ocurrido un error al cambiar estado de la Orden de Entrada. Detalles: %s', $e->getMessage())
            );

            $error = 'Ha ocurrido un error al cambiar estado de la Orden de Entrada.';

            return false;
        }
    }
}
