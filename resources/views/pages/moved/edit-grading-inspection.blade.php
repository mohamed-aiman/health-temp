@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'grading-inspections.edit'">
@endverbatim
	@include('components.heading', ['title' => 'GradingInspection of ' . $inspection->business->name . ' (id:' . $inspection->id . ')'])
	<input type='hidden' id="inspection_id" value="{{(isset($inspection)) ? $inspection->id : null}}" />
	<div class="container">
	@verbatim
			<br>
			<div class="columns" v-if="editMode">
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
			<br/>

			<div class="columns" v-if="inspection">
				<div class="column box">
					<div class="columns">
						<div class="column">
						  <label class="label">Inspection Detail</label>
						</div>
					</div>
					<div class="columns">
						<div class="column">
						  <label class="label">Remarks: {{inspection.remarks}}</label>
						</div>
					</div>
					<div class="columns">
						<table class="table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Status</th>
									<th>Type</th>
									<th>Inspection At</th>
									<th>Follow Up</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{inspection.id}}</td>
									<td>{{inspection.status}}</td>
									<td v-if="!inspection.register_or_renew">{{inspection.reason}}</td>
									<td v-if="inspection.register_or_renew">{{inspection.register_or_renew}}(<a target='_blank' :href="'/applications/' + inspection.application_id + '/process'">{{inspection.application_id}}</a>)</td>
									<td>{{inspection.inspection_at}}</td>
									<td><a :href="'/inspections/' + inspection.follow_up_id">{{inspection.follow_up_id}}</a></td>
									<td>
										<div class="tags">
											<div class="tag is-warning" v-if="inspection.is_followup_required">followup required</div>
											<div class="tag is-danger" v-if="inspection.is_fined">fined</div>
										</div>
									</td>
									<td>
					                  	<p class="buttons">
											  <a class="button" v-bind:class="[(inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(inspection, 'dv')">
											    <span class="icon is-small">
											      <i class="fa fa-book"></i>
											    </span>
									        <span>Dv</span>
											  </a>
											  <a class="button" v-bind:class="[(inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(inspection,'en')">
											    <span class="icon is-small">
											      <i class="fa fa-book"></i>
											    </span>
									        <span>En</span>
											  </a>
										  <a class="button is-warning" alt="dhivehi report" @click="toggleEditItemMode(inspection)">
										    <span class="icon is-small">
										      <i class="fa fa-edit"></i>
										    </span>
										  </a>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<br>
			
			<div class="columns" v-if="inspection.follow_up_inspection">
				<div class="column box">
					<div class="columns">
							<div class="column">
							  <label class="label">Followup Inspection</label>
							</div>
					</div>
					<div class="columns">
						<table class="table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Status</th>
									<th>Register/Renewal</th>
									<th>Inspection At</th>
									<th>Follow Up</th>
									<th></th>
									<th>Report</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{item.id}}</td>
									<td>{{item.status}}</td>
									<td>{{item.register_or_renew}}(<a target='_blank' :href="'/applications/' + item.application_id + '/process'">{{item.application_id}}</a>)</td>
									<td>{{item.inspection_at}}</td>
									<td><a :href="'/inspections/' + item.follow_up_id">{{item.follow_up_id}}</a></td>
									<td>
										<div class="tags">
											<div class="tag is-warning" v-if="item.is_followup_required">followup required</div>
											<div class="tag is-danger" v-if="item.is_fined">fined</div>
										</div>
									</td>
									<td>
					                  	<p class="buttons">
											  <a class="button" v-bind:class="[(item.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(item, 'dv')">
											    <span class="icon is-small">
											      <i class="fa fa-book"></i>
											    </span>
									        <span>Dv</span>
											  </a>
											  <a class="button" v-bind:class="[(item.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(item,'en')">
											    <span class="icon is-small">
											      <i class="fa fa-book"></i>
											    </span>
									        <span>En</span>
											  </a>
										</p>
									</td>
									<td>
										<p class="buttons">
										  <a class="button is-warning" alt="dhivehi report" @click="toggleEditItemMode(item)">
										    <span class="icon is-small">
										      <i class="fa fa-edit"></i>
										    </span>
										  </a>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<br/>
			<div class="columns">
				<div class="column box">
					<div class="columns">
						<div class="column">
						  <div class="label is-normal">
						    <label class="label">Tools</label>
						  </div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
					        <div class="field">
					            <b-switch 
					            v-model="isFollowUpRequired"
					            @input="changedisFollowUpRequired"
					            type="is-warning">
					                Followup is required
					            </b-switch>
					        </div>
						</div>
						<div class="column">
					        <div class="field">
					            <b-switch 
					            v-model="isFined"
					            @input="changedisFined"
					            type="is-danger">
					                Fined
					            </b-switch>
					        </div>
						</div>
					</div>
					<div class="columns" v-if="isFined">
						<div class="column">
						  <div class="label is-normal">
						    <label class="label">Fine Details</label>
						  </div>
						</div>
					</div>
					<div class="columns" v-if="isFined">
		        		<div class="column">
							<div class="field">
			        			Amount: <input type="number" name="amount" v-model="fineForm.amount" class="input">
					        </div>
		        		</div>
		        		<div class="column">
							<div class="field">
		        				Fined On: 
						        <b-datepicker
						            placeholder="Click to select..."
						            icon="calendar-today"
						            editable
						            v-model="fineForm.fined_on">
						        </b-datepicker>
							</div> 
		        		</div>
		        		<div class="column" v-if="!fineForm.is_paid">
		        			<br/>
							<div class="field">
					            <b-switch 
					            v-model="payEnabled"
					            type="is-danger">
					                Enable Pay
					            </b-switch>
					        </div>
		        		</div>
		        		<div class="column" v-if="fineForm.is_paid || payEnabled">
							<div class="field">
		        				Paid On: 
						        <b-datepicker
						            placeholder="Click to select..."
						            icon="calendar-today"
						            editable
						            v-model="fineForm.paid_on">
						        </b-datepicker>
							</div>
		        		</div>
		        		<div class="column" v-if="fineForm.is_paid || payEnabled">
							<div class="field">
		        				Receipt No: <input type="text" name="receipt_no" v-model="fineForm.receipt_no" class="input">
							</div>
		        		</div>
		        		<div class="column">
		        			<br>
		        			<p class="buttons">
							  <a class="button is-success"  @click="saveFine()">
							    <span class="icon is-small">
							      <i class="fa fa-save"></i>
							    </span>
							  </a>
							  <a class="button is-warning" @click="deleteFine()">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
							</p>
		        		</div>
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column box">
					<div class="columns">
		        		<div class="column">
		        			<br/>
							<div class="field">
					            <b-switch 
					            v-model="enableHandover"
					            type="is-success">
					                Reports handed over
					            </b-switch>
					        </div>
		        		</div>
					</div>
					<div class="columns" v-if="enableHandover">
						<div class="column">
							Handed over Date and Time
						</div>
						<div class="column">
							<div class="field">
						        <b-datepicker
						            placeholder="Click to select..."
						            icon="calendar-today"
	                      			@input="datePickerInput"
	                      			editable
						            v-model="inspectionForm.date">
						        </b-datepicker>
							</div>
						</div>
						<div class="column">
							<div class="field">
						        <b-timepicker
						            placeholder="Type or select a date..."
						            icon="clock"
						            editable
	                      			@input="timePickerInput"
						            v-model="inspectionForm.time">
						        </b-timepicker>
							</div>
						</div>
						<div class="column">
		        			<p class="buttons">
							  <a class="button is-success"  @click="saveReportsHandedOver()">
							    <span class="icon is-small">
							      <i class="fa fa-save"></i>
							    </span>
							  </a>
							  <a class="button is-warning" @click="deleteReportsHandedOver()">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
							</p>
						</div>
					</div>
				</div>
			</div>
			<br>
		<br>
	@endverbatim
	</div>
</div>
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/edit-grading-inspection.js')}}"></script>
@endsection