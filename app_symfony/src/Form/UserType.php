<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Conversation;
use App\Entity\Skill;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "attr" => ['placeholder' => 'Votre email']
            ])
            ->add('lastname', TextType::class, [
                "attr" => ['placeholder' => 'Votre nom']
            ])
            ->add('firstname', TextType::class, [
                "attr" => ['placeholder' => 'Votre prénom']
            ])
            ->add('picture' , FileType::class, [
                "attr" => ['placeholder' => 'Votre photo'],
                "mapped" => false,
                "required" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
