<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 20/03/15
 * Time: 0:56.
 */

namespace Buseta\UploadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UploadResourcesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'label' => false,
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\UploadBundle\Entity\UploadResources',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_uploadbundle';
    }
}
