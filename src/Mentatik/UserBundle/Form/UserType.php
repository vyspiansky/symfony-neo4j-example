<?php

namespace Mentatik\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

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
            );
    }
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'User';
    }

}