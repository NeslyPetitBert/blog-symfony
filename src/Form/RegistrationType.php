<?php

namespace App\Form;

use App\Entity\User;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, $this->getFormConf(true, 'Email', 'Votre adresse email'))
            ->add('username', TextType::class, $this->getFormConf(true, 'Nom d\'utilisateur', 'Votre nom d\'utilisateur'))
            ->add('hash', PasswordType::class, $this->getFormConf(true, 'Mot de passe', 'Choisissez votre mot de passe'))
            ->add('confirmPassword', PasswordType::class, $this->getFormConf(true, 'Confirmation du mot de passe', 'Répétez votre mot de passe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
