<?php

namespace Mentatik\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Mentatik\UserBundle\Model\Ship;

class ShipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => new Length(['max' => 100]),
            ]);
    }
    /**
     * @return string
     */
//    public function getBlockPrefix()
//    {
//        return 'Ship';
//    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ship::class,
        ));
    }

}