<?php

namespace EcommerceBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use EcommerceBundle\Entity\VillesFranceFree;

class UserAddressType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('phone', TextType::class, ['label' => 'Téléphone'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('postcode', TextType::class,
                ['label' => 'Code Postal', 'attr' => ['class' => 'cp', 'maxlength' => 5]])
            ->add('city', ChoiceType::class, ['label' => 'Ville', 'attr' => ['class' => 'city']])
            ->add('country', TextType::class, ['label' => 'Pays'])
            ->add('complement', null, ['required' => false]);

        $formModifier = function (FormInterface $form, $cp) {
            $cityCp = $this->entityManager->getRepository(VillesFranceFree::class)->findBy(['villeCodePostal' => $cp]);

            if ($cityCp) {
                $cities = [];
                foreach ($cityCp as $city) {
                    $cities[] = $city->getVilleNom();
                }
            } else {
                $city = null;
            }

            $form->add('city', ChoiceType::class,
                ['label' => 'Ville', 'attr' => ['class' => 'city'], 'choices' => $cities]);
        };

        $builder->get('postcode')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $formModifier($event->getForm()->getParent(), $event->getForm()->getData());
            });

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
