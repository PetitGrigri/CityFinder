<?php

namespace CityFinderBundle\Controller;


use CityFinderBundle\Form\SearchType;

trait SearchControllerTraits
{
    /**
     * @param $recherche
     * @return string
     */
    public function queryBuilder($recherche)
    {
        $query = '';
        $queryBegin = 'MATCH (c:Commune) WHERE true ';
        $queryEnd = 'RETURN c LIMIT 501'; //

        //gestion des centrales
        if (isset($recherche['centrales'])) {
            switch ($recherche['centrales']) {
                case SearchType::CENTRALES_MORE_THAN_20:
                    $query.='AND NOT (c)-[:NEAR_20KM_FROM]->(:Centrale) ';
                    break;
                case SearchType::CENTRALES_MORE_THAN_30:
                    $query.='AND NOT (c)-[:NEAR_30KM_FROM]->(:Centrale) ';
                    break;
                case SearchType::CENTRALES_MORE_THAN_80:
                    $query.='AND NOT (c)-[:NEAR_80KM_FROM]->(:Centrale) ';
                    break;
            }
        }

        //gestion des musees
        if ((isset($recherche['musees'])) && ($recherche['musees'] == SearchType::MUSEES_NEEDED)) {
            $query .= 'AND (c)<-[:LOCATED_IN]-(:Musee) ';
        }

        //gestion des musees
        if ((isset($recherche['hotels'])) && ($recherche['hotels'] == SearchType::HOTELS_NEEDED)) {
            $query .= 'AND (c)<-[:LOCATED_IN]-(:Hotel) ';
        }

        //gestion des musees
        if (isset($recherche['postes'])) {
            switch ($recherche['postes']) {
                case SearchType::POSTES_NEEDED:
                    $query .= 'AND (c)<-[:LOCATED_IN]-(:AgencePostale) ';
                    break;
            }
        }

        //gestion des département
        if (isset($recherche['code_departement'])) {
            $query .= 'AND c.codeDepartement = "'.$recherche['code_departement'].'" ';
        }

        //gestion des régions
        if (isset($recherche['code_region'])) {
            $query .= 'AND c.codeRegion = '.$recherche['code_region'].' ';
        }

        return $queryBegin.$query.$queryEnd;

    }
}