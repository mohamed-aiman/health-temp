@extends('layouts.app')

@section('content')
@verbatim
<div v-can="'businesses.show'">
@endverbatim

	@include('components.heading', ['title' => 'Business Profile View'])

	@include('components.form-results')
		<input type='hidden' id="business_id" value="{{(isset($business)) ? $business->id : null}}" />
	@verbatim
	<template v-if="business">
		<template id="options">
			<div class="columns" v-can="'businesses.show'">
				<div class="column">
					<table class="table">
						<tr>
							<td>
								<a class="button is-primary is-success" v-can="'businesses.edit'":href="'/businesses/'+businessId+'/edit'">
				            Edit Business
						        </a>
						    </td>
							<td>
								<a class="button is-primary is-success" v-can="'businesses.applications.create'":href="'/businesses/'+businessId+'/applications/create'">
				            New Application
				        </a>
				      </td>
				      <td>
			      		<template>
								<section v-can="'businesses.inspections.store'">
								  <button class="button is-primary is-success"
								      @click="isComponentModalActive = true">
								      Schedule a new Inspection
								  </button>
								<b-modal :active.sync="isComponentModalActive" has-modal-card>
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
														    <button class="button is-link" @click="saveInspection">Save Normal Inspection</button>
														  </div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</b-modal>
								</section>
						</template>
				      </td>
				      <td>
				      	<template>
					      	<section v-can="'businesses.grading-inspections.store'">
									<button class="button is-primary is-success"
									@click="isGradingModalActive = true">
									Schedule a new Grading Inspection
									</button>

							    	<b-modal :active.sync="isGradingModalActive" has-modal-card>
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
																				<option value="grading" selected>Grading</option>
																				<option value="license_renewal">License Renewal</option>
																				<option value="complaint">Complaint</option>
																				<option value="compliance_audit">compliance audit</option>
																				<!-- <option value="unspecified">Unspecified </option> -->
																			</select>
																		</div>
																	</div>
																</div>
																<div class="column">
																	<div class="field">
																	  <label class="label">&nbsp</label>
																	  <div class="control">
																	    <button class="button is-link" @click="saveGradingInspection">Save Grading Inspection</button>
																	  </div>
																	</div>
																</div>
															</div>
														</div>
													</div>
									</b-modal>
								</section>
						</template>
				      </td>
							@endverbatim
						</tr>
					</table>
				</div>
			</div>
		</template>
	@verbatim
		<business-details :business="business"></business-details>
		<business-applications :applications="business.applications"></business-applications>
		<business-inspections :inspections="business.inspections"></business-inspections>
		<business-grading-inspections v-if="business.grading_inspections && business.grading_inspections.length>0" :grading_inspections="business.grading_inspections"></business-grading-inspections>
		<business-fines :fines="business.fines"></business-fines>
		<business-licenses :licenses="business.licenses"></business-licenses>
		<business-terminations :terminations="business.terminations" :active="business.termination_id"></business-terminations>
	</template>
</div>
@endverbatim
@endsection
@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/business-show-page.js')}}"></script>
@endsection