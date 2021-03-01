<?php

namespace App\Services;

class FraisService {

    public function getFrais($montant){
        $tab_montant_max = [5000,10000,15000,20000,50000,60000,75000,120000,150000,200000,250000,300000,400000,750000,900000,1000000,1125000,2000000];
        $tab_frais = [425,850,1270,1695,2500,3000,4000,5000,6000,7000,8000,9000,12000,15000,22000,25000,27000,30000,];

        for($i=0; $i<count($tab_montant_max); $i++){
            if($montant<=$tab_montant_max[$i]){
                return $tab_frais[$i];
            }
            if ($montant>=2000000) {
                return $montant*0.02;
            }
        }
    }
}