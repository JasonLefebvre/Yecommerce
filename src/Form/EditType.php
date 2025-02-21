<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom de l\'article', 'required' => false])
            ->add('description', TextareaType::class, ['label' => 'Description de l\'article', 'required' => false])
            ->add('prix', MoneyType::class, ['label' => 'Prix de l\'article', 'required' => false])
            ->add('picture', FileType::class, ['label' => 'Image de l\'article', 'mapped' => false,  'required' => false])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer']);
    }
    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}