<?php

namespace App\Form\Site;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adhesion', TextType::class, [
                'label' => 'Adhésion'
            ])
            ->add('donation', TextType::class, [
                'label' => 'Don'
            ])
            ->add('podcastLink', TextType::class, [
                'label' => 'Podcasts'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
