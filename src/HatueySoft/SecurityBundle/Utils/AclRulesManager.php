<?php

namespace HatueySoft\SecurityBundle\Utils;


use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Exception\DumpException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class AclRulesManager
{
    /**
     * @var string
     */
    private $aclConfigFile;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    private $aclManager;

    const ACL_CONFIG_FILE = '/../Resources/config/security_acl.yml';

    function __construct(ContainerInterface $container)
    {
        $this->aclConfigFile    = __DIR__.AclRulesManager::ACL_CONFIG_FILE;
        $this->logger           = $container->get('logger');
    }

    /**
     * Devuelve el arreglo con las reglas de ACL
     *
     * @return bool|mixed
     */
    public function getSecurityAcl()
    {
        if (!$this->checkConfigFile()) {
            return false;
        }

        try {
            $aclRules = Yaml::parse(file_get_contents($this->aclConfigFile));

            return $aclRules;
        } catch (ParseException $e) {
            $this->logger->addCritical(sprintf('No es posible parsear el archivo YAML: %s', $e->getMessage()));

            return false;
        }
    }

    /**
     * Establece el arreglo con las reglas de ACL
     *
     * @param array $aclRules
     * @return bool
     */
    public function setSecurityAcl($aclRules)
    {
        if (!$this->checkConfigFile()) {
            return false;
        }

        try {
            $yaml = Yaml::dump($aclRules,3,2);

            file_put_contents($this->aclConfigFile, $yaml);

            return true;
        } catch(DumpException $e) {
            $this->logger->addCritical(printf('No es posible escribir sobre el archivo YAML: %s', $e->getMessage()));

            return false;
        }
    }

    /**
     * Devuelve el arreglo de entidades y sus direcciones.
     *
     * @return array
     */
    static final function getEntities()
    {
        return array(
            array('name' => 'empleado', 'path' => 'Planillas\CoreBundle\Entity\CEmpleado'),
        );
    }

    public function getEntity($entity)
    {
        foreach ($this->getEntities() as $value) {
            if ($value['name'] === $entity || $value['path'] === $entity) {
                return $value;
            }
        }

        return false;
    }

    /**
     * Comprueba la existencia del fichero de configuración, en caso de no existir intenta crearlo.
     *
     * @return bool
     */
    private function checkConfigFile()
    {
        if (!file_exists($this->aclConfigFile)) {
            $this->logger->addInfo(sprintf('No se encuentra creado el archivo %s.', $this->aclConfigFile));

            if ($file = fopen($this->aclConfigFile,'w')) {
                fclose($file);
            } else {
                $this->logger->addCritical(sprintf('No se puede crear el archivo %s.', $this->aclConfigFile));

                return false;
            }
        }

        return true;
    }

    /**
     * Retorna un arreglo con las debidas reglas de ACL. Falso en caso de no encontrar reglas algunas.
     *
     * @param $entity
     * @return bool|array
     */
    public function getEntityRule($entity)
    {
        $rules = $this->getSecurityAcl();

        if (!$rules) {
            return false;
        }

        foreach ($rules as $value) {
            $entityData = $this->getEntity($entity);
            if ($value['entity'] === $entity || $value['entity'] === $entityData['path']) {
                return $value;
            }
        }

        return false;
    }

    public function setEntityRule($entity, $roles = array(), $users = array())
    {
        $rule = $this->getEntityRule($entity);
        $entities = $this->getEntities();

        if (!$rule) {
            $rule = array(
                'entity'    => $entities[$entity],
                'roles'     => $roles,
                'users'     => $users,
            );
        } else {
            $rule['roles'] = $roles;
            $rule['users'] = $users;
        }

        $allRules = $this->getSecurityAcl();
        $flag = false;
        foreach ($allRules as $key => $value) {
            $entityData = $this->getEntity($entity);
            if ($value['entity'] === $entity || $value['entity'] === $entityData['path']) {
                $allRules[$key] = $rule;
                $flag = true;
                break;
            }
        }

        if(!$flag) {
            $allRules[] = $rule;
        }

        $this->setSecurityAcl($allRules);
    }
} 