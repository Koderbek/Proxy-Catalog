<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 27.09.2019
 * Time: 7:40
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class ImportCsvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'CSV-file',
            ])
        ;
    }
}