@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'dhivehi-reports.update'">
@endverbatim

	@include('components.heading-dhivehi', ['title' => '‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަން ތަން ބަލާ ފާސްކުރުމުގެ ރިޕޯޓް'])

	@include('components.form-results')
	<input type='hidden' id="report_id" value="{{(isset($report)) ? $report->id : null}}" />
	<input type='hidden' id="inspection_id" value="{{(isset($report)) ? $report->inspection_id : null}}" />
	@verbatim
	<div class="container">


		<div class="columns dhivehi">
			<div class="column">
				<label class="label">އިންސްޕެކްޓް ކުރި ބޭނުން:</label>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<div class="columns">
					<div class="column">
						<div class="field">
							<select v-model="dhivehiReportForm.purpose" class="dhivehi">
							  <option value="1">ރަޖިސްޓްރީ ކުރުމަށް</option>
							  <option value="2">ރޫޓީން އިންސްޕެކްޝަން</option>
							  <option value="3">ހުއްދަ އާކުރުމަށް</option>
							  <option value="4">ސޮފްޓް ޗެކް</option>
							  <option value="5">ތަނުގެ އެޑްރެސް / މެނޭޖްމެން ބަދަލުވެގެން</option>
							  <option value="6">ޝަކުވާއާއި ގުޅިގެން</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>ތަނުގެ ނަމާއި އެޑްރެސް:</td>
						<td colspan="3"><input type="text" class="input" v-model="dhivehiReportForm.place_name_address" name="place_name_address"></td>
					</tr>
					<tr>
						<td>ތަނުގެ ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
						<td colspan="3"><input type="text" class="input" v-model="dhivehiReportForm.place_owner_name_address" name="place_owner_name_address"></td>
					</tr>
					<tr>
						<td>ގުޅޭން ނަމްބަރ:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.phone" name="phone"></td>
						<td>އިންސްޕެކްޓް ކުރެވުނު ތާރީޚާއި ގަޑި:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.time_of_inspection" name="time_of_inspection"></td>
					</tr>
					<tr>
						<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.information_provider" name="information_provider"></td>
						<td>ކުރެވުނު އިންސްޕެކްޝަންގެ އަދަދު:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.number_of_inspections" name="number_of_inspections"></td>
					</tr>
				</table>
			</div>
		</div>
		<br>


		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 1: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ ކްރިޓިކަލް (ވަގުތުން ރަނގަޅު ކުރަންޖެހޭ) މައްސަލަތައް:</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>#</td>
						<td>ރިފަރެންސް</td>
						<td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
						<td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
						<td>
							<button class="button is-success is-outlined" @click="showCriticalNewItemForm = !showCriticalNewItemForm">
						    <span>އާ އަިޓަމެއް</span>
						  </button></td>
					</tr>
					<tr v-if="showCriticalNewItemForm">
						<td><input type="text" class="input" name="no" v-model="newItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="newItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="newItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="newItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click="storePoint('CR')">
						    <span>ރައްކާކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-if="criticalSelectedItem != null">
						<td><input type="text" class="input" name="no" v-model="criticalSelectedItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="criticalSelectedItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="criticalSelectedItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="criticalSelectedItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click="updatePoint('CR', criticalSelectedItem)">
						    <span>އަދާހަމަ ކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-for="item, index in criticalPoints">
						<td>{{item.no}}</td>
						<td>{{item.point_no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
						<td width="15%">
							<button class="button is-danger is-outlined" @click="removePoint('CR', item)">
						    <span>ފުހެލާ</span>
						  </button>
							<button class="button is-warning is-outlined" @click="criticalSelectedItem = item">
						    <span>ބަދަލުގެނޭ</span>
						  </button>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 2: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ މޭޖަރ (ދެވިފައިވާ މުއްދަތުގައި ރަނގަޅުކުރަން ޖެހޭ) މައްސަލަތައް:</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>#</td>
						<td>ރިފަރެންސް</td>
						<td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
						<td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
						<td>
							<button class="button is-success is-outlined" @click="showMajorNewItemForm = !showMajorNewItemForm">
						    <span>އާ އަިޓަމެއް</span>
						  </button></td>
					</tr>
					<tr v-if="showMajorNewItemForm">
						<td><input type="text" class="input" name="no" v-model="newItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="newItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="newItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="newItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click="storePoint('MJ')">
						    <span>ރައްކާކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-if="majorSelectedItem != null">
						<td><input type="text" class="input" name="no" v-model="majorSelectedItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="majorSelectedItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="majorSelectedItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="majorSelectedItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click="updatePoint('MJ', majorSelectedItem)">
						    <span>އަދާހަމަ ކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-for="item, index in majorPoints">
						<td>{{item.no}}</td>
						<td>{{item.point_no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
						<td width="15%">
							<button class="button is-danger is-outlined" @click="removePoint('MJ', item)">
						    <span>ފުހެލާ</span>
						  </button>
							<button class="button is-warning is-outlined" @click="majorSelectedItem = item">
						    <span>ބަދަލުގެނޭ</span>
						  </button>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 3: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ އެހެނިހެން ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޗަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>#</td>
						<td>ރިފަރެންސް</td>
						<td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
						<td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
						<td>
							<button class="button is-success is-outlined" @click="showMinorNewItemForm = !showMinorNewItemForm">
						    <span>އާ އަިޓަމެއް</span>
						  </button></td>
					</tr>
					<tr v-if="showMinorNewItemForm">
						<td><input type="text" class="input" name="no" v-model="newItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="newItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="newItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="newItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click="storePoint('MN')">
						    <span>ރައްކާކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-if="minorSelectedItem != null">
						<td><input type="text" class="input" name="no" v-model="minorSelectedItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="minorSelectedItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="minorSelectedItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="minorSelectedItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click="updatePoint('MN', minorSelectedItem)">
						    <span>އަދާހަމަ ކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-for="item, index in minorPoints">
						<td>{{item.no}}</td>
						<td>{{item.point_no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
						<td width="15%">
							<button class="button is-danger is-outlined" @click="removePoint('MN', item)">
						    <span>ފުހެލާ</span>
						  </button>
							<button class="button is-warning is-outlined" @click="minorSelectedItem = item">
						    <span>ބަދަލުގެނޭ</span>
						  </button>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<br>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 5: ދުންފަތް ކޮންޓްރޯލް ކުރުމާ ބެހޭ ޤާނޫން (15/2010) ދަށުން ކުރެވުނު އިންސްޕެކްޝަން ގައި ފާހަގަ ކުރެވިފައިވާ ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޝަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>#</td>
						<td>ރިފަރެންސް</td>
						<td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
						<td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
						<td>
							<button class="button is-success is-outlined" @click=tobaccoAddItem>
						    <span>އާ އަިޓަމެއް</span>
						  </button></td>
					</tr>
					<tr v-if="tobaccoNewItem != null">
						<td><input type="text" class="input" name="no" v-model="tobaccoNewItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="tobaccoNewItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="tobaccoNewItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="tobaccoNewItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click=tobaccoStoreItem>
						    <span>ރައްކާކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-if="tobaccoSelectedItem != null">
						<td><input type="text" class="input" name="no" v-model="tobaccoSelectedItem.no"></td>
						<td><input type="text" class="input" name="point_no" v-model="tobaccoSelectedItem.point_no"></td>
						<td><textarea class="textarea" name="violation" v-model="tobaccoSelectedItem.violation"></textarea></td>
						<td><textarea class="textarea" name="recommendation" v-model="tobaccoSelectedItem.recommendation"></textarea></td>
						<td width="15%">
							<button class="button is-success is-outlined" @click=tobaccoUpdateItem>
						    <span>އަދާހަމަ ކުރޭ</span>
						  </button>
						</td>
					</tr>
					<tr v-for="item, index in tobaccoItems">
						<td>{{item.no}}</td>
						<td>{{item.point_no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
						<td width="15%">
							<button class="button is-danger is-outlined" @click="tobaccoRemoveItem(index)">
						    <span>ފުހެލާ</span>
						  </button>
							<button class="button is-warning is-outlined" @click="tobaccoEditItem(index)">
						    <span>ބަދަލުގެނޭ</span>
						  </button>
						</td>
					</tr>
					<tr rowspan="2">
						<td colspan="3">ޤަވާޢިދާއި ޚިލާފް ވުމުން ކުރެވުނު ޖޫރިމަނާ ކުރެވުނު (ޖޫރިމަނާ ސްލިޕްގެ/ސްލިޕްތަކުގެ ނަމްބަރު):</td>
						<td colspan="2"><input type="text" class="input" name="fine_slip_numbers" v-model="dhivehiReportForm.fine_slip_numbers"></td>
					</tr>
				</table>
			</div>
		</div>


		<br>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>ކެޓަގަރީ</td>
						<td>ރަނގަޅު ކޮށްފައިވާ އަދަދު</td>
						<td>ރަނގަޅު ކުރަންޖެހޭ އަދަދު</td>
						<td>އަދަދު NA</td>
					</tr>
					<tr>
						<td >ކްރިޓިކަލް ގެ މުޅި ޖުމްލަ <span style="direction: ltr;">10</span></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.critical_totals.fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.critical_totals.to_be_fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.critical_totals.total"></td>
					</tr>
					<tr>
						<td>މޭޖަރ ގެ މުޅި ޖުމްލަ <span style="direction: ltr;">43</span></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.major_totals.fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.major_totals.to_be_fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.major_totals.total"></td>
					</tr>
					<tr>
						<td>މައިނަ ގެ މުޅި ޖުމްލަ</td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.minor_totals.fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.minor_totals.to_be_fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.minor_totals.total"></td>
					</tr>
					<tr>
						<td>ދުންފަތުގެ އިސްޓިޢުމާލް ކުރުން <span style="direction: ltr;">14</span></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.tobacco_totals.fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.tobacco_totals.to_be_fixed"></td>
						<td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.tobacco_totals.total"></td>
					</tr>
				</table>
			</div>
		</div>

		<br>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr ><th style="direction: rtl;text-align: right;">އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް</th></tr>
					<tr><td style="text-decoration: underline;">(ހ) ކާބޯތަކެތީގެ ޙިދުމަތް ދިނުމުގައު ހުންނަންޖެހޭ ސާފުތާހިރުކަމުގެ މިންގަނޑުތައް ބަޔާން ކުރާ ގަވާޢިދު (ގަވާއިދު ނަންބަރު: <span style="direction: ltr;">2014/R-380</span>) އެއްގިތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
					<tr><td>1. ސެކްސަން 1 ގައި ބަޔާން ކުރެވިފައިވާ ކަންތައްތައް ވަގުތުން ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_1"></td></tr>
					<tr><td>2. ސެކްސަން 2 ގައި ބަޔާންކުރެވިފައިވާ ކަންތައް__ ދުވަހުގެ ތެރޭގައި ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_2"></td></tr>
					<tr><td>3. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_3">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" v-model="dhivehiReportForm.food_conclusion_3_date"></td></tr>
					<tr><td>4. ތަން ބަންދުކުރުމަށް ފެނޭ &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_4"></td></tr>
					<tr><td>5. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_5"></td></tr>
					<tr><td>6. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" v-model="dhivehiReportForm.food_conclusion_6_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_6"></td></tr>
					<tr><td style="text-decoration: underline;">(ށ)‫ދުންފަތ‬ ‫ކޮންޓްރޯލ‬ ‫ކުރުމ‬ާ ބެހޭ ޤާނޫން (<span style="direction: ltr;">15/2010</span>) އާއި އެއްގިތްވާ ގޮތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
					<tr><td>1. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" v-model="dhivehiReportForm.tobacco_conclusion_1">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" v-model="dhivehiReportForm.tobacco_conclusion_1_date"></td></tr>
					<tr><td>2. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" v-model="dhivehiReportForm.tobacco_conclusion_2"></td></tr>
					<tr><td>3. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" v-model="dhivehiReportForm.tobacco_conclusion_3_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" v-model="dhivehiReportForm.tobacco_conclusion_3"></td></tr>
				</table>
			</div>
		</div>
		<br>

				
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th colspan="4" style="direction: rtl;text-align: right;">‫ސެކްޝަން ހިންގުމާއި ހަވާލުވެ ހުރިފަރާތުގެ ނިންމުން</th>
					</tr>
					<tr>
						<td  colspan="2" style="text-decoration: underline;">‫ޕަބްލިކް‬ ‫‫ހެލްތު‬ އިންސްޕެކްޓޮރޭޓ‬ް</td>
						<td  colspan="2" style="text-decoration: underline;">‫‫‫ޓޮބޭކޯ‬ ‫ޕްރިވެންޝަން‬ ‫އެންޑް‬ ‫ކޮންޓްރޯލް‬ ސެކްޝަން‬</td>
					</tr>
					<tr>
						<td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_1"></td>
						<td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_1"></td>
					</tr>
					<tr>
						<td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_2"></td>
						<td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_2"></td>
					</tr>
					<tr>
						<td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" v-model="dhivehiReportForm.phi_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_3"></td>
						<td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" v-model="dhivehiReportForm.tpcs_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_3"></td>
					</tr>
					<tr>
						<td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_4"></td>
						<td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_4"></td>
					</tr>
					<tr>
						<td>ނަން:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.phi_head_name"></td>
						<td>ނަން:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.tpcs_head_name"></td>
					</tr>
					<tr>
						<td>ސޮއި:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.phi_head_sign"></td>
						<td>ސޮއި:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.tpcs_head_sign"></td>
					</tr>
					<tr>
						<td>ތާރީޚް</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.phi_head_date"></td>
						<td>ތާރީޚް</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.tpcs_head_date"></td>
					</tr>
				</table>
			</div>
		</div>
		<br>

		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th colspan="2" style="direction: rtl;text-align: right;">‫‫‪ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަނުގެ ފަރާތުން</th>
						<th colspan="2" style="direction: rtl;text-align: right;">ހެލްތު ޕްރޮޓެކްޝަން އެޖެންސީގެ ފަރާތުން</th>
					</tr>
					<tr>
						<td>ނަން:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_business_name"></td>
						<td>ނަން:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_name"></td>
					</tr>
					<tr>
						<td>މަޤާމް:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_business_position"></td>
						<td>މަޤާމް:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_position"></td>
					</tr>
					<tr>
						<td>ސޮއި:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_business_sign"></td>
						<td>ސޮއި:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_sign"></td>
					</tr>
					<tr>
						<td>ތާރީޚް:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_business_date"></td>
						<td>ތާރީޚް:</td>
						<td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_date"></td>
					</tr>
				</table>
			</div>
		</div>
		<br>

	</div>


	<br>
	<div class="columns" v-if="statusChangeStatus">
		<div class="column">
			<div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
		</div>
	</div>


	<div class="columns">
		<div class="column"></div>
		<div class="column center">
			<button class="button is-success is-large" @click=sendForProcessing>
			    <span>ޕްރޮސެސިން އަށް ފޮނުވާ</span>
			</button>
			<button class="button is-warning is-large" @click=saveDhivehiReportForm>
		    <span>ރައްކާކުރޭ</span>
		  </button>
			<a :href="'/dhivehi/reports/' + reportId" class="button is-info is-large">
	    	<span>ޕްރިންޓް</span>
	  	</a :href="'/dhivehi/reports/' + reportId">
		</div>
		<div class="column"></div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/dhivehi-reports-edit.js')}}"></script>
@endsection
