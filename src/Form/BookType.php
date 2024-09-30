<?php

namespace App\Form;

use App\Entity\Authors;
use App\Entity\Books;
use App\Entity\Editors;
use App\Enum\BookStatus;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
            ])
            ->add('cover', TextType::class, [
                'label' => 'Image de couverture',
                'required' => false
            ])
            ->add('editedAt', DateType::class, [
                'label' => "Date d'édition",
                'widget' => 'single_text',
            ])
            ->add('plot', TextareaType::class, [
                'label' => 'Résumé',
            ])
            ->add('pageNumber', IntegerType::class, [
                'label' => 'Nombre de pages'
            ])
            ->add('status', EnumType::class, [
                'class'  => BookStatus::class,
                'label' => 'Statut',
                ])
            ->add('editor', EntityType::class, [
                'class' => Editors::class,
                'choice_label' => 'name',
            ])
            ->add('author', EntityType::class, [
                'class' => Authors::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
