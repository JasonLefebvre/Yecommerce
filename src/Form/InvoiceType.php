<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('adresseFacturation', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Adresse de Facturation',
            ])
            ->add('villeFacturation', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Ville de Facturation',
            ])
            ->add('codePostalFacturation', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Code Postal de Facturation',
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
                'label' => 'Valider la Facture',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
