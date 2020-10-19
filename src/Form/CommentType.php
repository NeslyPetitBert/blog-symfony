<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class, $this->getFormConf(true, 'Auteur', 'Nom de l\'auteur'))
            ->add('content', TextareaType::class, $this->getFormConf(true, 'Contenu', 'Contenu de l\'article'))
            // ->add('createdAt')
            // ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
