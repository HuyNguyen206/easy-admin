<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $uploadPath = $this->getParameter('upload_path');
        $id = IdField::new('id');

        $imageFile =  TextField::new('imageFile', 'Image')
            ->setFormType(VichImageType::class);

        $imageName = ImageField::new('imageName', 'Image')
            ->setBasePath($uploadPath);

        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $name = TextField::new('name');
        $category = AssociationField::new('category')->autocomplete();

        if ($pageName === Crud::PAGE_INDEX) {
            return [$id, $name, $category, $createdAt, $updatedAt, $imageName];
        }

        if ($pageName === Crud::PAGE_DETAIL) {
            return [$id, $name, $category, $createdAt, $updatedAt, $imageName];
        }

        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [$name, $category,  $imageFile];
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setFormOptions( ['validation_groups' => ['new', 'Default']], ['validation_groups' => ['Default']] );
}
}
