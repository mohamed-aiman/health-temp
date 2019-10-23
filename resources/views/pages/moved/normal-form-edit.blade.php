@extends('layouts.app')

@section('content')
@include('components.heading-dhivehi', ['title' => '‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ބަލާ ފާސްކުރާ ޗެކްލިސްޓް'])

@include('components.form-results')
<input type='hidden' id="form_id" value="{{(isset($form)) ? $form->id : null}}" />
@verbatim
<div class="container">
	<div class="columns">
		<div class="column dhivehi">
			<table class="table">
				<tr><td colspan="4">‫<b>އިންސްޕެކްޓް ކުރި ބޭނުން:</b></td></tr>
				<tr>
					<td class="fit">
						<div class="select">
							<select v-model="normalForm.applied_for">
								<option value="new_registration">ރަޖިސްޓްރީ ކުރުމަށް،</option>
								<option value="license_renewal">ހުއްދަ އާކުރުމާ ގުޅިގެން</option>
								<option value="place_name_or_address_changed"> ތަނުގެ އެޑްރެސް / މެނޭޖްމަންޓް ބަދަލުވެގެން</option>
							</select>
						</div>
					</td>
					<td class="fit">ހުށަހެޅި  ތާރީޚް:</td>
					<td><input type="text" class="input" v-model="normalForm.applied_date"></td>
					<td>
						<div class="select">
							<select v-model="normalForm.reason">
								<option value="routine">ރޫޓީން އިންސްޕެކްޝަން </option>
								<option value="spot_check">ސްޕޮޓް ޗެކް</option>
								<option value="complaint">ޝަކުވާއާއި ގުޅިގެން</option>
							</select>
						</div>
					</td>
				</tr>
			</table>
			<table class="table">
				<tr>
					<td colspan="4"><b>ތަނާއި ބެހޭ މަޢުލޫމާތު:</b></td>
				</tr>
				<tr>
					<td>ތަނުގެ ނަމާއި އެޑްރެސް</td>
					<td><input type="text" class="input" v-model="normalForm.place_name_address"></td>
					<td>ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
					<td><input type="text" class="input" v-model="normalForm.registration_no"></td>
				</tr>
				<tr>
					<td>ތަން ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
					<td><input type="text" class="input" v-model="normalForm.place_owner_name_address"></td>
					<td>ހުއްދަ ހަމަވާ  ތާރީޚް:</td>
					<td><input type="text" class="input" v-model="normalForm.permit_expiry_date"></td>
				</tr>
				<tr>
					<td>ގުޅޭނެ ނަމްބަރ:</td>
					<td><input type="text" class="input" v-model="normalForm.phone"></td>
					<td>
						<div class="columns">
							<div class="column">ސާރވިންގ އޭރިޔާގެ އަދަދު:</div>
						</div>
					</td>
					<td>
						<div class="columns">
							<div class="column"><input type="number" class="input" v-model="normalForm.serving_area_count"></div>
							<div class="column">ގޮނޑި ހުރި އަދަދު:</div>
							<div class="column"><input type="number" class="input" v-model="normalForm.chair_count"></div>
						</div>
					</td>
				</tr>
				<tr>
					<td>މަޢުލޫމާތު ދިން ފަރާތުގެ ނަމާއި ގުޅޭނެ ނަމްބަރު:</td>
					<td><input type="text" class="input" v-model="normalForm.info_provider_name_no"></td>
					<td>ތަނުގައި ބަދިގެ ހުރި އަދަދު:</td>
					<td><input type="number" class="input" v-model="normalForm.kitchen_count"></td>
				</tr>
				<tr>
					<td>އިންސްޕެކްޓް ކުރި ތާރީޚާއި ގަޑި:</td>
					<td><input type="text" class="input" v-model="normalForm.inspected_at"></td>
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
							<td><b>އިތުރު ބަޔާން</b></td>
						</tr>
				<template v-for="category in categorizedFormPoints">
						<tr>
							<td colspan="6"><b>{{category[0].category}}</b></td>
						</tr>
						<template v-for="item in category">
							<tr  v-bind:style="{ backgroundColor: rowColor(item) }">
								<td>{{item.no}}</td>
								<td><input type="checkbox" v-model="item.value" @change="changedValue(item)"></td>
								<td><input type="checkbox" v-model="item.not_applicable" @change="changedNotApplicable(item)"></td>
								<td>{{item.code}}</td>
								<td>{{item.text}}</td>
								<td style="max-width: 500px;">
									<span class="is-dark no-print" @click="openRemarksForm(item)">
							            <b-icon v-if="!item.remarks" icon="comment" size="is-small"></b-icon>
							            <b-icon v-if="item.remarks" icon="pencil" size="is-small"></b-icon>
							        </span>
									<span v-if="item.remarks">{{item.remarks}}</span>
								</td>
							</tr>
						</template>
				</template>
			</table>
		</div>
	</div>

<b-modal :active.sync="isRemarksModalActive" has-modal-card>
	<div class="columns modal-card">
		<response-messages :response.sync="remarksResponse"></response-messages>
		<div class="column box">
			<div class="columns">
				<div class="column left">
				  <div class="label is-normal">
				    <label class="label">Add/Edit Remarks</label>
				  </div>
				</div>
				<div class="column">
					<div class="field is-pulled-right">
					  <div class="control">
					    <button class="button is-link" @click="saveRemarks">Save</button>
					  </div>
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<div class="field">
					  <label class="label">Comment</label>
						<div class="control">
							<textarea rows="10" placeholder="remarks" class="textarea dhivehi" v-model="remarksForm.remarks"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</b-modal>


<div class="columns" v-if="statusChangeStatus">
	<div class="column">
		<div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
	</div>
</div>

	<div class="columns dhivehi">
		<div class="column"></div>
		<div class="column" style="text-align: center;">
			<button class="is-info button is-large" @click="goToShow()">
				ވިއު ކުރުމަށް
			</button>
			<button class="is-success button is-large" @click="sendForProcessing()">
				ޕްރޮސެސިން އަށް ފޮނުވާ
			</button>
		</div>
		<div class="column"></div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/normal-form-edit.js')}}"></script>
@endsection
