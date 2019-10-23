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
				<tr><td colspan="4">ތަނާއި ބެހޭ މަޢުލޫމާތު:</td></tr>
				<tr>
					<td>ތަނުގެ ނަން</td>
					<td><input type="text" class="input" v-model="gradingForm.place_name"></td>
					<td>ކާބޯތަކެތީގެ ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
					<td><input type="text" class="input" v-model="gradingForm.food_registration_no"></td>
				</tr>
				<tr>
					<td>ތަން ހިންގާ ފަރާތް:</td>
					<td><input type="text" class="input" v-model="gradingForm.owner"></td>
					<td>ހުއްދައިގެ މުއްދަތު</td>
					<td><input type="text" class="input" v-model="gradingForm.permit_limit"></td>
				</tr>
				<tr>
					<td>ގުޅޭނެ ނަމްބަރ:</td>
					<td><input type="text" class="input" v-model="gradingForm.phone"></td>
					<td>ތާރީޚް:</td>
					<td><input type="text" class="input" v-model="gradingForm.inspection_date"></td>
				</tr>
				<tr>
					<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
					<td colspan="4"><input type="text" class="input" v-model="gradingForm.information_provider"></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="columns">
		<div class="column dhivehi">
			<table class="table">
				<tr><td colspan="8">ބަލާ ފާސް ކުރާ ސަބަބު:</td></tr>
<!-- 				<tr>
					<td>ގްރޭޑް ކުރުމާއި ގުޅިގެން</td>
					<td><input type="checkbox" class="checkbox" value="grading"></td>
					<td>ހުއްދަ އާކުރުމާ ގުޅިގެން</td>
					<td><input type="checkbox" class="checkbox" value="license_renewal"></td>
					<td>ޝަކުވާއާއި ގުޅިގެން</td>
					<td><input type="checkbox" class="checkbox" value="complaint"></td>
					<td>ކޮމްޕްލިއެންސީ އޯޑިޓް</td>
					<td><input type="checkbox" class="checkbox" value="compliance_audit"></td>
				</tr> -->
				<tr>
					<td colspan="8">
						<div class="select">
							<select v-model="gradingForm.reason">
								<option value="grading">ގްރޭޑް ކުރުމާއި ގުޅިގެން</option>
								<option value="license_renewal">ހުއްދަ އާކުރުމާ ގުޅިގެން</option>
								<option value="complaint">ޝަކުވާއާއި ގުޅިގެން</option>
								<option value="compliance_audit">ކޮމްޕްލިއެންސީ އޯޑިޓް</option>
							</select>
						</div>
					</td>
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

	<div class="columns dhivehi">
		<div class="column"></div>
		<div class="column" style="text-align: center;">
			<button class="is-warning button is-large" @click="savePlaceInfoReason()">
				ތަނާއި ބެހޭ މައުލޫމާތު އަދި ސަބަބު އަދާ ހަމަ ކުރޭ
			</button>
		</div>
		<div class="column"></div>
	</div>
	<hr>
	<div class="columns dhivehi">
		<div class="column" style="text-align: center;">
			<div class="box">
			ތިރާގައިވާ ޗެކް ބޮކްސްތަކުގައި ފާހަގަ ޖެހުމުން އޮޓޯއިން އެ މިންގަނޑެއް އަދާހަމަ ކުރެވޭނެއެވެ.
			</div>
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
							<td><input type="checkbox" v-model="item.value" @change="changedValue(item)"></td>
							<td><input type="checkbox" v-model="item.not_applicable" @change="changedNotApplicable(item)"></td>
							<td>{{item.code}}</td>
							<td>{{item.text}}</td>
						</tr>
				</template>
			</table>
		</div>
	</div>

	<div class="columns dhivehi">
		<div class="column"></div>
		<div class="column" style="text-align: center;">
			<button class="is-info button is-large" @click="goToShow()">
				ވިއު ކުރުމަށް
			</button>
		</div>
		<div class="column"></div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/grading-form-edit.js')}}"></script>
@endsection
