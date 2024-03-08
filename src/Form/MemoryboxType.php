<?php

namespace App\Form;

use App\Entity\Memorybox;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MemoryboxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => new NotBlank(['message' => 'Le titre ne peut pas être vide'])
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Sous-titre'
            ])
            ->add('firstText', TextareaType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('secondText', TextareaType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('media', MediaType::class, [
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Memorybox::class,
        ]);
    }
}
