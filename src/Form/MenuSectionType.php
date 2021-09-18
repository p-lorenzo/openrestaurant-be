<?php

namespace App\Form;

use App\Entity\MenuSection;
use App\Repository\MenuRepository;
use ErrorException;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuSectionType extends AbstractType
{
    private MenuRepository $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['required' => true])
            ->add('sorting', IntegerType::class, ['required' => true])
            ->add('menuId', TextType::class, ['required' => false, 'mapped' => false])
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            [$this, 'setDefaultValues']
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MenuSection::class,
            'csrf_protection' => false,
        ]);
    }

    public function setDefaultValues(FormEvent $event)
    {   
        $activeMenu = $this->menuRepository->findActive();
        if (empty($activeMenu)) {
            throw new ErrorException("Nessun menu attivo trovato", 404);
        }
        $section = $event->getData();
        $section->setMenu($activeMenu);
        $event->setData($section);
    }
}
