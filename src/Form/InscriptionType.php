<?php

namespace App\Form;

use App\Entity\User;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;



class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',textType::class, 
            [
                'constraints'=>new Length(
                    min:2,
                    max: 30,
                    minMessage:'Votre Nom doit contenir au moins {{ limit }} caractères',
                    maxMessage:'Votre Nom doit contenir au maximum {{ limit }} caractères',

                ),
                'attr'=>['placeholder'=>'Veuillez saisir votre nom']])
            ->add('firstname',textType::class,
            [                   
                'constraints'=>new Length(
                    min:2,
                    max: 30,
                    minMessage:'Votre Prénom doit contenir au moins {{ limit }} caractères',
                    maxMessage:'Votre Prénom doit contenir au maximum {{ limit }} caractères',
                ),
                'attr'=>['placeholder'=>'Veuillez saisir votre prénom']])
            ->add('email',EmailType::class,
            [
                'constraints'=>new Length(
                    min:5,
                    max: 40,
                    minMessage:'Votre Email doit contenir au {{ limit }} caractères',
                    maxMessage:'Votre Email doit contenir au maximum {{ limit }} caractères',
                ),
                'attr'=>['placeholder'=>'Veuillez saisir votre Email']])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Password',
                'attr'=>['placeholder'=>'Veuillez saisir votre mot de passe']],
                'second_options' => ['label' => 'Repeat Password',
                'attr'=>['placeholder'=>'Veuillez confirmer votre mot de passe']],
            ])
            ->add('submit',SubmitType::class,
            ['label'=>"S'inscrire"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

