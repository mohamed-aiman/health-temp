@extends('layouts.app')

@section('content')
@include('components.heading-dhivehi', ['title' => '‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭތަންތަން ބަލާ ފާސްކުރާ ފޯމް'])

@include('components.form-results')
<input type='hidden' id="form_id" value="{{(isset($form)) ? $form->id : null}}" />
@verbatim
<div class="container">
	<div class="columns">
		<div class="column dhivehi">
			<table class="table">
				<tr><td colspan="4"><b>ތަނާއި ބެހޭ މަޢުލޫމާތު:</b></td></tr>
				<tr>
					<td>ތަނުގެ ނަން</td>
					<td>{{gradingForm.place_name}}</td>
					<td>ކާބޯތަކެތީގެ ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
					<td>{{gradingForm.food_registration_no}}</td>
				</tr>
				<tr>
					<td>ތަން ހިންގާ ފަރާތް:</td>
					<td>{{gradingForm.owner}}</td>
					<td>ހުއްދައިގެ މުއްދަތު</td>
					<td>{{gradingForm.permit_limit}}</td>
				</tr>
				<tr>
					<td>ގުޅޭނެ ނަމްބަރ:</td>
					<td>{{gradingForm.phone}}</td>
					<td>ތާރީޚް:</td>
					<td>{{gradingForm.inspection_date}}</td>
				</tr>
				<tr>
					<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
					<td colspan="4">{{gradingForm.information_provider}}</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="columns">
		<div class="column dhivehi">
			<table class="table">
				<tr><td colspan="8"><b>ބަލާ ފާސް ކުރާ ސަބަބު:</b></td></tr>
				<tr>
					<td>ގްރޭޑް ކުރުމާއި ގުޅިގެން</td>
					<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="isReason('grading')"></td>
					<td>ހުއްދަ އާކުރުމާ ގުޅިގެން</td>
					<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="isReason('license_renewal')"></td>
					<td>ޝަކުވާއާއި ގުޅިގެން</td>
					<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="isReason('complaint')"></td>
					<td>ކޮމްޕްލިއެންސީ އޯޑިޓް</td>
					<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="isReason('compliance_audit')"></td>
				</tr>
				<tr>
					<td><b>ކޯޑް:</b></td>
					<td>މައިނަރ [MN]</td>
					<td>މޭޖަރ [MJ]</td>
					<td>ކްރިޓިކަލް [CR]</td>
					<td><b>ބަލަން ނުޖެހޭ: </b>[NA]</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="columns">
		<div class="column dhivehi">
			<table class="table">
						<tr>
							<td><b>#</b></td>
							<td><b>ފުރިހަމަވެފައި</b></td>
							<td><b>(NA) ބަލަން ނުޖެހޭ</b></td>
							<td><b>ކޯޑް</b></td>
							<td><b>މިންގަނޑު</b></td>
						</tr>
				<template v-for="category in categorizedFormPoints">
						<tr>
							<td colspan="5"><b>{{category[0].category}}</b></td>
						</tr>
						<tr v-for="item in category" >
							<td>{{item.no}}</td>
							<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.value"></td>
							<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.not_applicable"></td>
							<td>{{item.code}}</td>
							<td>{{item.text}}</td>
						</tr>
				</template>
			</table>
		</div>
	</div>

	<div class="columns dhivehi no-print">
		<div class="column" style="text-align: center;"><button class="is-info button is-large" @click="launchPrint()">ޕްރިންޓް</button></div>
	</div>

</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/grading-form-show.js')}}"></script>
@endsection
