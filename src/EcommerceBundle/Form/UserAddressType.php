<?php

namespace EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class UserAddressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('phone', TextType::class, ['label' => 'Téléphone'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('postcode', TextType::class, ['label' => 'Code Postal'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('country', TextType::class, ['label' => 'Pays'])
            ->add('complement', null, ['required' => false]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'EcommerceBundle\Entity\UserAddress',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ecommercebundle_useraddress';
    }


}
