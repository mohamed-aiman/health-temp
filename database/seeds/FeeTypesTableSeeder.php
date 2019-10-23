<?php

use App\FeeType;
use Illuminate\Database\Seeder;

class FeeTypesTableSeeder extends Seeder
{
    public function run()
    {

        $feeTypes = [
            [
                'reference' => '380-R/2014',
                'description' => 'އިތުރުވާ ކޮންމެ ސާރވިންގ އޭރިއާއަކަށް -/ 100ރ',
                'amount' => 100,
                'calculation_strategy' => null,
            ],
            [
                'reference' => '380-R/2014',
                'description' => 'އިތުރުވާ ކޮންމެ ބަދިގެ އަކަށް -/100ރ',
                'amount' => 100,
                'calculation_strategy' => null,
            ],
            [
                'reference' => '380-R/2014',
        		'description' => 'ސީޓިންގގެ އަދަދަށް ބަލައި އިތުރު ކުރަންޖެހޭ ވަރު (އަގު ކަނޑައަޅާފައިވަނީ 50 (ފަންސާސް) ގޮނޑިއަށް) (އިތުރުވާ ކޮންމެ 50 (ފަންސާސް) ގޮނޑިއަކަށް -/100ރ)',
        		'amount' => 100,
                'calculation_strategy' => 'for_each_extra_50_mvr_100',
            ],
            [
                'reference' => '380-R/2014',
                'description' => 'ހުއްދަ ގެއްލިގެން އައުކުރުން/ ހުއްދަ ހަލާކުވެގެން އައުކުރަން (ހުއްދަ އަށް ނަގާ ފީގެ %50)',
                'amount' => null,
                'calculation_strategy' => 'half_of_registration_fee',
            ],
            [
                'reference' => '380-R/2014',
                'description' => 'ލޭޓް އެންޓްރީ ފީ (1 މަސްކުރިން ހުއްދަ އާކުރަން -/1000ރ ހުށަނާޅައިފިނަމަ ޖޫރިމަނާގެ ގޮތުގައި ނަގާ ފީ)',
                'amount' => 1000,
                'calculation_strategy' => null,
            ],

        ];

        $feeTypeModel = new FeeType;
        foreach ($feeTypes as $feeType) {
        	$feeTypeModel->create($feeType);
        }
    }
}
