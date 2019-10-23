@extends('layouts.app')

@section('content')

@verbatim
<div v-can="'applications.process'">
@endverbatim

	@include('components.heading', ['title' => '‫Process Pending Application'])

	@include('components.form-results')
	<input type='hidden' id="application_id" value="{{(isset($application)) ? $application->id : null}}" />
	@verbatim

	<template id="attached-to-business" v-if="application.business_id">
		<div class="columns">
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
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<template id="inspection">
			<div class="columns">
				<div class="column">
					<template v-if="application.inspections.length<=0">
						<table v-can="'applications.inspections.store'" class="table is-fullwidth is-narrow is-bordered">
							<tr><td colspan="5"><b>Schedule an Inspection</b></td></tr>
							<tr>
								<td>
									<template>
								    <b-field label="Select Date">
								        <b-datepicker
													placeholder="Click to select..."
													icon="calendar-today"
													@input="datePickerInput"
													v-model="inspectionForm.date">
								        </b-datepicker>
								    </b-field>
									</template>
								</td>
								<td>
									<template>
								    <b-field label="Select Time">
								        <b-timepicker
								            placeholder="Type or select a date..."
								            icon="clock"
								            editable
								            v-model="inspectionForm.time">
								        </b-timepicker>
								    </b-field>
									</template>
								<td>
									<div class="field">
									  <label class="label">Permit Type</label>
										<div class="select">
										  <select disabled >
										    <option>{{application.permit_type}}</option>
										  </select>
										</div>
									</div>
								</td>
								<td>
									<div class="field">
									  <label class="label">Type</label>
										<div class="select">
										  <select disabled v-model="form._1applicationType">
										    <option value="1">New Registration</option>
										    <option value="2">License Renewal</option>
										  </select>
										</div>
									</div>
								</td>
								<td>
									<div class="field">
									  <label class="label">&nbsp</label>
									  <div class="control">
									    <button class="button is-link" @click="submitSaveInspection">Save Inspection</button>
									  </div>
									</div>
								</td>
							</tr>
						</table>
					</template>
					<template v-if="editMode">
							<div class="columns">
								<div class="column box">
									<div class="columns">
										<div class="column">
										  <div class="label is-normal">
										    <label class="label">Updating Inspection id: {{inspectionForm2.inspection_id}}</label>
										  </div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
											<div class="field">
											  <label class="label">Status</label>
												<div class="select">
												  <select v-model="inspectionForm2.status">
												    <option value="scheduled">Scheduled</option>
												    <option value="finished">Finished</option>
												    <option value="cancelled">Cancelled</option>
												  </select>
												</div>
											</div>
										</div>
										<div class="column">
											<div class="field">
												<template>
												    <b-field label="Select a date">
												        <b-datepicker
												            placeholder="Click to select..."
												            icon="calendar-today"
							                      			@input="datePickerInput2"
												            v-model="inspectionForm2.date">
												        </b-datepicker>
												    </b-field>
												</template>
											</div>
										</div>
										<div class="column">
											<div class="field">
											  <template>
												    <b-field label="Select timepicker">
												        <b-timepicker
												            placeholder="Type or select a date..."
												            icon="clock"
												            editable
							                      			@input="timePickerInput2"
												            v-model="inspectionForm2.time">
												        </b-timepicker>
												    </b-field>
												</template>
											</div>
										</div>
										<div class="column" v-if="inspectionForm2.type">
											<div class="field">
											  <label class="label">Type</label>
												<div class="select">
												  <select disabled v-model="inspectionForm2.type">
												    <option value="1">New Registration</option>
												    <option value="2">License Renewal</option>
												  </select>
												</div>
											</div>
										</div>
										<div class="column" v-if="!inspectionForm2.type">
											<div class="field">
											  <label class="label">Type</label>
												<div class="select">
													<select v-model="inspectionForm2.reason">
														<option value="complaint" selected>Complaint</option>
														<option value="routine">Routine</option>
														<option value="unspecified">Unspecified </option>
													</select>
												</div>
											</div>
										</div>
										<div class="column">
											<div class="field">
											  <label class="label">Remarks</label>
												<div class="input control">
													<input type="text" placeholder="remarks" class="input" v-model="inspectionForm2.remarks">
												</div>
											</div>
										</div>
										<div class="column">
											<div class="field">
											  <label class="label">&nbsp</label>
											  <div class="control">
											    <button class="button is-link" @click="updateInspection">Update Inspection</button>
											  </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</template>

					<template v-if="application.inspections.length>0">
						<table class="table is-fullwidth is-narrow is-bordered">
							<tr>
								<th colspan="5">Inspections</th>
							</tr>
							<tr>
								<th>Id</th>
								<th>Status</th>
								<th>Inspection Time</th>
								<th>Applied For</th>
								<th>Options</th>
							</tr>
							<tr v-for="inspection in application.inspections">
								<td>{{inspection.id}}</td>
								<td>{{inspection.status}}</td>
								<td>{{inspection.inspection_at}}</td>
								<td>{{application.permit_type}} ({{application.register_or_renew}})</td>
								<td>
									<p class="buttons">
									  <a class="button is-danger" v-can="'inspections.destroy'" @click="deleteInspection(inspection)">
									    <span class="icon is-small">
									      <i class="fa fa-times"></i>
									    </span>
									  </a>
									  <a class="button is-warning"  v-can="'inspections.update'" @click="toggleEditItemMode(inspection)">
									    <span class="icon is-small">
									      <i class="fa fa-edit"></i>
									    </span>
									  </a>
									  <a class="button is-info" v-can="'inspections.show'" :href="'/inspections/' + inspection.id">
									    <span class="icon is-small">
									      <i class="fa fa-eye"></i>
									    </span>
									  </a>
									</p>
								</td>
							</tr>
						</table>
					</template>
				</div>
			</div>
		</template>
	</template>


	<div class="box">
		@endverbatim
		@include('components.application-view-body')
		@verbatim
	</div>

	<br>
	<div class="columns" v-if="statusChangeStatus">
		<div class="column">
			<div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
		</div>
	</div>

		<div class="columns dhivehi no-print">
			<div class="column center">
			    <button class="button is-info is-large" v-can="'applications.show'" @click="goToApplication()">ޕްރިންޓް ވިއު</button>
			    <button class="button is-warning is-large" v-can="'applications.update'" @click="sendForEditing()">އަލުން ބަދަލު ގެނައުމަށް ފޮނުވާ</button>
			    <button class="button is-success is-large" v-can="'applications.processed'" @click="processed()">ޕްރޮސެސްކޮށް ނިމުނީ</button>
			</div>
		</div>
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/applications-process.js')}}"></script>
@endsection
