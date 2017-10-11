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
    const MUSEES_NEEDED       = 1;
    const MUSEES_NEVER_MIND   = 0;

    //les valeurs  des informations prise en compte pour les hotels
    const HOTELS_NEEDED      = 1;
    const HOTELS_NEVER_MIND  = 0;

    //les valeurs  des informations prise en compte pour les agences postales
    const POSTES_NEEDED      = 1;
    const POSTES_NEVER_MIND  = 0;

    //les valeurs prise en compte pour les départements
    const DEPARTEMENT_AIN = "01";
    const DEPARTEMENT_AISNE = "02";
    const DEPARTEMENT_ALLIER = "03";
    const DEPARTEMENT_ALPES_DE_HAUTE_PROVENCE = "04";
    const DEPARTEMENT_HAUTES_ALPES = "05";
    const DEPARTEMENT_ALPES_MARITIMES = "06";
    const DEPARTEMENT_ARDECHE = "07";
    const DEPARTEMENT_ARDENNES = "08";
    const DEPARTEMENT_ARIEGE = "09";
    const DEPARTEMENT_AUBE = "10";
    const DEPARTEMENT_AUDE = "11";
    const DEPARTEMENT_AVEYRON = "12";
    const DEPARTEMENT_BOUCHES_DU_RHONE = "13";
    const DEPARTEMENT_CALVADOS = "14";
    const DEPARTEMENT_CANTAL = "15";
    const DEPARTEMENT_CHARENTE = "16";
    const DEPARTEMENT_CHARENTE_MARITIME = "17";
    const DEPARTEMENT_CHER = "18";
    const DEPARTEMENT_CORREZE = "19";
    const DEPARTEMENT_COTE_D_OR = "21";
    const DEPARTEMENT_COTES_D_ARMOR = "22";
    const DEPARTEMENT_CREUSE = "23";
    const DEPARTEMENT_DORDOGNE = "24";
    const DEPARTEMENT_DOUBS = "25";
    const DEPARTEMENT_DROME = "26";
    const DEPARTEMENT_EURE = "27";
    const DEPARTEMENT_EURE_ET_LOIR = "28";
    const DEPARTEMENT_FINISTERE = "29";
    const DEPARTEMENT_CORSE_DU_SUD = "2A";
    const DEPARTEMENT_HAUTE_CORSE = "2B";
    const DEPARTEMENT_GARD = "30";
    const DEPARTEMENT_HAUTE_GARONNE = "31";
    const DEPARTEMENT_GERS = "32";
    const DEPARTEMENT_GIRONDE = "33";
    const DEPARTEMENT_HERAULT = "34";
    const DEPARTEMENT_ILLE_ET_VILAINE = "35";
    const DEPARTEMENT_INDRE = "36";
    const DEPARTEMENT_INDRE_ET_LOIRE = "37";
    const DEPARTEMENT_ISERE = "38";
    const DEPARTEMENT_JURA = "39";
    const DEPARTEMENT_LANDES = "40";
    const DEPARTEMENT_LOIR_ET_CHER = "41";
    const DEPARTEMENT_LOIRE = "42";
    const DEPARTEMENT_HAUTE_LOIRE = "43";
    const DEPARTEMENT_LOIRE_ATLANTIQUE = "44";
    const DEPARTEMENT_LOIRET = "45";
    const DEPARTEMENT_LOT = "46";
    const DEPARTEMENT_LOT_ET_GARONNE = "47";
    const DEPARTEMENT_LOZERE = "48";
    const DEPARTEMENT_MAINE_ET_LOIRE = "49";
    const DEPARTEMENT_MANCHE = "50";
    const DEPARTEMENT_MARNE = "51";
    const DEPARTEMENT_HAUTE_MARNE = "52";
    const DEPARTEMENT_MAYENNE = "53";
    const DEPARTEMENT_MEURTHE_ET_MOSELLE = "54";
    const DEPARTEMENT_MEUSE = "55";
    const DEPARTEMENT_MORBIHAN = "56";
    const DEPARTEMENT_MOSELLE = "57";
    const DEPARTEMENT_NIEVRE = "58";
    const DEPARTEMENT_NORD = "59";
    const DEPARTEMENT_OISE = "60";
    const DEPARTEMENT_ORNE = "61";
    const DEPARTEMENT_PAS_DE_CALAIS = "62";
    const DEPARTEMENT_PUY_DE_DOME = "63";
    const DEPARTEMENT_PYRENEES_ATLANTIQUES = "64";
    const DEPARTEMENT_HAUTES_PYRENEES = "65";
    const DEPARTEMENT_PYRENEES_ORIENTALES = "66";
    const DEPARTEMENT_BAS_RHIN = "67";
    const DEPARTEMENT_HAUT_RHIN = "68";
    const DEPARTEMENT_RHONE = "69";
    const DEPARTEMENT_HAUTE_SAONE = "70";
    const DEPARTEMENT_SAONE_ET_LOIRE = "71";
    const DEPARTEMENT_SARTHE = "72";
    const DEPARTEMENT_SAVOIE = "73";
    const DEPARTEMENT_HAUTE_SAVOIE = "74";
    const DEPARTEMENT_PARIS = "75";
    const DEPARTEMENT_SEINE_MARITIME = "76";
    const DEPARTEMENT_SEINE_ET_MARNE = "77";
    const DEPARTEMENT_YVELINES = "78";
    const DEPARTEMENT_DEUX_SEVRES = "79";
    const DEPARTEMENT_SOMME = "80";
    const DEPARTEMENT_TARN = "81";
    const DEPARTEMENT_TARN_ET_GARONNE = "82";
    const DEPARTEMENT_VAR = "83";
    const DEPARTEMENT_VAUCLUSE = "84";
    const DEPARTEMENT_VENDEE = "85";
    const DEPARTEMENT_VIENNE = "86";
    const DEPARTEMENT_HAUTE_VIENNE = "87";
    const DEPARTEMENT_VOSGES = "88";
    const DEPARTEMENT_YONNE = "89";
    const DEPARTEMENT_TERRITOIRE_DE_BELFORT = "90";
    const DEPARTEMENT_ESSONNE = "91";
    const DEPARTEMENT_HAUTS_DE_SEINE = "92";
    const DEPARTEMENT_SEINE_SAINT_DENIS = "93";
    const DEPARTEMENT_VAL_DE_MARNE = "94";
    const DEPARTEMENT_VAL_D_OISE = "95";
    const DEPARTEMENT_GUADELOUPE = "97";
    const DEPARTEMENT_GUYANE = "97";
    const DEPARTEMENT_MARTINIQUE = "97";
    const DEPARTEMENT_MAYOTTE = "97";
    const DEPARTEMENT_REUNION = "97";


    //les valeurs prise en compte pour les régions
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
                'required'      => false,
                'placeholder'   => false,
                'multiple'      => false,
                'expanded'      => true,
                'choices'       => [
                    "Située à plus de 20km"     => self::CENTRALES_MORE_THAN_20,
                    "Située à plus de 30km"     => self::CENTRALES_MORE_THAN_30,
                    "Située à plus de 80km"     => self::CENTRALES_MORE_THAN_80,
                    "Indifférent"               => self::CENTRALES_NEVER_MIND,
                ]
            ])
            ->add('musees', ChoiceType::class, [
                'required'      => false,
                'placeholder'   => false,
                'multiple'      => false,
                'expanded'      => true,
                'choices'       => [
                    "Avec des musées"   => self::MUSEES_NEEDED,
                    "Indifférent"       => self::MUSEES_NEVER_MIND,
                ]
            ])
            ->add('hotels', ChoiceType::class, [
                'required'      => false,
                'placeholder'   => false,
                'multiple'      => false,
                'expanded'      => true,
                'choices'       => [
                    "Avec des hotels"   => self::HOTELS_NEEDED,
                    "Indifférent"       => self::HOTELS_NEVER_MIND,
                ]
            ])
            ->add('postes', ChoiceType::class, [
                'required'      => false,
                'placeholder'   => false,
                'multiple'      => false,
                'expanded'      => true,
                'choices'       => [
                    "Avec des agences postales"    => self::POSTES_NEEDED,
                    "Indifférent"                  => self::POSTES_NEVER_MIND,
                ]
            ])
            //TODO : utiliser un référentiel
            ->add('code_departement', ChoiceType::class, [
                'required'      => false,
                'placeholder'   => 'Choisissez un département',
                'choices'       => [
                    "AIN" 						=> self::DEPARTEMENT_AIN,
                    "AISNE" 					=> self::DEPARTEMENT_AISNE,
                    "ALLIER" 					=> self::DEPARTEMENT_ALLIER,
                    "ALPES DE HAUTE PROVENCE"   => self::DEPARTEMENT_ALPES_DE_HAUTE_PROVENCE,
                    "HAUTES ALPES"              => self::DEPARTEMENT_HAUTES_ALPES,
                    "ALPES MARITIMES"           => self::DEPARTEMENT_ALPES_MARITIMES,
                    "ARDECHE"                   => self::DEPARTEMENT_ARDECHE,
                    "ARDENNES"                  => self::DEPARTEMENT_ARDENNES,
                    "ARIEGE"                    => self::DEPARTEMENT_ARIEGE,
                    "AUBE"                      => self::DEPARTEMENT_AUBE,
                    "AUDE"                      => self::DEPARTEMENT_AUDE,
                    "AVEYRON"                   => self::DEPARTEMENT_AVEYRON,
                    "BOUCHES DU RHONE"          => self::DEPARTEMENT_BOUCHES_DU_RHONE,
                    "CALVADOS"                  => self::DEPARTEMENT_CALVADOS,
                    "CANTAL"                    => self::DEPARTEMENT_CANTAL,
                    "CHARENTE"                  => self::DEPARTEMENT_CHARENTE,
                    "CHARENTE MARITIME"         => self::DEPARTEMENT_CHARENTE_MARITIME,
                    "CHER"                      => self::DEPARTEMENT_CHER,
                    "CORREZE"                   => self::DEPARTEMENT_CORREZE,
                    "COTE D'OR"                 => self::DEPARTEMENT_COTE_D_OR,
                    "COTES D'ARMOR"             => self::DEPARTEMENT_COTES_D_ARMOR,
                    "CREUSE"                    => self::DEPARTEMENT_CREUSE,
                    "DORDOGNE"                  => self::DEPARTEMENT_DORDOGNE,
                    "DOUBS"                     => self::DEPARTEMENT_DOUBS,
                    "DROME"                     => self::DEPARTEMENT_DROME,
                    "EURE"                      => self::DEPARTEMENT_EURE,
                    "EURE ET LOIR"              => self::DEPARTEMENT_EURE_ET_LOIR,
                    "FINISTERE"                 => self::DEPARTEMENT_FINISTERE,
                    "CORSE DU SUD"              => self::DEPARTEMENT_CORSE_DU_SUD,
                    "HAUTE CORSE"               => self::DEPARTEMENT_HAUTE_CORSE,
                    "GARD"                      => self::DEPARTEMENT_GARD,
                    "HAUTE GARONNE"             => self::DEPARTEMENT_HAUTE_GARONNE,
                    "GERS"                      => self::DEPARTEMENT_GERS,
                    "GIRONDE"                   => self::DEPARTEMENT_GIRONDE,
                    "HERAULT"                   => self::DEPARTEMENT_HERAULT,
                    "ILLE ET VILAINE"           => self::DEPARTEMENT_ILLE_ET_VILAINE,
                    "INDRE"                     => self::DEPARTEMENT_INDRE,
                    "INDRE ET LOIRE"            => self::DEPARTEMENT_INDRE_ET_LOIRE,
                    "ISERE"                     => self::DEPARTEMENT_ISERE,
                    "JURA"                      => self::DEPARTEMENT_JURA,
                    "LANDES"                    => self::DEPARTEMENT_LANDES,
                    "LOIR ET CHER"              => self::DEPARTEMENT_LOIR_ET_CHER,
                    "LOIRE"                     => self::DEPARTEMENT_LOIRE,
                    "HAUTE LOIRE"               => self::DEPARTEMENT_HAUTE_LOIRE,
                    "LOIRE ATLANTIQUE"          => self::DEPARTEMENT_LOIRE_ATLANTIQUE,
                    "LOIRET"                    => self::DEPARTEMENT_LOIRET,
                    "LOT"                       => self::DEPARTEMENT_LOT,
                    "LOT ET GARONNE"            => self::DEPARTEMENT_LOT_ET_GARONNE,
                    "LOZERE"                    => self::DEPARTEMENT_LOZERE,
                    "MAINE ET LOIRE"            => self::DEPARTEMENT_MAINE_ET_LOIRE,
                    "MANCHE"                    => self::DEPARTEMENT_MANCHE,
                    "MARNE"                     => self::DEPARTEMENT_MARNE,
                    "HAUTE MARNE"               => self::DEPARTEMENT_HAUTE_MARNE,
                    "MAYENNE"                   => self::DEPARTEMENT_MAYENNE,
                    "MEURTHE ET MOSELLE"        => self::DEPARTEMENT_MEURTHE_ET_MOSELLE,
                    "MEUSE"                     => self::DEPARTEMENT_MEUSE,
                    "MORBIHAN"                  => self::DEPARTEMENT_MORBIHAN,
                    "MOSELLE"                   => self::DEPARTEMENT_MOSELLE,
                    "NIEVRE"                    => self::DEPARTEMENT_NIEVRE,
                    "NORD"                      => self::DEPARTEMENT_NORD,
                    "OISE"                      => self::DEPARTEMENT_OISE,
                    "ORNE"                      => self::DEPARTEMENT_ORNE,
                    "PAS DE CALAIS"             => self::DEPARTEMENT_PAS_DE_CALAIS,
                    "PUY DE DOME"               => self::DEPARTEMENT_PUY_DE_DOME,
                    "PYRENEES ATLANTIQUES"      => self::DEPARTEMENT_PYRENEES_ATLANTIQUES,
                    "HAUTES PYRENEES"           => self::DEPARTEMENT_HAUTES_PYRENEES,
                    "PYRENEES ORIENTALES"       => self::DEPARTEMENT_PYRENEES_ORIENTALES,
                    "BAS RHIN"                  => self::DEPARTEMENT_BAS_RHIN,
                    "HAUT RHIN"                 => self::DEPARTEMENT_HAUT_RHIN,
                    "RHONE"                     => self::DEPARTEMENT_RHONE,
                    "HAUTE SAONE"               => self::DEPARTEMENT_HAUTE_SAONE,
                    "SAONE ET LOIRE"            => self::DEPARTEMENT_SAONE_ET_LOIRE,
                    "SARTHE"                    => self::DEPARTEMENT_SARTHE,
                    "SAVOIE"                    => self::DEPARTEMENT_SAVOIE,
                    "HAUTE SAVOIE"              => self::DEPARTEMENT_HAUTE_SAVOIE,
                    "PARIS"                     => self::DEPARTEMENT_PARIS,
                    "SEINE MARITIME"            => self::DEPARTEMENT_SEINE_MARITIME,
                    "SEINE ET MARNE"            => self::DEPARTEMENT_SEINE_ET_MARNE,
                    "YVELINES"                  => self::DEPARTEMENT_YVELINES,
                    "DEUX SEVRES"               => self::DEPARTEMENT_DEUX_SEVRES,
                    "SOMME"                     => self::DEPARTEMENT_SOMME,
                    "TARN"                      => self::DEPARTEMENT_TARN,
                    "TARN ET GARONNE"           => self::DEPARTEMENT_TARN_ET_GARONNE,
                    "VAR"                       => self::DEPARTEMENT_VAR,
                    "VAUCLUSE"                  => self::DEPARTEMENT_VAUCLUSE,
                    "VENDEE"                    => self::DEPARTEMENT_VENDEE,
                    "VIENNE"                    => self::DEPARTEMENT_VIENNE,
                    "HAUTE VIENNE"              => self::DEPARTEMENT_HAUTE_VIENNE,
                    "VOSGES"                    => self::DEPARTEMENT_VOSGES,
                    "YONNE"                     => self::DEPARTEMENT_YONNE,
                    "TERRITOIRE DE BELFORT"     => self::DEPARTEMENT_TERRITOIRE_DE_BELFORT,
                    "ESSONNE"                   => self::DEPARTEMENT_ESSONNE,
                    "HAUTS DE SEINE"            => self::DEPARTEMENT_HAUTS_DE_SEINE,
                    "SEINE SAINT DENIS"         => self::DEPARTEMENT_SEINE_SAINT_DENIS,
                    "VAL DE MARNE"              => self::DEPARTEMENT_VAL_DE_MARNE,
                    "VAL D'OISE"                => self::DEPARTEMENT_VAL_D_OISE,
                    "GUADELOUPE"                => self::DEPARTEMENT_GUADELOUPE,
                    "GUYANE"                    => self::DEPARTEMENT_GUYANE,
                    "MARTINIQUE"                => self::DEPARTEMENT_MARTINIQUE,
                    "MAYOTTE"                   => self::DEPARTEMENT_MAYOTTE,
                    "REUNION"                   => self::DEPARTEMENT_REUNION,
                ]
            ])
            //TODO : utiliser un référentiel
            ->add('code_region', ChoiceType::class, [
                'required'  => false,
                'placeholder'   => 'Choisissez une région',
                'choices'  => [
                    "SAINT_PIERRE_ET_MIQUELON"      => self::REGION_SAINT_PIERRE_ET_MIQUELON,
                    "GUADELOUPE"                    => self::REGION_GUADELOUPE,
                    "MARTINIQUE"                    => self::REGION_MARTINIQUE,
                    "GUYANE"                        => self::REGION_GUYANE,
                    "REUNION"                       => self::REGION_REUNION,
                    "MAYOTTE"                       => self::REGION_MAYOTTE,
                    "ILE-DE-FRANCE"                 => self::REGION_ILE_DE_FRANCE,
                    "CHAMPAGNE-ARDENNE"             => self::REGION_CHAMPAGNE_ARDENNE,
                    "PICARDIE"                      => self::REGION_PICARDIE,
                    "HAUTE-NORMANDIE"               => self::REGION_HAUTE_NORMANDIE,
                    "CENTRE"                        => self::REGION_CENTRE,
                    "BASSE-NORMANDIE"               => self::REGION_BASSE_NORMANDIE,
                    "BOURGOGNE"                     => self::REGION_BOURGOGNE,
                    "NORD-PAS-DE-CALAIS"            => self::REGION_NORD_PAS_DE_CALAIS,
                    "LORRAINE"                      => self::REGION_LORRAINE,
                    "ALSACE"                        => self::REGION_ALSACE,
                    "FRANCHE-COMTE"                 => self::REGION_FRANCHE_COMTE,
                    "PAYS DE LA LOIRE"              => self::REGION_PAYS_DE_LA_LOIRE,
                    "BRETAGNE"                      => self::REGION_BRETAGNE,
                    "POITOU-CHARENTES"              => self::REGION_POITOU_CHARENTES,
                    "AQUITAINE"                     => self::REGION_AQUITAINE,
                    "MIDI-PYRENEES"                 => self::REGION_MIDI_PYRENEES,
                    "LIMOUSIN"                      => self::REGION_LIMOUSIN,
                    "RHONE-ALPES"                   => self::REGION_RHONE_ALPES,
                    "AUVERGNE"                      => self::REGION_AUVERGNE,
                    "LANGUEDOC-ROUSSILLON"          => self::REGION_LANGUEDOC_ROUSSILLON,
                    "PROVENCE-ALPES-COTE D'AZUR"    => self::REGION_PROVENCE_ALPES_COTE_D_AZUR,
                    "CORSE"                         => self::REGION_CORSE,
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