<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_en')
            ->add('prenom_en')
            ->add('nom_ben')
            ->add('prenom_ben')
            ->add('date_trans')
            ->add('CIN_en')
            ->add('CIN_ben')
            ->add('code')
            ->add('montant')
            ->add('envoie')
            ->add('retrait')
            ->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
