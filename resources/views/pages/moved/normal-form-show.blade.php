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
				<tr><td colspan="6"><b>އިންސްޕެކްޓް ކުރި ބޭނުން:</b></td></tr>
				<tr>
					<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isAppliedFor('new_registration')"></td>
					<td>ރަޖިސްޓްރީ ކުރުމަށް،</td>
					<td><template v-if="isAppliedFor('new_registration')">{{normalForm.applied_date}}</template></td>
					<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isReason('routine')"></td>
					<td>ރޫޓީން އިންސްޕެކްޝަން</td>
				</tr>
				<tr>
					<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isAppliedFor('license_renewal')"></td>
					<td>ހުއްދަ އާކުރުމާ ގުޅިގެން</td>
					<td><template v-if="isAppliedFor('license_renewal')">{{normalForm.applied_date}}</template></td>
					<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isReason('spot_check')"></td>
					<td>ސްޕޮޓް ޗެކް</td>
				</tr>
				<tr>
					<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isAppliedFor('place_name_or_address_changed')"></td>
					<td> ތަނުގެ އެޑްރެސް / މެނޭޖްމަންޓް ބަދަލުވެގެން</td>
					<td><template v-if="isAppliedFor('place_name_or_address_changed')">{{normalForm.applied_date}}</template></td>
					<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isReason('complaint')"></td>
					<td>ޝަކުވާއާއި ގުޅިގެން</td>
				</tr>
			</table>

			<table class="table">
				<tr>
					<td colspan="4"><b>ތަނާއި ބެހޭ މަޢުލޫމާތު:</b></td>
				</tr>
				<tr>
					<td>ތަނުގެ ނަމާއި އެޑްރެސް</td>
					<td>{{normalForm.place_name_address}}</td>
					<td>ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
					<td>{{normalForm.registration_no}}</td>
				</tr>
				<tr>
					<td>ތަން ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
					<td>{{normalForm.place_owner_name_address}}</td>
					<td>ހުއްދަ ހަމަވާ  ތާރީޚް:</td>
					<td>{{normalForm.permit_expiry_date}}</td>
				</tr>
				<tr>
					<td>ގުޅޭނެ ނަމްބަރ:</td>
					<td>{{normalForm.phone}}</td>
					<td>
						ސާރވިންގ އޭރިޔާގެ އަދަދު: {{normalForm.serving_area_count}}
					</td>
					<td>
						ގޮނޑި ހުރި އަދަދު: {{normalForm.chair_count}}
					</td>
				</tr>
				<tr>
					<td>މަޢުލޫމާތު ދިން ފަރާތުގެ ނަމާއި ގުޅޭނެ ނަމްބަރު:</td>
					<td>{{normalForm.info_provider_name_no}}</td>
					<td>ތަނުގައި ބަދިގެ ހުރި އަދަދު:</td>
					<td>{{normalForm.kitchen_count}}</td>
				</tr>
				<tr>
					<td>އިންސްޕެކްޓް ކުރި ތާރީޚާއި ގަޑި:</td>
					<td>{{normalForm.inspected_at}}</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="columns">
		<div class="column dhivehi">
			<table class="table">
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
							<td><b>އިތުރު ބަޔާން</b></td>
						</tr>
				<template v-for="category in categorizedFormPoints">
						<tr>
							<td colspan="6"><b>{{category[0].category}}</b></td>
						</tr>
						<template v-for="item in category">
							<tr  v-bind:style="{ backgroundColor: rowColor(item) }">
								<td>{{item.no}}</td>
								<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.value"></td>
								<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.not_applicable"></td>
								<td>{{item.code}}</td>
								<td>{{item.text}}</td>
								<td style="max-width: 500px;">{{item.remarks}}</td>
							</tr>
						</template>
				</template>
			</table>
		</div>
	</div>

	<div class="columns dhivehi no-print">
		<div class="column center">
		    <button class="is-info button is-large" @click="launchPrint()">ޕްރިންޓް</button>
		</div>
	</div>

</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/normal-form-show.js')}}"></script>
@endsection
