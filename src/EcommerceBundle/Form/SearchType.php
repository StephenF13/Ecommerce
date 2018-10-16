<?php

namespace EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder->add('search', TextType::class, [
            'label' => false,
            'attr'  => ['class' => 'input-medium search-query'],
        ]);
    }

    public function getName()
    {
        return 'ecommercebundle_search';
    }
}
