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
    //les valeurs  des informations prises en compte pour les centrales
    const CENTRALES_MORE_THAN_20 = 1;
    const CENTRALES_MORE_THAN_30 = 2;
    const CENTRALES_MORE_THAN_80 = 3;
    const CENTRALES_NEVER_MIND   = 0;

    //les valeurs  des informations prise en compte pour les musées
    const MUSEES_NEEDED      = 1;
    const MUSEES_NVER_MIND   = 0;

    //les valeurs  des informations prise en compte pour les hotels
    const HOTELS_NEEDED      = 1;
    const HOTELS_NEVER_MIND  = 0;

    //les valeurs  des informations prise en compte pour les agences postales
    const POSTES_NEEDED      = 1;
    const POSTES_NEVER_MIND  = 0;

    //les valeurs prise en compte pour les départements
    const DEPARTEMENT_AISNE                     = "02";
    const DEPARTEMENT_HAUTES_ALPES              = "05";
    const DEPARTEMENT_AIN                       = "01";
    const DEPARTEMENT_ALPES_MARITIMES           = "06";
    const DEPARTEMENT_ALLIER                    = "03";
    const DEPARTEMENT_ARDENNES                  = "08";
    const DEPARTEMENT_ARDECHE                   = "07";
    const DEPARTEMENT_ALPES_DE_HAUTE_PROVENCE   = "04";
    const DEPARTEMENT_ARIEGE                    = "09";
    const DEPARTEMENT_CHARENTE_MARITIME         = "17";
    const DEPARTEMENT_BOUCHES_DU_RHONE          = "13";
    const DEPARTEMENT_CHER                      = "18";
    const DEPARTEMENT_CALVADOS                  = "14";
    const DEPARTEMENT_CHARENTE                  = "16";
    const DEPARTEMENT_CORREZE                   = "19";
    const DEPARTEMENT_AVEYRON                   = "12";
    const DEPARTEMENT_AUDE                      = "11";
    const DEPARTEMENT_AUBE                      = "10";
    const DEPARTEMENT_DROME                     = "26";
    const DEPARTEMENT_EURE                      = "27";
    const DEPARTEMENT_EURE_ET_LOIR              = "28";
    const DEPARTEMENT_HAUTE_CORSE               = "2B";
    const DEPARTEMENT_COTE_D_OR                 = "21";
    const DEPARTEMENT_DOUBS                     = "25";
    const DEPARTEMENT_CREUSE                    = "23";
    const DEPARTEMENT_DORDOGNE                  = "24";
    const DEPARTEMENT_COTES_D_ARMOR             = "22";
    const DEPARTEMENT_FINISTERE                 = "29";
    const DEPARTEMENT_HERAULT                   = "34";
    const DEPARTEMENT_HAUTE_GARONNE             = "31";

    //les valeurs prise en compte pour les départements
    const REGION_SAINT_PIERRE_ET_MIQUELON   = 0;
    const REGION_GUADELOUPE                 = 1;
    const REGION_MARTINIQUE                 = 2;
    const REGION_GUYANE                     = 3;
    const REGION_REUNION                    = 4;
    const REGION_MAYOTTE                    = 6;
    const REGION_ILE_DE_FRANCE              = 11;
    const REGION_CHAMPAGNE_ARDENNE          = 21;
    const REGION_PICARDIE                   = 22;
    const REGION_HAUTE_NORMANDIE            = 23;
    const REGION_CENTRE                     = 24;
    const REGION_BASSE_NORMANDIE            = 25;
    const REGION_BOURGOGNE                  = 26;
    const REGION_NORD_PAS_DE_CALAIS         = 31;
    const REGION_LORRAINE                   = 41;
    const REGION_ALSACE                     = 42;
    const REGION_FRANCHE_COMTE              = 43;
    const REGION_PAYS_DE_LA_LOIRE           = 52;
    const REGION_BRETAGNE                   = 53;
    const REGION_POITOU_CHARENTES           = 54;
    const REGION_AQUITAINE                  = 72;
    const REGION_MIDI_PYRENEES              = 73;
    const REGION_LIMOUSIN                   = 74;
    const REGION_RHONE_ALPES                = 82;
    const REGION_AUVERGNE                   = 83;
    const REGION_LANGUEDOC_ROUSSILLON       = 91;
    const REGION_PROVENCE_ALPES_COTE_D_AZUR = 93;
    const REGION_CORSE                      = 94;




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
            ->add('code_departement', ChoiceType::class, [
                'required'  => false,
                'choices'  => [
                    self::DEPARTEMENT_AISNE,
                    self::DEPARTEMENT_HAUTES_ALPES,
                    self::DEPARTEMENT_AIN,
                    self::DEPARTEMENT_ALPES_MARITIMES,
                    self::DEPARTEMENT_ALLIER,
                    self::DEPARTEMENT_ARDENNES,
                    self::DEPARTEMENT_ARDECHE,
                    self::DEPARTEMENT_ALPES_DE_HAUTE_PROVENCE,
                    self::DEPARTEMENT_ARIEGE,
                    self::DEPARTEMENT_CHARENTE_MARITIME,
                    self::DEPARTEMENT_BOUCHES_DU_RHONE,
                    self::DEPARTEMENT_CHER,
                    self::DEPARTEMENT_CALVADOS,
                    self::DEPARTEMENT_CHARENTE,
                    self::DEPARTEMENT_CORREZE,
                    self::DEPARTEMENT_AVEYRON,
                    self::DEPARTEMENT_AUDE,
                    self::DEPARTEMENT_AUBE,
                    self::DEPARTEMENT_DROME,
                    self::DEPARTEMENT_EURE,
                    self::DEPARTEMENT_EURE_ET_LOIR,
                    self::DEPARTEMENT_HAUTE_CORSE,
                    self::DEPARTEMENT_COTE_D_OR,
                    self::DEPARTEMENT_DOUBS,
                    self::DEPARTEMENT_CREUSE,
                    self::DEPARTEMENT_DORDOGNE,
                    self::DEPARTEMENT_COTES_D_ARMOR,
                    self::DEPARTEMENT_FINISTERE,
                    self::DEPARTEMENT_HERAULT,
                    self::DEPARTEMENT_HAUTE_GARONNE,
                ]
            ])
            ->add('code_region', ChoiceType::class, [
                'required'  => false,
                'choices'  => [
                    self::REGION_SAINT_PIERRE_ET_MIQUELON,
                    self::REGION_GUADELOUPE,
                    self::REGION_MARTINIQUE,
                    self::REGION_GUYANE,
                    self::REGION_REUNION,
                    self::REGION_MAYOTTE,
                    self::REGION_ILE_DE_FRANCE,
                    self::REGION_CHAMPAGNE_ARDENNE,
                    self::REGION_PICARDIE,
                    self::REGION_HAUTE_NORMANDIE,
                    self::REGION_CENTRE,
                    self::REGION_BASSE_NORMANDIE,
                    self::REGION_BOURGOGNE,
                    self::REGION_NORD_PAS_DE_CALAIS,
                    self::REGION_LORRAINE,
                    self::REGION_ALSACE,
                    self::REGION_FRANCHE_COMTE,
                    self::REGION_PAYS_DE_LA_LOIRE,
                    self::REGION_BRETAGNE,
                    self::REGION_POITOU_CHARENTES,
                    self::REGION_AQUITAINE,
                    self::REGION_MIDI_PYRENEES,
                    self::REGION_LIMOUSIN,
                    self::REGION_RHONE_ALPES,
                    self::REGION_AUVERGNE,
                    self::REGION_LANGUEDOC_ROUSSILLON,
                    self::REGION_PROVENCE_ALPES_COTE_D_AZUR,
                    self::REGION_CORSE,
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