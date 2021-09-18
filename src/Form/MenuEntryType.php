<?php

namespace App\Form;

use App\Entity\MenuEntry;
use App\Repository\MenuSectionRepository;
use ErrorException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuEntryType extends AbstractType
{
    private MenuSectionRepository $menuSectionRepository;

    public function __construct(MenuSectionRepository $menuSectionRepository)
    {
        $this->menuSectionRepository = $menuSectionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['required' => true])
            ->add('description', TextType::class, ['required' => true])
            ->add('price', NumberType::class, ['required' => true])
            ->add('quantity', IntegerType::class, ['required' => true])
            ->add('menuSectionId', TextType::class, ['required' => false, 'mapped' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MenuEntry::class,
            'csrf_protection' => false,
        ]);
    }
}
