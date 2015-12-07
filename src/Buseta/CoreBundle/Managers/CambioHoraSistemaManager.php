<?php

namespace Buseta\CoreBundle\Managers;

use Doctrine\ORM\EntityManager;

class CambioHoraSistemaManager
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return bool|\DateTime
     */
    public function getHoraCambio()
    {
        $horaCambioConfig = $this->em->getRepository('CoreBundle:CambioHoraSistema')
            ->findOneBy(array('activo', true));

        if ($horaCambioConfig !== null) {
            $horaCambio = $horaCambioConfig->getHora();
        } else {
            $horaCambio = date_create_from_format('H:i:s', '00:00:00');
        }

        return $horaCambio;
    }


}
