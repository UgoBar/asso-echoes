<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Podcast;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PodcastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subtitle')
            ->add('title', TextType::class, [
                'constraints' => new NotBlank(['message' => 'Le titre ne peut pas être vide'])
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Afficher la bannière en position',
                'required' => false
            ])
            ->add('media', MediaType::class, [
                'label' => false
            ])
//            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Podcast::class,
        ]);
    }
}
