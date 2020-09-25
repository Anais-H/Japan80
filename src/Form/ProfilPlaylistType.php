<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilPlaylistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'playlistLink',
                UrlType::class,
                [
                    'attr' => ['class' => 'profil-playlist-form-field', 'maxlength' => 200, 'placeholder' => 'L\'url de la vidéo/playlist Youtube'],
                    'required'   => false,
                    'empty_data' => '',

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
