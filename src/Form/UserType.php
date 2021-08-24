<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName', Type\TextType::class)
            ->add('email', Type\EmailType::class)
            ->add('phone', Type\TelType::class)
            ->add('password', Type\RepeatedType::class , [
                'type' => Type\PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options'=> ['label' => 'Repeat Password']
            ] )
            ->add('terms' , CheckboxType::class, [
                'constraints' => [new Assert\IsTrue() ],
                'mapped' => false,
                'label' => 'Click here to indicate that you have read the terms of agreement',
                'help' => 'This is the help description'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
