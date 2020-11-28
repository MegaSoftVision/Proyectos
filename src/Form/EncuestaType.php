<?php

namespace App\Form;

use App\Entity\Encuesta;
use App\Entity\CategoriaEncuesta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EncuestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	
      	$user=$options['data'];

        $builder
            ->add('descripcion')
          	->add('banner',FileType::class, [
              'constraints' => [
                      new File([
                          'maxSize' => '5024k',
                          'mimeTypesMessage' => 'Tamaño Maximo Permitido 5024K',
                          'mimeTypes' => [
                              
                              'image/jpeg',
                            'image/jpg',
                              'image/png',
                        
                          ],
                          'mimeTypesMessage' => 'Solo se permiten formatos:',
                      ])
                  ],
                  "data_class" => null,
           

            ])
         
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Encuesta::class,
        ]);
    }
}
