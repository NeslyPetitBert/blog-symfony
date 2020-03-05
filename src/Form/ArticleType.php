<?php

namespace App\Form;

use App\Entity\Article;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getFormConf(true, 'Titre', 'Titre de l\'article'))
            ->add('content', TextareaType::class, $this->getFormConf(true, 'Contenu', 'Détails de l\'article'))
            ->add('picture', TextType::class, $this->getFormConf(true, 'Image', 'Image de l\'article'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
