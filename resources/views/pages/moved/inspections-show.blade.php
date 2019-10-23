@extends('layouts.app')

@section('content')
@include('components.heading', ['title' => 'Inspection of ' . $inspection->business->name . ' (id:' . $inspection->id . ')'])
<input type='hidden' id="inspection_id" value="{{(isset($inspection)) ? $inspection->id : null}}" />
@verbatim


<template id="business_details" v-if="inspection.business != null">
	<div class="box">
		<business-details :business="inspection.business">
			<template>
				<tr>
					<td colspan="2" class="center">
						<div>
							<button class="button is-warning" @click="openNewFineForm()">Fine</button>
							<button class="button is-danger" @click="openTerminateForm()">Terminate</button>
						</div>
					</td>
				</tr>
				<tr v-if="isNewFineFormOpened">
					<td colspan="2">
						<div class="columns">
				    <div class="column"><div class="field">Amount: <input type="number" name="amount" v-model="fineForm.amount" class="input"></div></div>
				    <div class="column"><div class="field">Fined On: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="fineForm.fined_on"></b-datepicker></div></div>
				    <div class="column"><div class="field">Remarks: <input type="text" name="remarks" v-model="fineForm.remarks" class="input"></div></div>
				      <div class="column">
				        	<br>
				        	<p class="buttons">
									  <a class="button is-success"  @click="addFine()">
									    <span class="icon is-small">
									      <i class="fa fa-plus"></i>
									    </span>
									  </a>
									</p>
				    	</div>
				   	</div>
				 	</td>
				</tr>
				<tr v-if="isTerminateFormOpened">
					<td colspan="2">
						<div class="columns">
				    <div class="column"><div class="field">Reason: <input type="text" name="reason" v-model="terminateForm.reason" class="input"></div></div>
				    <div class="column"><div class="field">Terminated On: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="terminateForm.terminated_on"></b-datepicker></div></div>
			      <div class="column">
			        	<br>
			        	<p class="buttons">
								  <a class="button is-danger"  @click="saveTermination()">
								    <span class="icon is-small">
								      <i class="fa fa-save"></i>
								    </span>
								  </a>
								</p>
			    	</div>
				   	</div>
				 	</td>
				</tr>
			</template>
		</business-details>

		<div class="columns">
			<div class="column">
				<table v-if="fines.length>0" class="table is-narrow is-bordered is-fullwidth">
					<tr>
						<th colspan="5">Fines</th>
					</tr>
					<tr v-if="isUpdateFineFormOpened">
						<td colspan="5">
							<div class="columns">
				        <div class="column"><div class="field">Amount: <input type="number" name="amount" v-model="fineForm2.amount" class="input"></div></div>
				        <div class="column"><div class="field">Fined On: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="fineForm2.fined_on"></b-datepicker></div></div>
				        <div class="column"><div class="field">Remarks: <input type="text" name="remarks" v-model="fineForm2.remarks" class="input"></div></div>
					      <div class="column">
				        	<br>
				        	<p class="buttons">
									  <a class="button is-warning"  @click="updateFine()">
									    <span class="icon is-small">
									      <i class="fa fa-save"></i>
									    </span>
									  </a>
									</p>
			        	</div>
			       	</div>
			     	</td>
			   	</tr>
					<tr>
						<td>Id</td>
						<td>Fined On</td>
						<td>Amount (MVR)</td>
						<td>Remarks</td>
						<td>Options</td>
					</tr>
					<tr v-for="item in fines">
						<td>{{item.id}}</td>
						<td>{{item.fined_on}}</td>
						<td>{{item.amount}}</td>
						<td>{{item.remarks}}</td>
						<td>
							<a v-if="!item.is_paid" class="button is-warning"  @click="loadFineForm(item)">
								<span class="icon is-small">
						      <i class="fa fa-edit"></i>
						    </span>
						  </a>
				  			<a v-if="!item.is_paid" class="button is-danger" @click="deleteFine(item)">
							    <span class="icon is-small">
							      <i class="fa fa-close"></i>
							    </span>
							  </a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>


<template id="inspection-details"  v-if="inspection != null">
	<div class="box">


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




		<div class="columns">
			<div class="column">
				<table class="table is-narrow is-bordered is-fullwidth">
					<thead>
						<tr>
							<th colspan="7"><a class="is-link"  target='_blank' :href="'/inspections/' + inspection.id">Inspection Details</a>
						</tr>
						<tr>
							<th>Id</th>
							<th>Status</th>
							<th>Type</th>
							<th>Inspection At</th>
							<th v-if="(inspection.follow_up_inspection) || (inspection.fines.length>0)">Tags</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{inspection.id}}</td>
							<td>{{inspection.status}}</td>
							<td v-if="!inspection.register_or_renew">{{inspection.reason}}</td>
							<td v-if="inspection.register_or_renew">{{inspection.register_or_renew}}(<a target='_blank' :href="'/applications/' + inspection.application_id + '/process'">{{inspection.application_id}}</a>)</td>
							<td>{{inspection.inspection_at}}</td>
							<td v-if="(inspection.follow_up_inspection) || (inspection.fines.length>0)">
								<div class="tags">
									<div class="tag is-warning" v-if="inspection.follow_up_inspection">followup required({{inspection.follow_up_id}})</div>
									<div class="tag is-danger" v-if="inspection.fines.length>0">fined</div>
								</div>
							</td>
							<td>
			            		<p class="buttons">
								  	<a class="button is-info" target='_blank' :href="'/normalforms/'+inspection.normal_form_id">
									    <span class="icon is-small">
									      <i class="fa fa-eye"></i>
									    </span>
									    <span>Check List</span>
								  	</a>
							        <button class="button is-warning is-success"
							            @click="isComponentModalActive = true">
							            Schedule a new Inspection
							        </button>
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
				<template>
				    <section>
				     <b-modal :active.sync="isComponentModalActive" has-modal-card>
				     	<div class="container">
								<div class="columns modal-card" style="width: auto;">
									<div class="column box">
										<div class="columns">
											<div class="column">
											  <div class="label is-normal">
											    <label class="label">Schedule an Inspection</label>
											  </div>
											</div>
										</div>
										<div class="columns">
											<div class="column">
												<div class="field">
													<template>
													    <b-field label="Date">
													        <b-datepicker
													            placeholder="Click to select..."
													            inline 
													            icon="calendar-today"
								                      @input="datePickerInput"
													            v-model="inspectionForm.date">
													        </b-datepicker>
													    </b-field>
													</template>
												</div>
											</div>
											<div class="column">
												<div class="field">
												  <template>
													    <b-field label="Time">
													        <b-timepicker
													            placeholder="Type or select a date..."
													            inline 
													            icon="clock"
													            editable
													            v-model="inspectionForm.time">
													        </b-timepicker>
													    </b-field>
													</template>
												</div>
											</div>
											<div class="column">
												<div class="field">
												  <label class="label">Reason</label>
													<div class="select control">
														<select v-model="inspectionForm.reason">
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
													<div class="control">
														<input type="text" placeholder="remarks" class="input" v-model="inspectionForm.remarks">
													</div>
												</div>
											</div>
											<div class="column">
												<div class="field">
												  <label class="label">&nbsp</label>
												  <div class="control">
												    <button class="button is-link" @click="saveInspection">Save Inspection</button>
												  </div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							</b-modal>
				    </section>
				</template>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<table class="table is-narrow is-bordered is-fullwidth">
					<tr>
						<th><div class="pull-left">Reports</div></th>
					</tr>
					<tr>
						<td><div class="pull-left">Dhivehi Report</div>
		            		<p class="buttons pull-right">
								<a class="button" v-bind:class="[(inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(inspection, 'dv')">
								    <span class="icon is-small">
								      <i class="fa fa-eye"></i>
								    </span>
								</a>
							  	<a class="button is-warning" target='_blank' :href="'/dhivehi/reports/'+inspection.dhivehi_report_id+'/handover/'">
								    <span class="icon is-small">
								      <i class="fa fa-handshake"></i>
								    </span>
								    <span>Handover</span>
							  	</a>
							</p>
						</td>
					</tr>
					<tr>
						<td><div class="pull-left">English Report</div>
		            		<p class="buttons pull-right">
								<a class="button" v-bind:class="[(inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(inspection,'en')">
								    <span class="icon is-small">
								      <i class="fa fa-eye"></i>
								    </span>
								</a>
							  	<a class="button is-warning" target='_blank' :href="'/english/reports/'+inspection.english_report_id+'/handover/'">
								    <span class="icon is-small">
								      <i class="fa fa-handshake"></i>
								    </span>
								    <span>Handover</span>
							  	</a>
							</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<template id="followup-inspection" v-if="inspection.follow_up_inspection">
			<div class="columns">
					<div class="column">
						<table class="table is-narrow is-bordered is-fullwidth">
							<thead>
								<tr>
									<th colspan="7"><a class="is-link"  target='_blank' :href="'/inspections/' + inspection.follow_up_inspection.id">Followup Inspection</a>
								</tr>
								<tr>
									<th>Id</th>
									<th>Status</th>
									<th>Type</th>
									<th>Inspection At</th>
									<th v-if="inspection.follow_up_inspection.follow_up_id">Follow Up</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a :href="'/inspections/' + inspection.follow_up_id">{{inspection.follow_up_inspection.id}}</a></td>
									<td>{{inspection.follow_up_inspection.status}}</td>
									<td v-if="!inspection.follow_up_inspection.register_or_renew">{{inspection.follow_up_inspection.reason}}</td>
									<td v-if="inspection.follow_up_inspection.register_or_renew">{{inspection.follow_up_inspection.register_or_renew}}(<a target='_blank' :href="'/applications/' + inspection.follow_up_inspection.application_id + '/process'">{{inspection.follow_up_inspection.application_id}}</a>)</td>
									<td>{{inspection.follow_up_inspection.inspection_at}}</td>
									<td v-if="inspection.follow_up_inspection.follow_up_id"><a :href="'/inspections/' + inspection.follow_up_inspection.follow_up_id">{{inspection.follow_up_inspection.follow_up_id}}</a></td>
									<td>
					             <p class="buttons pull-right">
											  <a class="button" v-bind:class="[(inspection.follow_up_inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(inspection, 'dv')">
											    <span class="icon is-small">
											      <i class="fa fa-book"></i>
											    </span>
									        <span>Dv</span>
											  </a>
											  <a class="button" v-bind:class="[(inspection.follow_up_inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(inspection,'en')">
											    <span class="icon is-small">
											      <i class="fa fa-book"></i>
											    </span>
									        <span>En</span>
											  </a>
										  <a class="button is-info" target='_blank' :href="'/normalforms/'+inspection.follow_up_inspection.normal_form_id">
										    <span class="icon is-small">
										      <i class="fa fa-eye"></i>
										    </span>
										    <span>Check List</span>
										  </a>
										  <a class="button is-danger" @click="deleteFollowUpInspection()">
										    <span class="icon is-small">
										      <i class="fa fa-close"></i>
										    </span>
										    <span>Delete</span>
										  </a>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
			</div>
		</template>
	</div>
</template>




<template id="applications" v-if="inspection.application != null">
	<div class="box">
		<div class="columns">
			<div class="column">
				<table class="table is-narrow is-bordered is-fullwidth">
					<thead>
						<tr>
							<th colspan="6"><a class="is-link"  target='_blank' :href="'/applications/' + inspection.application_id">Application Details</a></th>
						</tr>
						<tr>
							<th>Id</th>
							<th>Permit Type</th>
							<th>Status</th>
							<th>Register/Renew</th>
							<th>Added On</th>
							<th>Updated On</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{inspection.application_id}}</td>
							<td>{{inspection.application.permit_type}}</td>
							<td>{{inspection.application.status}}</td>
							<td>{{inspection.application.register_or_renew}}</td>
							<td>{{inspection.application.created_at}}</td>
							<td>{{inspection.application.updated_at}}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6" class="center">
								<template v-if="inspection.application.register_or_renew != null">
									<button class="button is-warning" v-if="inspection.application._1toRegisterPlace" @click="isIssueLicenseFormOpen = !isIssueLicenseFormOpen">Edit/Issue a New License</button>
									<button class="button is-warning" v-if="inspection.application._1toRenewLicense" @click="isIssueLicenseFormOpen = !isIssueLicenseFormOpen">Edit/Renew License</button>
								</template>
							</td>
						</tr>
						<tr v-if="isIssueLicenseFormOpen">
							<td colspan="6">
								<div class="columns">
					        <div class="column"><div class="field">Issued Date: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="issueLicenseForm.issued_date"></b-datepicker></div></div>
					        <div class="column"><div class="field">Expiry Date: <b-datepicker placeholder="Click to select..." icon="calendar-today" editable v-model="issueLicenseForm.expiry_date"></b-datepicker></div></div>
					        <div class="column">
					        	<div class="field">License No:
											<div class="control">
												<input type="text" placeholder="license_no" class="input" v-model="issueLicenseForm.license_no">
											</div>
										</div>
					        </div>
						      <div class="column">
						        	<br>
						        	<p class="buttons">
											  <a class="button is-success"  @click="issueLicense()">
											    <span class="icon is-small">
											      <i class="fa fa-plus"></i>
											    </span>
											  </a>
											</p>
					        </div>
					      </div>
				     	</td>
				   	</tr>
				  </tfoot>
				</table>
				<table v-if="inspection.application.license" class="table is-narrow is-bordered is-fullwidth">
				   	<tr>
				   		<th colspan="4">Issued License</th>
				   	</tr>
				   	<tr>
				   		<td>License No</td>
				   		<td>Issued Date</td>
				   		<td>Expiry Date</td>
				   		<td>Type</td>
				   	</tr>
				   	<tr>
				   		<td>{{inspection.application.license.license_no}}</td>
				   		<td>{{inspection.application.license.issued_at}}</td>
				   		<td>{{inspection.application.license.expire_at}}</td>
				   		<td>{{inspection.application.license.register_or_renew}}</td>
				   	</tr>
				</table>
			</div>
		</div>
	</div>
</template>

<!-- <div class="columns no-print">
	<div class="column center">
	    <button v-if="inspection.status == 'finished'" class="button is-success is-large">CLOSED</button>
	    <button v-if="inspection.status != 'finished'" class="button is-warning is-large" @click="closeAll()">CLOSE</button>
	</div>
</div> -->

@endverbatim
</div>
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/inspections-show-page.js')}}"></script>
@endsection