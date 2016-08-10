<?php

namespace MRS\InventarioBundle\Form\Report;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PainelEquipamentoReportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoequipamento',EntityType::class,array('label'=>'Tipo de Componente',
                'mapped' => false,
                'attr'=>array('class'=>'input-sm'),
                'class' => 'MRS\InventarioBundle\Entity\Tipoequipamento',
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('TE')
                        ->orderBy('TE.descricao');
                }
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MRS\InventarioBundle\Entity\Tipoequipamento'
        ));
    }

    public function getBlockPrefix()
    {
        return 'painel_equipamento';
    }
}
