<?php
namespace CityFinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\PasswordTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    const CENTRALES_MORE_THAN_20 = 1;
    const CENTRALES_MORE_THAN_30 = 2;
    const CENTRALES_MORE_THAN_80 = 3;
    const CENTRALES_NEVER_MIND   = 0;

    const MUSEES_NEEDED      = 1;
    const MUSEES_NVER_MIND   = 0;

    const HOTELS_NEEDED      = 1;
    const HOTELS_NEVER_MIND  = 0;

    const POSTES_NEEDED      = 1;
    const POSTES_NEVER_MIND  = 0;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('centrales', ChoiceType::class, [
                'required'  => false,
                'choices'  => [
                    self::CENTRALES_MORE_THAN_20,
                    self::CENTRALES_MORE_THAN_30,
                    self::CENTRALES_MORE_THAN_80,
                    self::CENTRALES_NEVER_MIND,
                ]
            ])
            ->add('musees', ChoiceType::class, [
                'required'  => false,
                'choices'  => [
                    self::MUSEES_NEEDED,
                    self::MUSEES_NVER_MIND,
                ]
            ])
            ->add('hotels', ChoiceType::class, [
                'required'  => false,
                'choices'  => [
                    self::HOTELS_NEEDED,
                    self::HOTELS_NEVER_MIND,
                ]
            ])
            ->add('postes', ChoiceType::class, [
                'required'  => false,
                'choices'  => [
                    self::POSTES_NEEDED,
                    self::POSTES_NEVER_MIND,
                ]
            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection'   => false
        ]);
    }
}