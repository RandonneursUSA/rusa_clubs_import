<?php

namespace Drupal\rusa_clubs_import;

class rusaStatesBuild {

    /**
     * List the states
     * not including other areas that exist in rusa db
     */    
   
    public function getStates() {
        $states = [];
        $states['AK'] = ['name' => 'Alaska', 'code' => '02'];
        $states['AL'] = ['name' => 'Alabama', 'code' => '01'];
        $states['AR'] = ['name' => 'Arkansas', 'code' => '04'];
        $states['AZ'] = ['name' => 'Arizona', 'code' => '03'];
        $states['CA'] = ['name' => 'California', 'code' => '05'];
        $states['CO'] = ['name' => 'Colorado', 'code' => '06'];
        $states['CT'] = ['name' => 'Connecticut', 'code' => '07'];
        $states['DC'] = ['name' => 'D.C.', 'code' => '51'];
        $states['DE'] = ['name' => 'Delaware', 'code' => '08'];
        $states['FL'] = ['name' => 'Florida', 'code' => '09'];
        $states['GA'] = ['name' => 'Georgia', 'code' => '10'];
        $states['HI'] = ['name' => 'Hawaii', 'code' => '11'];
        $states['IA'] = ['name' => 'Iowa', 'code' => '15'];
        $states['ID'] = ['name' => 'Idaho', 'code' => '12'];
        $states['IL'] = ['name' => 'Illinois', 'code' => '13'];
        $states['IN'] = ['name' => 'Indiana', 'code' => '14'];
        $states['KS'] = ['name' => 'Kansas', 'code' => '16'];
        $states['KY'] = ['name' => 'Kentucky', 'code' => '17'];
        $states['LA'] = ['name' => 'Louisiana', 'code' => '18'];
        $states['MA'] = ['name' => 'Massachusetts', 'code' => '21'];
        $states['MD'] = ['name' => 'Maryland', 'code' => '20'];
        $states['ME'] = ['name' => 'Maine', 'code' => '19'];
        $states['MI'] = ['name' => 'Michigan', 'code' => '22'];
        $states['MN'] = ['name' => 'Minnesota', 'code' => '23'];
        $states['MO'] = ['name' => 'Missouri', 'code' => '25'];
        $states['MS'] = ['name' => 'Missisippi', 'code' => '24'];
        $states['MT'] = ['name' => 'Montana', 'code' => '26'];
        $states['NC'] = ['name' => 'North Carolina', 'code' => '33'];
        $states['ND'] = ['name' => 'North Dakota', 'code' => '34'];
        $states['NE'] = ['name' => 'Nebraska', 'code' => '27'];
        $states['NH'] = ['name' => 'New Hampshire', 'code' => '29'];
        $states['NJ'] = ['name' => 'New Jersey', 'code' => '30'];
        $states['NM'] = ['name' => 'New Mexico', 'code' => '31'];
        $states['NV'] = ['name' => 'Nevada', 'code' => '28'];
        $states['NY'] = ['name' => 'New York', 'code' => '32'];
        $states['OH'] = ['name' => 'Ohio', 'code' => '35'];
        $states['OK'] = ['name' => 'Oklahoma', 'code' => '36'];
        $states['OR'] = ['name' => 'Oregon', 'code' => '37'];
        $states['PA'] = ['name' => 'Pennsylvania', 'code' => '38'];
        $states['RI'] = ['name' => 'Rhode Island', 'code' => '39'];
        $states['SC'] = ['name' => 'South Carolina', 'code' => '40'];
        $states['SD'] = ['name' => 'South Dakota', 'code' => '41'];
        $states['TN'] = ['name' => 'Tennessee', 'code' => '42'];
        $states['TX'] = ['name' => 'Texas', 'code' => '43'];
        $states['UT'] = ['name' => 'Utah', 'code' => '44'];
        $states['VA'] = ['name' => 'Virginia', 'code' => '46'];
        $states['VT'] = ['name' => 'Vermont', 'code' => '45'];
        $states['WA'] = ['name' => 'Washington', 'code' => '47'];
        $states['WI'] = ['name' => 'Wisconsin', 'code' => '49'];
        $states['WV'] = ['name' => 'West Virginia', 'code' => '48'];
        $states['WY'] = ['name' => 'Wyoming', 'code' => '50'];

        return $states;
    }
}
