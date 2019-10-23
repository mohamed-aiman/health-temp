@extends('layouts.app')

@section('content')

@verbatim
<div v-can="'applications.update'">
@endverbatim

@include('components.heading-dhivehi', ['title' => '‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް'])

@include('components.form-results')
<input type='hidden' id="application_id" value="{{(isset($application)) ? $application->id : null}}" />
	@csrf
@verbatim
	<template id="attached-to-business" v-if="application.business_id && business">
		<div class="columns" v-can="'businesses.show'">
			<div class="column">
				<table class="table is-fullwidth is-narrow is-bordered">
					<tr><td colspan="2"><b>Business Details</b></td></tr>
					<tr><td>English Name</td><td>{{business.name}}</td></tr>
					<tr><td>Dhivehi Name</td><td><p class="dhivehi">{{business.name_dv}}</p></td></tr>
					<tr><td>Registration No.</td><td>{{business.registration_no}}</td></tr>
					<tr><td>Phone No.</td><td>{{business.phone}}</td></tr>
					<tr>
						<td colspan="2" class="center">
							<a class="button is-link" target='_blank'  :href="'/businesses/'+business.id">View Business</a>
							<button class="button is-danger" @click="submitRemoveBusinessFromApplication">Remove Business From Application</button>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</template>

	<template id="not-attached-to-business" v-if="!application.business_id">
		<div class="columns">
			<div class="column">
				Not Attached To A Business Yet
			</div>
		</div>

		<template v-if="showAttachToExistingBusiness">
			<div class="columns">
				<div class="column">
					<template id="business-selected" v-if="selectedBusiness">
						<label class="label">Selected Business</label>
						<table class="table is-bordered is-hoverable is-fullwidth">
							<tr>
								<td>{{selectedBusiness.name}}</td>
								<td>{{selectedBusiness.registration_no}}</td>
								<td>{{selectedBusiness.phone}}</td>
								<td class="right">
									<a class="button is-link" target='_blank'  :href="'/businesses/'+selectedBusiness.id">View Business</a>
									<button class="button is-link" @click="submitAttachToSelectedBusiness">Attach to the selected Business</button>
									<button class="button is-link" @click="toggleShowNewBusinessRegistration">Create New</button>
									<button class="button is-link" @click="togglelSearchForAnother">Search for Another Business</button>
								</td>
							</tr>
						</table>
					</template>
					<template id="no-business-selected" v-if="!selectedBusiness">
						<label class="label">No business is selected</label>
						<table class="table is-bordered is-hoverable is-fullwidth">
							<tr>
								<td>
									<button class="button is-link" @click="toggleShowNewBusinessRegistration">Create New</button>
									<button class="button is-link" @click="togglelSearchForAnother">Search Existing Business</button>
								</td>
							</tr>
						</table>
					</template>
					<template id="search" v-if="searchForAnother">
							<table  class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
								<tr>
									<td colspan="3">
									  <div class="label is-normal">
									    <label class="label">Search for a business to attach to</label>
									  </div>
									</td>
								</tr>
								<tr>
									<td colspan="3">
									  <input class="input" name="businessesSearchTerm" type="text" v-model="businessesSearchTerm" placeholder="Business name or registration no or phone">
									</td>
								</tr>
								<tr v-if="businesses.length > 0">
									<td>Name</td>
									<td>Registration No.</td>
									<td>Phone No.</td>
								</tr>
								<template v-for="item in businesses">
									<tr @click="selectBusiness(item)">
										<td>{{item.name}}</td>
										<td>{{item.registration_no}}</td>
										<td>{{item.phone}}</td>
									</tr>
								</template>
							</table>
					</template>
				</div>
			</div>
		</template>

		<template id="business-registration-form" v-if="showNewBusinessRegistration">
			<div class="columns">
				<div class="column">
					<table class="table is-narrow is-fullwidth is-bordered">
						<tr>
							<td colspan="2">
							  <div class="label is-normal">
							    <label class="label" v-show="application._1applicationType == '1'">Add new business entity (Register New Business)</label>
							    <label class="label" v-show="application._1applicationType == '2'">Add new business entity (Licence Renewal Application)</label>
							  </div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<response-messages :response.sync="saveNewBusinessResponse"></response-messages>
							</td>
						</tr>
						<tr><td>English Name</td><td><input class="input" name="name" type="text" v-model="businessRegForm.name" placeholder="Business name"></td></tr>
						<tr><td>Dhivehi Name</td><td><input class="input dhivehi" name="name_dv" type="text" v-model="businessRegForm.name_dv" placeholder="ދިވެހި ނަން"></td></tr>
						<tr><td>Registration Number</td><td><input class="input" name="registration_no" type="text" v-model="businessRegForm.registration_no" placeholder="registration no"></td></tr>
						<tr><td>Phone</td><td><input class="input" name="phone" type="text" v-model="businessRegForm.phone" placeholder="phone"></td></tr>
						<tr><td class="center" colspan="2"><button class="button is-link" @click="submitNewBusinessForm">Save and Attach to New Business</button></td></tr>
					</table>
				</div>
			</div>
		</template>
	</template>

	<div class="container">
		@endverbatim
		@include('components.application-form-body')
		@verbatim



	<div class="columns" v-if="statusChangeStatus">
		<div class="column">
			<div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
		</div>
	</div>

		<div class="columns dhivehi no-print">
			<div class="column center">
			    <button class="button is-danger is-large" @click="deleteApplication()">ފުހެލާ</button>
			    <button class="button is-warning is-large" @click="onSubmit()">އަދާހަމަ ކުރޭ</button>
			    <button class="button is-primary is-large" @click="getApplication()">ކެންސަލް</button>
			    <button class="button is-info is-large" @click="goToApplication()">ޕްރިންޓް ވިއު</button>
			    <button class="button is-success is-large" @click="sendForProcessing()">އެޕްރޫވް ކުރުމަށް ފޮނުވާ</button>
			</div>
		</div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/applications-edit.js')}}"></script>
@endsection
