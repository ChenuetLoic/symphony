<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ActorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('pathFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'label' => 'Image à télécharger'
            ])
            ->add('programs', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actor::class,
        ]);
    }
}
