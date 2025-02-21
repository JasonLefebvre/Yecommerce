<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Adresse de facturation
            ->add('adresseFacturation', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre adresse complète',
                ],
                'label' => 'Adresse de Facturation',
            ])

            // Ville de facturation
            ->add('villeFacturation', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre ville',
                ],
                'label' => 'Ville de Facturation',
            ])

            // Code Postal de facturation
            ->add('codePostalFacturation', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre code postal',
                ],
                'label' => 'Code Postal de Facturation',
            ])

            // Bouton de soumission
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary btn-lg mt-3'],
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
