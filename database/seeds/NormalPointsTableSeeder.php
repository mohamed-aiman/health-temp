<?php

use App\NormalCategory;
use App\NormalPoint;
use Illuminate\Database\Seeder;

class NormalPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = [
			['text' => '1. ހުއްދަ / ދަރަޖަ ކާޑު', 'order' => 1],
			['text' => '2. ސަރަޙައްދު', 'order' => 2],
			['text' => '3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް', 'order' => 3],
			['text' => '4. ކާބޯތަކެތި ގެންގުޅުމާއި ފޯރުކޮށް ދިނުން', 'order' => 4],
			['text' => '5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން', 'order' => 5],
			['text' => '6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް', 'order' => 6],
			['text' => '7.ޖަނަވާރާއި ސޫފާސޫފި ކޮންޓްރޯލް ކުރުން', 'order' => 7],
			['text' => '8.ކާބޯތަކެތި ރައްކާކުރާ ތަން', 'order' => 8],
			['text' => '9.ކާބޯތަކެތި ތަޢައްޔަރުވާނެ ނުރައްކަލެއް ހުރިތޯ ބެލުން', 'order' => 9],
			['text' => '10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން', 'order' => 10],
			['text' => '11.ކާބޯތަކެތި އެއްތަނުން އަނެއްތަނަށް އުފުލުމާއި ގެންދިއުން', 'order' => 11],
			['text' => '12', 'order' => 12],
			['text' => '13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން', 'order' => 13],
			['text' => '14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް ', 'order' => 14],
    	];

        $fields = [
["no"=> "1.1", "code" => "CR", "text" => "ހުއްދައިގެ މުއްދަތު ހަމަނުވޭ", "group" => "1. ހުއްދަ / ދަރަޖަ ކާޑު"],
["no"=> "1.2", "code" => "MJ", "text" => "ހުއްދަ އާންމުންނަށް ފެންނަ ހިސާބެއްގައި ބެހެއްޓިފައި", "group" => "1. ހުއްދަ / ދަރަޖަ ކާޑު"],
["no"=> "1.3", "code" => "MJ", "text" => "ދަރަޖަ ކާޑު އާންމުންނަށް ފެންނަ ހިސާބެއްގައި ބެހެއްޓިފައިފައި", "group" => "1. ހުއްދަ / ދަރަޖަ ކާޑު"],
["no"=> "2.1", "code" => "MN", "text" => "ކާބޯތަކެތީގެ ޙިދުމަތްދޭ ތަން ވަށައިގެންވާ މާހައުލު ރަނގަޅަށް ސާފުކުރެވިފައި. (ވަންނަ ދޮރުމަތި އަދި ވަށައިގެންވާ ސަރަހައްދު ސާފުކުރެވިފައި)", "group" => "2. ސަރަޙައްދު"],
["no"=> "3.1", "code" => "MN ", "text" => "ސާރވިންގ އޭރިއާ ގައި އެކަށީގެންވާ އަދަދަކަށް އަތް ނުލާ ހުޅުވޭ ފަދަ މަތިޖެހި ޑަސްޓްބިން ބެހެއްޓިފައި ހުރުން", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.1", "code" => "MN ", "text" => "ގޮނޑި މޭޒު ހުރީ ރަނގަޅަށް މަރާމާތުކޮށް ސާފުކޮށް ބެލެހެއްޓިފައި           ", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.2", "code" => "MN", "text" => "ތަޅުންގަނޑު ހުރީ ރަނގަޅަށް ސާފުކުރެވި ޖަރާސީމު ފިލުވިފައި، އަދި ތަޅުންމަތި ސާފުތާހިރުކޮށް ހުރުން ", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.3", "code" => "MN ", "text" => "ފާރުތައް: ފެންހަރުނުލާ ގޮތަށް ސާފުތާހިރުކޮށް ފަސޭހައިން ސާފުކުރެވޭ ގޮތަށް ހެދިފައި", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.4", "code" => "MN ", "text" => "ތަނުގެ އަލި: ކާބޯތަކެތީގެ އަސްލު ކުލަ ނޯޅޭ ގޮތަށް ބޮކި އަލި/ގުދުރަތީ އަލި ލިބޭގޮތަށް ހެދިފައި", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.5", "code" => "MJ", "text" => "ސީލިންގް ކުރެވިފައިވާ ނަމަ ސީލިންގް އިން ކުނޑިފަދަ ތަކެތި ނުފައިބާ ގޮތަށްހެދިފައި", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.6", "code" => "MN", "text" => "ސީލިންގް ނުކޮށް ހުރި އޯޕަން ސާރވިންގް އޭރިޔާ އެއް ނަމަ އެތަނުގެ ސާރވިންގް އޭރިޔާގައި ހުރި މޭޒުތަކާއި ދިމާލަށް ކުޑަ ބެހެއްޓިފައި/  މޭޒުތަކާއި ދިމާލުން މަތި ހިޔާ ކުރެވިފައި", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.7", "code" => "MN", "text" => "ކަސްޓަމަރުންގެ އަތްދޮވުމަށް ސިންކެއް ބެހެއްޓިފައި ", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.8", "code" => "MJ", "text" => "ސާރވިންގް އޭރިއާގައި ކާބޯތަކެތި ބަހައްޓާ ޝޯކޭހެއް ހުރި ނަމަ ޝޯކޭސް ހުރީ ރަނގަޅަށް ސާފުކުރެވިފައި އަދި ރަނގަޅަށް ބަންދުކުރެވި، ކާބޯތަކެތި ރައްކާތެރި ކަމާއެކު ބެހެއްޓިފައި", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "3.9", "code" => "MJ", "text" => "ޝޯކޭހުގައި ލައިޓެއް ވާނަމަ ލައިޓް ތަޅައިގެން ނުދާ ގޮތަށް/ ޝޭޓާރ ޕްރޫފް ކޮށްފައި ", "group" => "3. ސާރވިންގ އޭރިއާ-ސްޓަރަކްޗަރ އެންޑް މެއިންޓަނަންސް"],
["no"=> "4.1", "code" => "MJ", "text" => "ސެލްފް ސާރވިސް – ކޮންމެ ބާވަތެއްގެ ކާއެއްޗެއް ނެގުމަށް ސާފު ޓޮންގްސް/އޫ/ސަމުސާ ބެހެއްޓިފައި", "group" => "4. ކާބޯތަކެތި ގެންގުޅުމާއި ފޯރުކޮށް ދިނުން"],
["no"=> "4.2", "code" => "MJ", "text" => "ކާއެއްޗެހި ބަހައްޓާފައި ހުރީ މަތިޖެހޭގޮތަށް ރައްކާތެރި ކަމާއެކު ހުރި ކަންވާރުގައި / ލެއްޕޭ ގޮތަށް ހުންނަ ކަބަޑު / ރެކުގައި", "group" => "4. ކާބޯތަކެތި ގެންގުޅުމާއި ފޯރުކޮށް ދިނުން"],
["no"=> "4.3", "code" => "MJ", "text" => "ސާރވްކުރާ މުވައްޒަފުން ކާ އެއްޗެހި ނެގުމަށް އަންގި ނުވަތަ ޓޮންގްސް/އޫ/ސަމުސާ ބޭނުން ކުރުން ", "group" => "4. ކާބޯތަކެތި ގެންގުޅުމާއި ފޯރުކޮށް ދިނުން"],
["no"=> "4.4", "code" => "MN", "text" => "އިކުއިޕްމަންޓްތަށް އަދި ހިފާ ގެންގުޅޭ ސާމާނު ބެހެއްޓިފައި ހުރީ ރައްކާ ތެރިކޮށް", "group" => "4. ކާބޯތަކެތި ގެންގުޅުމާއި ފޯރުކޮށް ދިނުން"],
["no"=> "5.1", "code" => "MN", "text" => "ތަޅުންގަނޑު: ތަޅުންގަނޑު ހުރީ ރަނގަޅަށް ސާފުކުރެވި ޖަރާސީމު ފިލުވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.2", "code" => "MN", "text" => "ތަނުގެ ޖާގަ: ކާބޯތަކެތީގެ މަސައްކަތްކުރާ ތަނުގައި އެކަށީގެންވާ ވަރުގެ ޖާގަ އޮތް ތަނެއް ކަމުގައި ވުން/ ތައްޔާރުކުރުމަށައި، ސްޓޯރ ކުރުމަށާއި، މުވައްޒަފުން ނަށް ތަނުގެ ތެރޭގައި ފަސޭހައިން މަސައްކަތް ކުރެވޭ ވަރުގެ ޖާގަ އޮތުން", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.3", "code" => "MJ", "text" => "ފެން ހިންދާ ވަޅުގަނޑު: ސިންކު ހޮޅި/ ގުލީ ލީކު ނުވާ ގޮތަށް ބެލެހެއްޓިފައި (މެޝިނަރީސް އެންޑް އިކުއިޕްމަންޓްސް ގެ ވޭސްޓް ޕައިޕް ލައިންތައް ރައްކާތެރި ގޮތުގައި  ފެން ހިންދޭ ގޮތަށް ހަމަޖެހިފައި)", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.4", "code" => "MN", "text" => "ތަނުގެ އަލި: (ކާބޯތަކެތި ތައްޔާރުކުރާ ތަން) ކާނާތައްޔާރުކުރާ ތަނާއި ކައްކާތަނުގައި ހުރީ ހުދު / ގުދުރަތީ އަލި ލިބޭގޮތަށް ހުރުން", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.5", "code" => "MJ", "text" => "ކާބޯތަކެތި ގެންގުޅޭ ހިސާބުގައި ބޮކިތައް ހުރީ ތަޅައިގެން ނުދާ ގޮތަށް/ ޝޭޓާރ ޕްރޫފް ކޮށްފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.6", "code" => "MN", "text" => "ކާބޯތަކެތި ތައްޔާރުކުރުމުށް ބޭނުންކުރާ އާލާތްތައް ބެހެއްޓިފައި ހުންނަ ތަން ހުރީ އަލިކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.7", "code" => "MN", "text" => "ފާރުތައް: ފެންހަރުނުލާ,  ފެން ނުފާއްދާ، ކުލަ ނުފޮޅޭ ގޮތަށް އޮމާންކޮށް ފަސޭހައިން ސާފުކުރެވޭ ގޮތަށް ހެދިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.8", "code" => "MN", "text" => "ޖަރާސީމާއި ސޫފާސޫތްޕަށް އަށަނުގަނެވޭ ގޮތަށްހެދިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.9", "code" => "MN", "text" => "މަސައްކަތްކުރާ ހިސާބުގެ ފާރު ހުރީ ރަނގަޅަށް ސާފުކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.10", "code" => "MJ", "text" => "ފަންގިފިލާ: ކާބޯތަކެތިގެ މަސައްކަތް ކުރާ ތަނުގެ ސީލިންގް ކުރެވި ފުރާޅުން ކުނޑިފަދަ ތަކެތި ނުފައިބާ ގޮތަށްހެދިފައި ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.11", "code" => "MJ", "text" => "ހިރަފުސްނުހިފާ، އުދާސްހެދި ފެންތިކި ހަރުނުލާ، ތެތްވެ، ފޫނުޖަހާ އަދި ދަވާދާއި ކުލަ ފޮޅިގެން ނުފައިބާ ގޮތަށް ހެދިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.12", "code" => "MJ", "text" => "ދޮރާއި ކުޑަދޮރު: ދޮރާއި ދޮރުފަތް ސާފުކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.13", "code" => "MJ", "text" => "ކުޑަ ދޮރު ހުރީ ނައްޓާ ސާފުކުރެވޭގޮތަށް ދިރޭ ތަކެއްޗަށް ނުވަދެވޭ ގޮތަށް ދާ ޖެހިފައި އަދި ސާފުކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.14", "code" => "MJ", "text" => "ވަދެ ނުކުންނަ ދޮރުހުރީ އަމިއްލަޒާތުގައި ލެއްޕޭގޮތަށް ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.15", "code" => "MN", "text" => "ސިޑި އެއް ހުރިނަމަ:. ސިޑިހުރީ ސާފުކުރެވިފައި އަދި ރައްކާތެރިކަމާއެކު އަރާ ފައިބާ ގޮތަށް ހެދިފައި (ވަކަރު ސިޑިއެއްނަމަ ފެން ހަރުނުލާގޮތަށް ހެދިފައި) ސިޑިގޮޅި ރަނގަޅަށް އަލި ކުރެވިފައި އަދި ސާފުކުރެވިފައި ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.16", "code" => "MJ", "text" => "ސިންކު: ރޯމަސް (ކަނޑު މަސް، އެއްގަމު މަސް) ކަނޑާ ދޮވެ ސާފުކުރުމަށް ވަކި ސިންކު ބެހެއްޓިފައި އަދި އޮހޮރޭފެން ލިބޭގޮތަށް ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.17", "code" => "MJ", "text" => "ތެލި، ތަށި ދޮވުމަށް ވަކި ސިންކު ބެހެއްޓިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.18", "code" => "MJ", "text" => "މުވައްޒަފުންގެ އަތްދޮވެ ސާފުކުރުމަށް ވަކިން ސިންކު ބެހެއްޓި އޮހޮރޭ ފެނުން އަތްދޮވެވޭނެ އިންތިޒާމް ހަމަޖެހިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.19", "code" => "MJ", "text" => "މުވައްޒަފުން އަތްދޮވުމަށް ދިޔާ ސައިބޯނި ލިބެން ހުރުން", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.2", "code" => "MJ", "text" => "އަތްހިއްކުމަށް ހޭންޑް ޑްރަޔަރ ނުވަތަ އެއްފަހަރު ބޭނުންކުރުމަށް ފަހު އެއްލާލާ ގޮތަށް ޓިޝޫ ބެހެއްޓިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.21", "code" => "MJ", "text" => "ކާބޯތަކެތި ސީދާ ޖެހޭ ތަންތަނާއި ތަކެތި ރަނގަޅަށް ސާފުކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.22", "code" => "MJ", "text" => "ކާބޯތަކެތި ބަހައްޓާ، ގެންގުޅޭ ތަންތަނާއި މޭޒު ފަދަ ތަންތަން ހުރީ ރަނގަޅަށް ބޭނުންކުރެވޭ ހާލަތުގައި  ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.23", "code" => "MN", "text" => "ތަން ސާފުކުރުމަށް ބޭނުންވާ ކެމިކަލްސް، ފިހިގަނޑު، ފޮތިކޮޅު މޮޕް ފަދަ ތަކެތި ތަނަށް އެކަށީގެންވާ ވަރަށް ހުރުން އަދި ސާފުކުރެވިފައި ހުރުން ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.24", "code" => "MJ", "text" => "ސާފު ކުރަން ބޭނުންކުރާ ކެމިކަލްސް އާއި އެހެނިހެން ސާމާނު ހުރީ ވަކިން ޚާއްސަ ކުރެވިފައިވާ ތަނެއްގައި ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.25", "code" => "MJ", "text" => "ނަރުދަމާ ނިޒާމް: ފެން ހިންދާ ވަޅުގަނޑު ސުއިއްޕަށް ނުވަދެވޭ ގޮތަށް ބަންދު ކޮށްފައި ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.26", "code" => "MJ", "text" => "ށ. ސިންކު ހޮޅި/ ގުލީ ލީކު ނުވާ ގޮތަށް ބެލެހެއްޓިފައި (މެޝިނަރީސް އެންޑް އިކުއިޕްމަންޓްސް ގެ ވޭސްޓް ޕައިޕް ލައިންތައް ރައްކާތެރި ގޮތުގައި  ފެން ހިންދޭ ގޮތަށް ހަމަޖެހިފައި)", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.27", "code" => "CR", "text" => "އޮއިލް ޓްރެޕް އަދި ޖަންކްޝަންގެ މަތި ރަނގަޅަށް މަރާމާތު ކޮށް ރައްކާތެރި ކޮށް ބެލެހެއްޓިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.28", "code" => "MJ", "text" => "ވައިދައުރު ކުރާ ނިޒާމް:  ތަނުގައި ވައި ދައުރު ކުރެވޭނެ އިންތިޒާމެއް ހަމަޖެހިފައި ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.29", "code" => "MJ", "text" => "ކާބޯތަކެތި ތައްޔާރުކުރާ ތަނުގައި ވައި ބޭރުކުރާ ނިޒާމް ހުރީ ކާބޯތަކެއްޗަށް އަސަރު ނުކުރާގޮތަށް ބެލެހެއްޓިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.3", "code" => "MJ", "text" => "ކުނި ނައްތާލުން: ކާބޯތަކެތި މަސައްކަތް ކުރާ ސަރަހައްދުގައި އަތްނުލާ ހުޅުވޭގޮތަށް މަތިޖެހި ކުނިއަޅާ ޑަސްޓްބިން ބެހެއްޓިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.31", "code" => "MJ", "text" => " ކުނިއަޅާ ޑަސްޓްބިން ހުރީ ކާބޯތަކެއްޗަށް އަސަރު ނުފޯރާ ހިސާބެއްގައި އަސަރު ނުފޯރާ ގޮތަށް", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.32", "code" => "MJ", "text" => "އުކާލެވެންދެން ކުނި ބަހައްޓާތަނެއް ހުރިނަމަ އެތަން ހުރީ ރަނގަޅަށް ސާފުކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.33", "code" => "CR", "text" => "ބޯފެން: ސާފު ބޯ ފެން ލިބޭނެ އިންތިޒާމް ހަމަޖެހިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.34", "code" => "MJ", "text" => "ކާބޯތަކެތި އާވިން ތައްޔާރުކުރުމަށް އަދި ކާބޯތަކެތީ ގެ މަސައްކަތުގައި ބޭނުންވާ އައިސް ހެދުމަށް ސާފު ބޯފެން ބޭނުންކުރޭ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.35", "code" => "MJ", "text" => " ބޯން ކަމުނުދާ ފެން ބޯފެނާ މުޅިން ވަކި ކުރެވިފައި އަދި ކުލަ ވަކިކޮށް ފަސޭހައިން އެނގޭގޮތަށް ފާހަގަކުރެވިފައި ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.36", "code" => "MN", "text" => "ކާބޯތަކެތީގެ މަސައްކަތްކުރާ ތަންތަނުގައި ހިފާ ގެންގުޅޭ އާލާތްތައް މިކްސަރ، އަވަން، ޓޯސްޓަރު، ފަދަތަކެތި ހުރީ ރަނގަޅަށް ސާފުކުރެވިފައި ", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.37", "code" => "MN", "text" => "ކާބޯތަކެތި އެޅުމަށް ބޭނުންކުރާ ކަންވާރު ފަދަ ތަކެއްޗަކީ ވިހަ މާއްދާއަކުން ހެދިފައިނުވާ ތަކެތި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.38", "code" => "MN", "text" => "ތަށި، އޫ ސަމުސާ، ކާބޯތަކެތި އަޅަން ގެންގުޅޭ ކަންވާރު ފަދަތަކެތި ހުރީ ރަނގަޅު ހާލަތުގައި (ތަޅައިގެން ނުގޮސް، ދަބަރު ނުޖަހާ) އަދި ރަނގަޅަށް ސާފުކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "5.39", "code" => "MN", "text" => "އެއްތަނުން އަނެއްތަނަށް ގެންދެވޭގޮތަށް (ފްރީޒާރސް، މައިކްރޮވޭވް އަވަން ފަދަ ތަކެތި) ހުރީ ރަނގަޅަށް ސާފުކުރެވިފައި", "group" => "5. ބަދިގޭގެ ލޭއައުޓް އާއި ޑިޒައިން"],
["no"=> "6.1", "code" => "MJ", "text" => "ކާބޯތަކެތި ތައްޔާރު ކުރާ ތަނުގެ ތެރެއަށް ސީދާ ފާޚާނާގެ ދޮރު ނުހުޅުވޭ ގޮތަށް ހެދިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.2", "code" => "MJ", "text" => "ފާޚާނާގެ ދޮރު އަމިއްލަ ޒާތުގައި ލެއްޕޭ ގޮތަށްހެދިފައި ", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.3", "code" => "MN", "text" => " ފާޚާނާ ކުރުމަށް އުސްތަށްޓެއް ބެހެއްޓިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.4", "code" => "MN", "text" => " މުސްލިމު ޝަވަރު ހަރުކުރެވިފައި ", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.5", "code" => "MJ", "text" => "ސާފު ފެން ލިބޭނެ ގޮތް ހަމަޖެހިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.6", "code" => "MJ", "text" => " އަތްނުލާ ހުޅުވޭކަހަލަ ޑަސްޓްބިން ބެހެއްޓިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.7", "code" => "MJ", "text" => "ތަޅުންގަނޑު ހުރީ ފެންހަރުނުލާގޮތަށް ހެދިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.8", "code" => "MJ", "text" => "ފެން ހިންދާ ވަޅުގަނޑު ހުރީ ރަނގަޅަށް ބަންދުކުރެވިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.9", "code" => "MN", "text" => "ފާޚާނާގައި ފަސޭހައިން ކައްސާކަނުލާގޮތަށް މުށިޖަހާފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.1", "code" => "MN", "text" => " އެކަށީގެންވާވަރަށް އަލިކުރެވިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.11", "code" => "MN", "text" => " ވައިދައުރުވާ ނިޒާމު ޤާއިމްކުރެވިފައި", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.12", "code" => "MN", "text" => " ދިޔާ ސައިބޯނި ބެހެއްޓިފައި ", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "6.13", "code" => "MN", "text" => " އަތް ހިއްކުމުގެ ނިޒާމް ޤާއިމްކުރެވިފައި (ޓިޝޫ / ހޫނުވައިން އަތްހިއްކޭގޮތަށް)", "group" => "6. ފާޚާނާ ކުރުމުގެ އިންތިޒާމް"],
["no"=> "7.1", "code" => "MJ", "text" => "ޖަނަވާރާއި ސޫފާސޫފި ވަދެ އާލާ ނުވާގޮތަށް ތަން މަރާމާތުކޮށް ސާފުކުރެވިފައި ", "group" => "7.ޖަނަވާރާއި ސޫފާސޫފި ކޮންޓްރޯލް ކުރުން"],
["no"=> "7.2", "code" => "CR", "text" => "ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަނުގައި ކުރަފި ފަދަ ސޫފާސޫފި އާލާވެފައި ނެތް", "group" => "7.ޖަނަވާރާއި ސޫފާސޫފި ކޮންޓްރޯލް ކުރުން"],
["no"=> "7.3", "code" => "CR", "text" => " ތަނުގެ ތެރޭގައި ބުޅާފަދަ އޮޅު ކުރި ޖަނަވާރު  ނޫޅުން", "group" => "7.ޖަނަވާރާއި ސޫފާސޫފި ކޮންޓްރޯލް ކުރުން"],
["no"=> "8.1", "code" => "MN", "text" => " ސީލިންކޮށް ތަޅުމުގައި ތަށިމުށި ޖަހާފައި    ", "group" => "8.ކާބޯތަކެތި ރައްކާކުރާ ތަން"],
["no"=> "8.2", "code" => "MJ", "text" => "ސޫފާސޫފި އާލާ ނުވާގޮތަށް ހެދިފައި", "group" => "8.ކާބޯތަކެތި ރައްކާކުރާ ތަން"],
["no"=> "8.3", "code" => "MJ", "text" => " ވައި ދައުރުވާނެ އިންތިޒާމް ހަމަޖެހިފައި", "group" => "8.ކާބޯތަކެތި ރައްކާކުރާ ތަން"],
["no"=> "8.4", "code" => "MJ", "text" => "ކާބޯތަކެތި ބެހެއްޓުމަށް ފެންނުފާއްދާ ގޮތަށް ހަރުތަށް ހެދިފައި", "group" => "8.ކާބޯތަކެތި ރައްކާކުރާ ތަން"],
["no"=> "8.5", "code" => "MJ", "text" => "ހަނޑޫ، ހަކުރު ފަދަތަކެތި ރައްކާ ކުރުމަށް މަތިޖެހޭ ކަންވާރު ބެހެއްޓިފައި", "group" => "8.ކާބޯތަކެތި ރައްކާކުރާ ތަން"],
["no"=> "8.6", "code" => "MJ", "text" => "ކާބޯތަކެތި ބެހެއްޓިފައި ހުރީ ބިމުން މައްޗަށް \"6\" އަދި ފާރުގައި ނުޖެހި \"6\" ހުންނަ ގޮތަށް", "group" => "8.ކާބޯތަކެތި ރައްކާކުރާ ތަން"],
["no"=> "8.7", "code" => "MN", "text" => " ރައްކާ ކުރެވޭ ކާބޯތަކެތީގެ މުއްދަތުހަމަވާ ތާރީޙް ވަކިވާގޮތަށް ލޭބަލް ކޮށް މުވައްޒަފުންނަށް ފެންނަ ގޮތަށް އެތުރިފައި", "group" => "8.ކާބޯތަކެތި ރައްކާކުރާ ތަން"],
["no"=> "9.1", "code" => "MN", "text" => "ކާނާގެ ބާވަތުގެ ރައްކާތެރިކަން: ކާބޯތަކެތި ތައްޔާރުކުރުމުގެ ކުރިން، މޭވާ/ ތަރުކާރީ ފަދަ ތަކެތި ރަނގަޅަށް ދޮވެ ސާފުކުރެވޭ ", "group" => "9.ކާބޯތަކެތި ތަޢައްޔަރުވާނެ ނުރައްކަލެއް ހުރިތޯ ބެލުން"],
["no"=> "9.2", "code" => "MJ", "text" => "ރޯމަސް އަދި މަހުގެ ބާވަތްތައް ރައްކާކުރެވިފައި ހުރީ ކައްކާފައި ހުންނަ ތައްޔާރީ ކާނާއާއި ވަކިން", "group" => "9.ކާބޯތަކެތި ތަޢައްޔަރުވާނެ ނުރައްކަލެއް ހުރިތޯ ބެލުން"],
["no"=> "9.3", "code" => "MJ", "text" => "ގަނޑުކޮށްފައި ހުންނަ އަވަހަށް ހަލާކުވާ ޒާތުގެ ކާބޯތަކެތި ގަނޑު ފިލުވަނީ  ރައްކާތެރި ގޮތަށް", "group" => "9.ކާބޯތަކެތި ތަޢައްޔަރުވާނެ ނުރައްކަލެއް ހުރިތޯ ބެލުން"],
["no"=> "9.4", "code" => "MJ", "text" => "ގަނޑު ފިލުވުމަށް ފަހު ދެވަނަ ފަހަރަށް ގަނޑު ކޮށްގެން ބޭނުން ނުކުރުން", "group" => "9.ކާބޯތަކެތި ތަޢައްޔަރުވާނެ ނުރައްކަލެއް ހުރިތޯ ބެލުން"],
["no"=> "10.1", "code" => "MN", "text" => "ޓެމްޕަރޭޗަރ ބެލޭނެ ރަނގަޅު މީޓަރެއް  ކޯލްޑްސްޓޯރ ތަކާއި / ރެފްރިޖަރޭޓެޑް ކޮންޓެއިނަރުގައި ބެހެއްޓިފައި", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "10.2", "code" => "MN", "text" => "ޓެމްޕަރޭޗަރ ބަލާ ތާރމޮމީޓަރ ހުރީ ސާފުކޮށް އަދި ޖަރާސީމު ފިލުވިފައި", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "10.3", "code" => "MJ", "text" => "ހޫނުކޮށް ބަހައްޓަންޖެހޭ ތަކެތި ހޫނުކޮށް ބެހެއްޓޭނެ ނިޒާމެއް ތަނުގައި ޤާއިމްވެފައި (ހޮޓް ކަބަޑު، އަވަން، ފަދަ ތަކެތި)", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "10.4", "code" => "MN", "text" => "ކައްކާފައި ހުންނަ ކާބޯތަކެތި (ރިހަ،ބަތް ފަދަ ތަކެތި) ރައްކާކުރާނަމަ ލަސްވެގެން 4 ގަޑިއިރުތެރޭ 5ޑިގްރީ ސެލްސިއަސް އަށް ވުރެ ދަށް ނުވާ މިންވަރަކަށް ފިނި ކޮށް ފައި ބެހެއްޓުން", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "10.5", "code" => "MJ", "text" => "ފްރިޖް ކޮށްފައި ހުރި ކައްކާފައި ހުންނަ (ރިހަ،ބަތް ފަދަ ތަކެތި) 24 ގަޑިއިރު ތެރޭ ބޭނުންކުރުން އަދި ބެހެއްޓި ގަޑި އެނގޭ ގޮތަށް ލޭބަލް ކުރެވިފައި", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "10.6", "code" => "MJ", "text" => " ކައްކާފައި ހުރި، އަވަހަށް ހަލާކުވާ ޒާތުގެ ކާބޯތަކެތި ފްރިޖް ކުރުމަށް ފަހުގައި ދެވަނަ ފަހަރު ބޭނުންކުރާއިރު 75 ޑިގްރީ ސެލްސިއަސް އަށް ހޫނުކުރުމަށް ފަހު ބޭނުންކުރުން", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "10.7", "code" => "MJ", "text" => " ހޫނުކޮށް ބަހައްޓަން ޖެހޭ ކާބޯތަކެތި 75 ޑިގްރީ ސެލްސިއަސް އަށް ވުރެ މަތީގައި ބެހެއްޓިފައި / ހޫނުކޮށް ބަހައްޓަން ޖެހޭ ކާބޯތަކެތި ބޭރުގައި ބަހައްޓާނަމަ ކައްކާތާ 4 (ހަތަރެއް) ގަޑިއިރުތެރޭ ބޭނުންކުރެވޭ", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "10.8", "code" => "MJ", "text" => "ފިނިކޮށް ބަހައްޓަންޖެހޭ ތަކެތި 5 ޑިގްރީ ސެލްސިއަސް އަށް  ވުރެ ދަށުގައި ބެހެއްޓިފައި/ ފިނިކޮށް ބަހައްޓަން ޖެހޭ ކާބޯތަކެތި ބޭރުގައި ބަހައްޓާނަމަ 2 (ދޭއް) ގަޑިއިރުތެރޭ ބޭނުންކުރެވޭ/ ގަނޑު ކޮށް ބަހައްޓަންޖެހޭ ކާބޯތަކެތި -18 އަށް ވުރެ ދަށުގައި ބެހެއްޓުން", "group" => "10.ކާބޯތަކެތީގެ ފިނި ހޫނުމިން"],
["no"=> "11.1", "code" => "MN", "text" => "ކާބޯތަކެތި އުފުލުމުގައި ހުންނަން ޖެހޭ ފިނި ހޫނުމިނުގައި ބެހެއްޓުން", "group" => "11.ކާބޯތަކެތި އެއްތަނުން އަނެއްތަނަށް އުފުލުމާއި ގެންދިއުން"],
["no"=> "11.2", "code" => "CR", "text" => "ކައްކާ ފައިވާ ކާބޯތަކެތި އަދި ސާރވް ކުރުމަށް ގެންދާ ތައްޔާރީ ކާނާ އުފުލުމުގައި މަތި ޖެހި ކޮންޓެއިނާރސް/ ޕެކެޓް ގައި ގެންދިއުން", "group" => "11.ކާބޯތަކެތި އެއްތަނުން އަނެއްތަނަށް އުފުލުމާއި ގެންދިއުން"],
["no"=> "11.3", "code" => "MJ", "text" => "ކާބޯތަކެތި އުފުލުމަށް ބެނުން ކުރާ އުޅަނދު ރަނަގަޅަށް ސާފު ކޮށް ޖަރާސީމު ފިލުވިފައި", "group" => "11.ކާބޯތަކެތި އެއްތަނުން އަނެއްތަނަށް އުފުލުމާއި ގެންދިއުން"],
["no"=> "11.4", "code" => "MJ", "text" => "ކާބޯތަކެތި އުފުލާ އިރު ކެމިކަލްސް ފަދަ ކާބޯތަކެއްޗަށް ނޭދެވޭ އަސަރު ކުރާނެ ފަދަ އެއްޗެއް ނެތުން", "group" => "11.ކާބޯތަކެތި އެއްތަނުން އަނެއްތަނަށް އުފުލުމާއި ގެންދިއުން"],
["no"=> "12.1", "code" => "MN", "text" => "މެހަމާނުން ތަނަށް ވަނުމުގައި އަމަލު ކުރަންޖެހޭ އިންތިޒާމް ހަމަޖެހިފައި", "group" => "12"],
["no"=> "12.2", "code" => "MN", "text" => "ކާބޯތަކެތި ތައްޔާރުކުރާ ތަނުގެ ތެރޭގައި ޢަމަލު ކުރަން ޖެހޭ އުސޫލް ލިޔެވިފައި", "group" => "12"],
["no"=> "13.1", "code" => "MJ", "text" => "އަރިދަފުސްރޯގާ ޖެހި ،ކެއްސާ ކިނބިހި އެޅުން ފަދަ ބައްޔެއް ހުރިމީހަކު ކާބޯތަކެތި ތައްޔާރުކުރުމުގައި އުޅުން", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "13.2", "code" => "MJ", "text" => "ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުން ތިބީ  ސާފުތާހިރު ހެދުމެއްގައި، ސާފުތާހރު ފައިވާނަކަށް އަރައިގެން، އިސްތަށިގަނޑު ނިވާ ކުރެވިފައި", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "13.3", "code" => "MJ", "text" => "ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ ނިޔަފަތި ކުރު ކޮށް ކަނޑާ ސާފުކުރެވިފައި", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "13.4", "code" => "MJ", "text" => "ކާބޯތަކެތީގެ މަސައްކަތުގައި އުޅޭއިރު އަތުގައި އަނގޮޓިއާއި، އަތުކުރީގަޑި ފަދަތަކެތި ބޭނުން ނުކުރުން.", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "13.5", "code" => "MN", "text" => "މަސައްކަތް ކުރާއިރު ގިނަގިނައިން އަތްދޮވެ ސާފުތާހިރުވުމުގައި ގެންގުޅެންޖެހޭ އުސޫލު ލިއުމުން ފެންނަގޮތަށް ހަރުކުރެވިފައި", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "13.6", "code" => "MN", "text" => "އެކަށީގެންވާ އަދަދަކަށް ފުރަތަމަ އެހީ (ފަސްޓް އެއިޑް)ގެ އިންތިޒާމް ހަމަޖެހިފައި", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "13.7", "code" => "MJ", "text" => "މަސައްކަތުގައި އުޅޭ އިރު ގިނަ ގިނައިން އަތް ދޮވުން", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "13.8", "code" => "MJ", "text" => "މަސައްކަތުގައި އުޅޭ އިރު ނޭފަތް ފޮޅުމާއި، އަނގަޔަށް އަތްލުމާއި، ދުންފަތުގެ އިސްތިއުމާލު ކުރުން ފަދަ އަމަލު ތަކުން ދުރުހެލިވުން", "group" => "13. ކާބޯތަކެތީގެ މަސައްކަތްކުރާ މުވައްޒަފުންގެ އަމިއްލަ ސާފުތާހިރުކަން"],
["no"=> "14.1", "code" => "MJ", "text" => "ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަން ގަވާއިދުން ސާފުކުރާ ގޮތާއި ޖަރާސީމު ނައްތާލާ ގޮތްތައް ބަޔާން ކުރާ ތާވާލު އެބަހުރި", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],
["no"=> "14.2", "code" => "MN", "text" => "ތަނުގައި އުފެދޭ ކުނިބުނި އުކާލެވެންދެން ރައްކާތެރި ގޮތެއްގައި ބަހައްޓާނޭ އިންތިޒާމް /ކުނި އުކާލެވޭ އަދަދު އާއި ކުނިބަހައްޓާ ސަރަހައްދު ސާފުކުރާ ކަމުގެ ރެކޯޑް އެބަހުރި", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],
["no"=> "14.3", "code" => "MJ", "text" => "ބޯން ކަމުނުދާ ފެން ނުވަތަ އަމިއްލަ ފެން އުފައްދާ ނަމަ ފެން ޓެސްޓް ކުރިކަމުގެ ރިޕޯރޓް ", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],
["no"=> "14.4", "code" => "MJ", "text" => "ތަނުގައި މަސައްކަތްކުރާ ހުރިހާ މުވައްޒަފުންގެ އެނުއަލް މެޑިކަލް ޗެކް އަޕް ފޯމް އެބަހުރި", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],
["no"=> "14.5", "code" => "MJ", "text" => "ކާބޯތަކެތީގެ މަސައްކަތުގައި އުޅޭހުރިހާ މުވައްޒަފުން ބޭސިކް ފުޑް ހައިޖީން ޓްރޭނިންގ ހަދާފައިވާ ކަމުގެ ރެކޯޑް އެބަހުރި", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],
["no"=> "14.6", "code" => "MJ", "text" => "ޕެސްޓްކޮންޓްރޯލް ކުރެވޭގޮތުގެ ތާވަލް ހެދި ރިކޯރޑް ކުރެވިފައި", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],
["no"=> "14.7", "code" => "MN", "text" => "ކާބޯތަކެތި ރައްކާ ކުރުމުގައި /ޑިސްޕްލޭ ކުރުމުގައި ހުންނަންޖެހޭނެ ފިނި ހޫނުމިން ބަލާ ޗެކްކުރި ކަމުގެ ރެކޯޑް ކުރެވިފައި އެބަހުރި (އަވަހަށް ހަލާކުވާ ޒާތުގެ ކާބޯތަކެތި)", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],
["no"=> "14.8", "code" => "MN", "text" => "ކާބޯތަކެތި އެއްތަނުން އަނެއް ތަނަށް އުފުލުމުގައި ހުންނަންޖެހޭ ފިނިހޫނުމިން ކޮންޓްރޯލް ކުރުން (ޓްރާންސްޕޯޓޭޗަން ޓެމްޕަރޭޗަރ ރެކޯޑް) ", "group" => "14. ޑޮކިއުމަންޓް ކޮށް ބަލަހައްޓަންޖެހޭ ރެކޯޑް ތަށް "],


        ];

        $category = new NormalCategory;

		foreach ($categories as $item) {
            $category->create($item);
        }

        $normalPoint = new NormalPoint;
        
        foreach ($fields as $key => $item) {
        	$order = $key + 1;
            $normalPoint->create([
				'no' => $item['no'],
				'code' => $item['code'],
				'text' => $item['text'],
				'normal_category_id' => $category->where('text', '=', $item['group'])->first()->id,
				'order' => $order,
        	]);
        }

    }
}
