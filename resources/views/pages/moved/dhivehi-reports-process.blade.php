@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'dhivehi-reports.process'">
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
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="isPurpose(1)">
							  ރަޖިސްޓްރީ ކުރުމަށް
							</label>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="isPurpose(2)">
							  ރޫޓީން އިންސްޕެކްޝަން
							</label>
						</div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="isPurpose(3)">
							  ހުއްދަ އާކުރުމަށް
							</label>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="isPurpose(4)">
							  ސޮފްޓް ޗެކް
							</label>
						</div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="isPurpose(5)">
							  ތަނުގެ އެޑްރެސް / މެނޭޖްމެން ބަދަލުވެގެން
							</label>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="isPurpose(6)">
							  ޝަކުވާއާއި ގުޅިގެން
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>ތަނުގެ ނަމާއި އެޑްރެސް:</td>
						<td colspan="3">{{dhivehiReportForm.place_name_address}}</td>
					</tr>
					<tr>
						<td>ތަނުގެ ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
						<td colspan="3">{{dhivehiReportForm.place_owner_name_address}}</td>
					</tr>
					<tr>
						<td>ގުޅޭން ނަމްބަރ:</td>
						<td>{{dhivehiReportForm.phone}}</td>
						<td>އިންސްޕެކްޓް ކުރެވުނު ތާރީޚާއި ގަޑި:</td>
						<td>{{dhivehiReportForm.time_of_inspection}}</td>
					</tr>
					<tr>
						<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
						<td>{{dhivehiReportForm.information_provider}}</td>
						<td>ކުރެވުނު އިންސްޕެކްޝަންގެ އަދަދު:</td>
						<td>{{dhivehiReportForm.number_of_inspections}}</td>
					</tr>
				</table>
			</div>
		</div>


		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 1: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ ކްރިޓިކަލް (ވަގުތުން ރަނގަޅު ކުރަންޖެހޭ) މައްސަލަތައް:</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in criticalItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 2: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ މޭޖަރ (ދެވިފައިވާ މުއްދަތުގައި ރަނގަޅުކުރަން ޖެހޭ) މައްސަލަތައް:</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in majorItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 3: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ އެހެނިހެން ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޗަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in minorItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 5: ދުންފަތް ކޮންޓްރޯލް ކުރުމާ ބެހޭ ޤާނޫން (15/2010) ދަށުން ކުރެވުނު އިންސްޕެކްޝަން ގައި ފާހަގަ ކުރެވިފައިވާ ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޝަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in tobaccoItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
					<tr rowspan="2">
						<td colspan="3">ޤަވާޢިދާއި ޚިލާފް ވުމުން ކުރެވުނު ޖޫރިމަނާ ކުރެވުނު (ޖޫރިމަނާ ސްލިޕްގެ/ސްލޮޕްތަކުގެ ނަމްބަރު):</td>
					</tr>
				</table>
			</div>
		</div>


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
						<td>ކްރިޓިކަލް ގެ މުޅި ޖުމްލަ 10</td>
						<td>{{dhivehiReportForm.critical_totals.fixed}}</td>
						<td>{{dhivehiReportForm.critical_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.critical_totals.total}}</td>
					</tr>
					<tr>
						<td>މޭޖަރ ގެ މުޅި ޖުމްލަ 43</td>
						<td>{{dhivehiReportForm.major_totals.fixed}}</td>
						<td>{{dhivehiReportForm.major_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.major_totals.total}}</td>
					</tr>
					<tr>
						<td>މައިނަ ގެ މުޅި ޖުމްލަ</td>
						<td>{{dhivehiReportForm.minor_totals.fixed}}</td>
						<td>{{dhivehiReportForm.minor_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.minor_totals.total}}</td>
					</tr>
					<tr>
						<td>ދުންފަތުގެ އިސްޓިޢުމާލް ކުރުން 14</td>
						<td>{{dhivehiReportForm.tobacco_totals.fixed}}</td>
						<td>{{dhivehiReportForm.tobacco_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.tobacco_totals.total}}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr ><th style="direction: rtl;text-align: right;">އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް</th></tr>
					<tr><td style="text-decoration: underline;">(ހ) ކާބޯތަކެތީގެ ޙިދުމަތް ދިނުމުގައު ހުންނަންޖެހޭ ސާފުތާހިރުކަމުގެ މިންގަނޑުތައް ބަޔާން ކުރާ ގަވާޢިދު (ގަވާއިދު ނަންބަރު: <span style="direction: ltr;">2014/R-380</span>) އެއްގިތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
					<tr><td>1. ސެކްސަން 1 ގައި ބަޔާން ކުރެވިފައިވާ ކަންތައްތައް ވަގުތުން ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_1"></td></tr>
					<tr><td>2. ސެކްސަން 2 ގައި ބަޔާންކުރެވިފައިވާ ކަންތައް__ ދުވަހުގެ ތެރޭގައި ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_2"></td></tr>
					<tr><td>3. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_3">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" disabled v-model="dhivehiReportForm.food_conclusion_3_date"></td></tr>
					<tr><td>4. ތަން ބަންދުކުރުމަށް ފެނޭ &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_4"></td></tr>
					<tr><td>5. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_5"></td></tr>
					<tr><td>6. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" disabled v-model="dhivehiReportForm.food_conclusion_6_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_6"></td></tr>
					<tr><td style="text-decoration: underline;">(ށ)‫ދުންފަތ‬ ‫ކޮންޓްރޯލ‬ ‫ކުރުމ‬ާ ބެހޭ ޤާނޫން (<span style="direction: ltr;">15/2010</span>) އާއި އެއްގިތްވާ ގޮތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
					<tr><td>1. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tobacco_conclusion_1">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" disabled v-model="dhivehiReportForm.tobacco_conclusion_3_date"></td></tr>
					<tr><td>2. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tobacco_conclusion_2"></td></tr>
					<tr><td>3. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" disabled v-model="dhivehiReportForm.tobacco_conclusion_3_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tobacco_conclusion_3"></td></tr>
				</table>
			</div>
		</div>

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
						<td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_1"></td>
						<td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_1"></td>
					</tr>
					<tr>
						<td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_2"></td>
						<td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_2"></td>
					</tr>
					<tr>
						<td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" disabled v-model="dhivehiReportForm.phi_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_3"></td>
						<td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_3"></td>
					</tr>
					<tr>
						<td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_4"></td>
						<td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_4"></td>
					</tr>
					<tr>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.phi_head_name}}</td>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.tpcs_head_name}}</td>
					</tr>
					<tr>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.phi_head_sign}}</td>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.tpcs_head_sign}}</td>
					</tr>
					<tr>
						<td>ތާރީޚް</td>
						<td>{{dhivehiReportForm.phi_head_date}}</td>
						<td>ތާރީޚް</td>
						<td>{{dhivehiReportForm.tpcs_head_date}}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th colspan="2" style="direction: rtl;text-align: right;">‫‫‪ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަނުގެ ފަރާތުން</th>
						<th colspan="2" style="direction: rtl;text-align: right;">ހެލްތު ޕްރޮޓެކްޝަން އެޖެންސީގެ ފަރާތުން</th>
					</tr>
					<tr>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.from_business_name}}</td>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.from_hpa_name}}</td>
					</tr>
					<tr>
						<td>މަޤާމް:</td>
						<td>{{dhivehiReportForm.from_business_position}}</td>
						<td>މަޤާމް:</td>
						<td>{{dhivehiReportForm.from_hpa_position}}</td>
					</tr>
					<tr>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.from_business_sign}}</td>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.from_hpa_sign}}</td>
					</tr>
					<tr>
						<td>ތާރީޚް:</td>
						<td>{{dhivehiReportForm.from_business_date}}</td>
						<td>ތާރީޚް:</td>
						<td>{{dhivehiReportForm.from_hpa_date}}</td>
					</tr>
				</table>
			</div>
		</div>


		<br>
		<div class="columns" v-if="statusChangeStatus">
			<div class="column">
				<div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
			</div>
		</div>

		<div class="columns no-print">
			<div class="column center">
			    <button class="button is-info is-large" @click="launchPrint()">ޕްރިންޓް ވިއު</button>
			    <button class="button is-warning is-large" @click="sendForEditing()">އަލުން ބަދަލު ގެނައުމަށް ފޮނުވާ</button>
			    <button class="button is-success is-large" @click="processed()">ޕްރޮސެސް ކޮށް ނިމުނީ</button>
			</div>
		</div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/dhivehi-reports-process.js')}}"></script>
@endsection
