<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Press;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => new NotBlank(['message' => 'Le titre ne peut pas être vide'])
            ])
            ->add('date', TextType::class, [
                'label' => 'Date (optionnel)',
                'required' => false
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien (optionnel)',
                'required' => false
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Afficher le podcast en position',
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
            'data_class' => Press::class,
        ]);
    }
}
