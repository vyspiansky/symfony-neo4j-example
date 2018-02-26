<?php

namespace Mentatik\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

// use Mentatik\UserBundle\Model\Ship;
use Mentatik\UserBundle\Model\User;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => new Length(['max' => 100]),
            ])
            ->add('email', EmailType::class, [
                    'constraints' => new Length(['max' => 300]),
                    'required' => true,
                ]
            )
//            ->add(
//                'shipsCollection', 'ShipType',
//                [
//                    'class' => 'Ship',
//                    'property' => 'title',
//                    'multiple' => TRUE,
//                    'expanded' => TRUE,
//                    'label' => 'Ships',
//                    // 'disabled' => !$this->loggedInUser->isAdmin(),
//                ]
//            )

            ->add('ships', CollectionType::class, array(
                'entry_type' => ShipType::class,
                'entry_options' => array('label' => false),
                //'allow_add' => true,
            ))

        ;
    }
    /**
     * @return string
     */
//    public function getBlockPrefix()
//    {
//        return 'User';
//    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

}