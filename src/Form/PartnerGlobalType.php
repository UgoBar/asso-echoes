<?php

namespace App\Form;

use App\Entity\PartnerGlobal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PartnerGlobalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subtitle', TextType::class, [
                'label' => 'Sous-titre',
                'required' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => new NotBlank(['message' => 'Le titre ne peut pas être vide'])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PartnerGlobal::class,
        ]);
    }
}
