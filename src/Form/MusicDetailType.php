<?php

namespace App\Form;

use App\Entity\MusicDetail;
use App\Entity\Podcast;
use App\Validator\UniqueSlug;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Unique;


class MusicDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => new NotBlank(['message' => 'Le titre ne peut pas être vide'])
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('youtubeLink', TextType::class, [
                'label' => 'ID de la vidéo youtube (optionnel)',
                'required' => false
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Afficher la rencontre en position',
                'required' => false
            ])
            ->add('date', TextType::class, [
                'label' => 'Date',
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu',
            ])
            ->add('collaborator', TextType::class, [
                'label' => 'Collaborateur',
            ])
            ->add('artist', TextType::class, [
                'label' => 'Artiste',
            ])
            ->add('podcast', EntityType::class, [
                // looks for choices from this entity
                'class' => Podcast::class,
                // uses the Podcast.title property as the visible option string
                'choice_label' => 'title',
                'choice_translation_domain' => false,
                'multiple' => false,
                'required' => false,
                'label' => 'Lier un podcast',
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'constraints' => new UniqueSlug()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MusicDetail::class,
        ]);
    }
}
