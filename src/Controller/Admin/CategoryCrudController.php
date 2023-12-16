<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('createdAt');
        $name = TextField::new('name');

        if (in_array($pageName, [Crud::PAGE_INDEX, Crud::PAGE_DETAIL], true)) {
            return [$id, $name, $createdAt, $updatedAt];
        }

        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [$name];
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
