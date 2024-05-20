<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{
    // добавить нового юзера
    protected function configureFormFields(FormMapper $form): void
    {
        // $form->add('id', TextType::class) // Эту строку нужно удалить или закомментировать
        $form->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', TextType::class)
            ->add('phone', TextType::class)
            ->add('logo', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('phone')
            ->add('logo');
    }
   // страница таблицы сущностей
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id', null, ['editable' => false])
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('roles')
            ->add('phone')
            ->add('logo');
    }
    // страница сущности
    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('roles')
            ->add('phone')
            ->add('logo');
    }
}