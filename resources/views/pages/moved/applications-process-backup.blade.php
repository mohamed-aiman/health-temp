@extends('layouts.app')

@section('content')


@include('components.form-results')
<input type='hidden' id="application_id" value="{{(isset($application)) ? $application->id : null}}" />
@verbatim
<br>
<div class="container box">
	<div class="columns">
		<div class="column box">
			<div class="columns">
				<div class="column">
				  <div class="label is-normal">
				    <label class="label">Update Application Status</label>
				  </div>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<div class="columns">
						<div class="column">
								<div class="field">
								  <div class="notification" :class="statusChangeColor" v-if="statusChangeStatus">{{statusChangeStatus}}</div>
							      <div class="control">
							        <div class="select is-fullwidth">
										<select v-model="application.status" @change="updateStatus(application)">
											<option value="draft" >draft</option>
											<option value="pending" >pending</option>
											<option value="processed" >processed</option>
											<option value="cancelled" >cancelled</option>
										</select>
							        </div>
							      </div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<template v-if="application.business_id">
		<div class="columns">
			<div class="column box">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label">Business Details</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="columns">
							<div class="column">
								<div class="field">
								  <label class="label">English Name</label>
								  <div class="content">
								    <p>{{business.name}}</p>
								  </div>
								</div>
							</div>
							<div class="column">
								<div class="field">
								  <label class="label">Dhivehi Name</label>
								  <div class="content">
								    <p class="dhivehi">{{business.name_dv}}</p>
								  </div>
								</div>
							</div>
							<div class="column">
								<div class="field">
								  <label class="label">Registration Number</label>
								  <div class="content">
								    <p >{{business.registration_no}}</p>
								  </div>
								</div>
							</div>
							<div class="column">
								<div class="field">
								  <label class="label">Phone</label>
								  <div class="content">
								    <p >{{business.phone}}</p>
								  </div>
								</div>
							</div>
							<div class="column">
								<div class="field">
								  	<label class="label">
										<div class="control">
										    <a class="button is-link" target='_blank'  :href="'/businesses/'+business.id">View Business</a>
										  </div>
									  </label>
									  <div class="control">
									    <button class="button is-danger" @click="submitRemoveBusinessFromApplication">Remove Business From Application</button>
									  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		


		<div class="columns" v-if="application.business_id">
			<div class="column box">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label" v-if="form._1applicationType == 1">License</label>
					    <label class="label" v-if="form._1applicationType == 2" >Renew License</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
					    <b-field label="License Date">
					        <b-datepicker
					            placeholder="Click to select..."
					            icon="calendar-today"
					            v-model="licenseForm.issued_at">
					        </b-datepicker>
					    </b-field>
					</div>
					<div class="column">
					    <b-field label="Expires At">
					        <b-datepicker
					            placeholder="Click to select..."
					            icon="calendar-today"
					            v-model="licenseForm.expire_at">
					        </b-datepicker>
					    </b-field>
					</div>
					<div class="column">
						<div class="field">
							<div class="control">
							  <label class="label">License No: </label>
			        			<input type="text" name="amount" v-model="licenseForm.license_no" class="input">
			        		</div>
				        </div>
					</div>
					<div class="column">
						<div class="field">
						  <label class="label">&nbsp</label>
						  <div class="control">
						    <button class="button is-link" @click="saveLicenseForm"  v-if="form._1applicationType == 1">Create a new License</button>
						    <button class="button is-link" @click="saveLicenseForm"  v-if="form._1applicationType == 2">Create a renewed License</button>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<div class="columns">
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
							    <b-field label="Select a date">
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
							    <b-field label="Select timepicker">
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
						  <label class="label">Type</label>
							<div class="select">
							  <select disabled v-model="form._1applicationType">
							    <option value="1">New Registration</option>
							    <option value="2">License Renewal</option>
							  </select>
							</div>
						</div>
					</div>
					<div class="column">
						<div class="field">
						  <label class="label">&nbsp</label>
						  <div class="control">
						    <button class="button is-link" @click="submitSaveInspection">Save Inspection</button>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<template v-if="application.inspections">
			<table class="table">
				<tr v-for="inspection in application.inspections">
					<td>{{inspection.id}}</td>
					<td>{{inspection.status}}</td>
					<td>{{inspection.inspection_at}}</td>
					<td>
						<p class="buttons">
						  <a class="button is-danger" @click="deleteInspection(inspection)">
						    <span class="icon is-small">
						      <i class="fa fa-times"></i>
						    </span>
						  </a>
						</p>
					</td>
				</tr>
			</table>
		</template>
	</template>
	<template v-if="!application.business_id">
		<div class="columns">
			<div class="column box">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label">Attach Application</label>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<template v-if="showAttachToExistingBusiness">
			<div class="columns">
				<div class="column box">
					<div class="columns">
						<div class="column">
						  <div class="label is-normal">
						    <label class="label">Search for existing business</label>
						  </div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
						  <!-- <div class="notification" :class="businessStoreColor" v-if="businessStoreMessage">{{businessStoreMessage}}</div> -->
						</div>
					</div>
					<div class="columns">
						<div class="column">
							<div class="columns">
								<div class="column is-fullwidth">
									<div class="field">
									  <label class="label">Type business name or registration no</label>
									  <div class="control">
									    <input class="input" name="businessesSearchTerm" type="text" v-model="businessesSearchTerm" placeholder="Business name or registration no">
									  </div>
									</div>
								</div>
								<div class="column">
									<div class="field">
									  <label class="label" v-if="selectedBusiness">Selected: {{selectedBusiness.name}} ({{selectedBusiness.registration_no}})p</label>
									  <label class="label" v-if="!selectedBusiness">&nbsp</label>
										  <div class="select">
										  <select v-model="selectedBusiness">
										    <option v-for="business in businesses" :value="business">{{business.name}} ({{business.registration_no}})</option>
										  </select>
										</div>
									</div>
								</div>
								<div class="column">
									<template v-if="selectedBusiness">
									  <label class="label">
											<div class="control">
										    <a class="button is-link" target='_blank'  :href="'/businesses/'+selectedBusiness.id">View Business</a>
										  </div>
									  </label>
										<div class="field">
											  <div class="control">
											    <button class="button is-link" @click="submitAttachToSelectedBusiness">Attach to the selected Business</button>
											  </div>
										</div>
									</template>
									<template>
									  <label class="label">&nbsp</label>
										<div class="field">
											  <div class="control">
											    <button class="button is-link" @click="toggelShowNewBusinessRegistration">Create New</button>
											  </div>
										</div>
									</template>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</template>
		<template v-if="showNewBusinessRegistration">
			<div class="columns">
				<div class="column auto box">
					<div class="columns">
						<div class="column">
						  <div class="label is-normal">
						    <label class="label" v-show="application._1applicationType == '1'">Add new business entity (Register New Business)</label>
						    <label class="label" v-show="application._1applicationType == '2'">Add new business entity (Licence Renewal Application)</label>
						  </div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
						  <div class="notification" :class="businessStoreColor" v-if="businessStoreMessage">{{businessStoreMessage}}</div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
							<div class="columns">
								<div class="column">
									<div class="field">
									  <label class="label">English Name</label>
									  <div class="control">
									    <input class="input" name="name" type="text" v-model="businessRegForm.name" placeholder="Business name">
									  </div>
									</div>
								</div>
								<div class="column">
									<div class="field">
									  <label class="label">Dhivehi Name</label>
									  <div class="control">
									    <input class="input dhivehi" name="name_dv" type="text" v-model="businessRegForm.name_dv" placeholder="ދިވެހި ނަން">
									  </div>
									</div>
								</div>
								<div class="column">
									<div class="field">
									  <label class="label">Registration Number</label>
									  <div class="control">
									    <input class="input" name="registration_no" type="text" v-model="businessRegForm.registration_no" placeholder="registration no">
									  </div>
									</div>
								</div>
								<div class="column">
									<div class="field">
									  <label class="label">Phone</label>
									  <div class="control">
									    <input class="input" name="phone" type="text" v-model="businessRegForm.phone" placeholder="phone">
									  </div>
									</div>
								</div>
								<div class="column">
									<div class="field">
									  <label class="label">&nbsp</label>
										  <div class="control">
										    <button class="button is-link" @click="submitNewBusinessForm">Save and Attach to New Business</button>
										  </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</template>
	</template>
</div>

@endverbatim
@include('components.heading-dhivehi', ['title' => '‫ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް'])

<form method="POST" action="{{route('applications.store')}}" v-on:submit.prevent="onSubmit">
	@csrf
@verbatim
<div class="container">
	<div class="columns dhivehi">
		<div class="column">
			<label class="label">1 - ހުއްދައިގެ ބާވަތް</label>
		</div>
	</div>
	<div class="columns dhivehi box is-gapless">
		<div class="column">
			<div class="field">
			  <div class="control">
				<div class="select">
				  <select v-model="form._1tobaccoOrFood">
				    <option value="1">ދުންފަތް</option>
				    <option value="2">ކާބޯތަކެތި</option>
				  </select>
				</div>
			  </div>
			</div>
		</div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column">
			<div class="field">
			  <div class="control">
					<div class="select">
					  <select v-model="form._1applicationType">
					    <option value="1">ތަން ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="2">ހުއްދަ އާކުރުމަށް</option>
					  </select>
					</div>
			  </div>
			</div>
		</div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column">
			<div class="field">
			  <div class="control" v-if="form._1toRegisterPlace">
					<div class="select">
					  <select v-model="form._1registerPlace">
					    <option value="1">އަލަށް ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="2">ތަނުގެ ނަން ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="3">ތަން ހިންގާ ފަރާތް ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="4">ތަނުގެ އެޑްރެސް ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</option>
					  </select>
					</div>
			  </div>
			  <div class="control" v-if="form._1toRenewLicense">
					<div class="select">
					  <select v-model="form._1renewLicense">
					    <option value="1">ހުއްދައިގެ މުއްދަތު ހަމަވެގެން</option>
					    <option value="2">ހުއްދަ ގެއްލިގެން އާކުރުމަށް</option>
					    <option value="3">ހުއްދަ ހަލާކުވެގެން އާކުރުމަށް</option>
					  </select>
					</div>
			  </div>
			</div>
		</div>
	</div>
	<br>
	<div class="columns dhivehi box">
		<div class="column">
			<div class="field">
			  <label class="label">ރަޖިސްޓްރޭސަން ނަމްބަރ</label>
			  <div class="control">
					<input class="input dhivehi" type="text" v-model="form._1registrationNumber">
			  </div>
			</div>
		</div>
		<div class="column">
			<div class="field">
			  <label class="label">ހުއްދަ ބޭނުންވާ ބަސް</label>
			  <div class="control">
					<label class="checkbox">
					  <input type="checkbox" v-model="form._1wantLicenseIndhivehi">
					  ދިވެހި
					</label>
					<label class="checkbox">
					  <input type="checkbox" v-model="form._1wantLicenseInenglish">
					  އިނގިރޭސި
					</label>
			  </div>
			</div>
		</div>
		<div class="column">
			<div class="field">
			  <label class="label">ތާރީޚް</label>
			  <div class="control">
					<input class="input" type="text" v-model="form._1date">
			  </div>
			</div>
		</div>
	</div>


	<div class="columns dhivehi">
		<div class="column">
			<label class="label">2 - ވިޔަފާރި ރަޖިސްޓްރީ ކުރެވިފައިވާ ފަރާތުގެ މަޢުލޫމާތު:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <label class="label">ނަން</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._2name">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">އެޑްރެސް (އަތޮޅާއި ރަށް):</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._2address">
					  </div>
					</div>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">އައިޑީކާޑު ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input ltr" type="text" v-model="form._2idNo" placeholder="A123456">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ފޯން ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._2phone" placeholder="9876543">
					  </div>
					</div>
		    </div>
			</div>
		</div>
	</div>

	<div class="columns dhivehi">
		<div class="column">
			<label class="label">3 - ތަން ހިންގާ ފަރާތުގެ މަޢުލޫމާތު:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <label class="label">ނަން</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._3name">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">އެޑްރެސް (އަތޮޅާއި ރަށް):</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._3address">
					  </div>
					</div>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">އައިޑީކާޑު ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input ltr" type="text" v-model="form._3idNo" placeholder="A123456">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ފޯން ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._3phone" placeholder="9876543">
					  </div>
					</div>
		    </div>
			</div>
		</div>
	</div>



	<div class="columns dhivehi">
		<div class="column">
			<label class="label">4 - ތަނާ ބެހޭ މަޢުލޫމާތު:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <label class="label">ތަނުގެ ނަން</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4placeName">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">މަގު:</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4road">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  			  <label class="label">ސާވިންގ އޭރިޔާގެ އަދަދު:</label>
					<div class="field">
					  <div class="control">
							<input class="input ltr" type="text" v-model="form._4numberOfServingAreas">
					  </div>
					</div>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">ތަނުގެ އެޑްރެސް:</label>
					<div class="field">
					  <div class="control">
							<input class="input ltr" type="text" v-model="form._4placeAddress">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ބްލޮކް ނަންބަރ:</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4blockNumber">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ގޮނޑީގެ އަދަދު:</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4numberOfChairs">
					  </div>
					</div>
		    </div>
			</div>
		</div>
	</div>


	<div class="columns dhivehi">
		<div class="column">
			<label class="label">5 - ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ކެޓަގަރީތައް:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <div class="column">
						<div class="field">
						  <div class="control">
								<div>

<label >ކެޓަގަރީ 1&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat11">
		ހޮޓާ
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat12">
		ކެފޭ
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat13">
		ރެސްޓޯރަންޓް
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat14">
		ކެންޓީން
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat15">
		ކޮފީ ޝޮޕް
</label>
<br>

<label >ކެޓަގަރީ 2&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat21">
		ކޭޓަރިންގ ސރވިސަސް
</label>
<br>

<label >ކެޓަގަރީ 3&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat31">
		ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެއާއި އެކު)
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat32">
		ބޭކަރީ
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat33">
		ބަދިގެ
</label>
<br>

<label >ކެޓަގަރީ 4&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat41">
		ހެދިކާ ވިއްކާ ތަންތަން
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat42">
		ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެނުލާ)
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat43">
		ޖޫސް ފަދަ ލުއިބުއިންތައް އެކަނި ވިއްކާތަންތަން
</label>
<br>

<label >ކެޓަގަރީ 5&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat51">
		ކާބޯތަކެތި ބަންދުކުރާ ކުދިވިޔަފާރި ކުރާ ތަންތަން
</label>
<br>

<label >ކެޓަގަރީ 6&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat61">
		ކާބޯތަކެތި ބަންދުކުރާ މެދުފަންތީގެވިޔަފާރި ކުރާ ތަންތަން
</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat62">
		މަގުމަތީގައި ކާނާ ވިއްކާ ތަންތަނާއި ތަކެއްޗާއި އުޅަނދުތައް
</label>
<br>

<label >ކެޓަގަރީ 7&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat71">
		ވަގުތީގޮތުން ހިންގާ ފެއާރތަކާއި ކެންޓީންފަދަ ތަންތަން
</label>
<br>

<label >ކެޓަގަރީ 8&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat81">
		ނައަމްސޫފި ކަތިލުމުގެ ޚިދުމަތްދޭ ތަންތަން
</label>
<br>

<label >ކެޓަގަރީ 9&nbsp&nbsp&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat91">
		ދައުލަތުގެ ފަރާތުން ނުވަތަ އަމިއްލަ ޖަމާއަތަކުން ކުދިންނާއި މީހުން ބަލަހައްޓާ ތަންތަނާއި ހިލޭ ސާބަހައް ކާބޯތަކެތި ތައްޔާރުކޮށް ފޯރުކޮށްދޭ ތަންތަން
</label>
<br>

<label >ކެޓަގަރީ 01&nbsp</label>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
  <input type="checkbox" v-model="form._5cat101">
		އެހެނިހެން ތަންތަން/ތަފްޞީލް:
</label>

					<div class="field">
					  <div class="control" v-if="form._5cat101">
							<input class="input" type="text" v-model="form._5cat101text" placeholder="ކެޓަގަރީ 10:  އެހެނިހެން ތަންތަން/ތަފްޞީލް:">
					  </div>
					</div>
								</div>
						  </div>
						</div>
					</div>
		    </div>
		  </div>
		</div>
	</div>





	<div class="columns">
		<div class="column">
			<div class="field is-grouped">
			  <div class="control">
			    <button class="button is-link">Save</button>
			  </div>
			  <div class="control">
			    <button class="button is-text">Cancel</button>
			  </div>
			</div>
		</div>
	</div>
</div>
</form>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript">
	const app = new Vue({
		el: "#app",
		data: {
			applicationId: document.getElementById('application_id').value,
			showNewBusinessRegistration: false,
			showAttachToExistingBusiness: true,
			businessesSearchTerm: null,
			businesses: [],
			selectedBusiness: null,
			statusChangeStatus: null,
			statusChangeColor: 'is-success',
			application: {},
			license: {},
			businessStoreMessage: null,
			businessStoreColor: 'is-success',
			business: {},
			business_id: null,
			businessRegForm: new Form({
				name: null,
				name_dv: null,
				phone: null,
				registration_no: null,
			}),
			form: new Form({
				applicationId: null,
				_1tobaccoOrFood: "1",
				_1applicationType: "1",
				_1toRegisterPlace: true,
				_1toRenewLicense: true,
				_1registerPlace: "1",
				_1renewLicense: "1",
				_1registrationNumber: null,
				_1wantLicenseIndhivehi: true,
				_1wantLicenseInenglish: true,
				_1date:null,
				_2name:null,
				_2idNo:null,
				_2address:null,
				_2phone:null,
				_3name:null,
				_3idNo:null,
				_3address:null,
				_3phone:null,
				_4placeName:null,
				_4placeAddress:null,
				_4road:null,
				_4blockNumber:null,
				_4numberOfServingAreas:null,
				_4numberOfChairs:null,
				_5cat11:false,
				_5cat12:false,
				_5cat13:false,
				_5cat14:false,
				_5cat15:false,
				_5cat21:false,
				_5cat31:false,
				_5cat32:false,
				_5cat33:false,
				_5cat41:false,
				_5cat42:false,
				_5cat43:false,
				_5cat51:false,
				_5cat61:false,
				_5cat62:false,
				_5cat71:false,
				_5cat81:false,
				_5cat91:false,
				_5cat101:false,
				_5cat101text:null
			}),
			licenseForm: new Form({
				issued_at: new Date(),
				expire_at: new Date(),
				license_no: null,
			}),
			inspectionForm: new Form({
				date:new Date(),
				time: new Date(),
				datetimeString: '',
				dateString: '',
				timeString: ''
			})
		},
	  watch: {
	  	'form._1applicationType': function() {
	  		switch(this.form._1applicationType) {
				    case "1":
				        this.form._1toRegisterPlace = true;
				        this.form._1toRenewLicense = false;
				        break;
				    case "2":
				        this.form._1toRegisterPlace = false;
				        this.form._1toRenewLicense = true;
				        break;
				    default:
				        this.form._1toRegisterPlace = true
				}
	  	},
	  	businessesSearchTerm: _.debounce(function(){
	  		if (this.businessesSearchTerm) {
	  			this.businesses = [];
		  		this.searchBusinesses();
	  		}
	  	}, 700),
	  	'inspectionForm.time': function() {
	  		this.timePickerInput();
	  	}
		},
		mounted() {
			this.getApplication();
			this.datePickerInput();
			this.timePickerInput();
		},
		methods: {
			getApplication() {
				axios
		  		.get('/api/applications/' + this.applicationId)
					.then(response => {
						this.setFormFromModel(response.data);
					})
					.catch(errors => console.log(errors));	
			},
			datePickerInput(date) {
				var date = (date) ? date: this.inspectionForm.date;
				// YYYY-MM-DD HH:MI:SS
				this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
				console.log(this.inspectionForm.dateString);
			},
			buildDateTimeString() {
				return this.inspectionForm.datetimeString = this.inspectionForm.dateString + ' ' + this.inspectionForm.timeString;
			},
			timePickerInput() {
				if (this.inspectionForm.time) {
					var date = this.inspectionForm.time;
					this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
					console.log(this.inspectionForm.timeString);
				}
			},
			pad(value) {
			    if(value < 10) {
			        return '0' + value;
			    } else {
			        return value;
			    }
			},
			formatDate(date) {
				return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' 00:00:00';
			},
			submitSaveInspection() {
				axios
				.post('/api/applications/' + this.applicationId + '/inspections', {
					'inspection_at': this.buildDateTimeString()
				})
				.then(response => {
					console.log(response.data);
					this.setFormFromModel(response.data);
					// this.businessStoreSuccess();
				})
				.catch(errors => {
					console.log('errors', errors);
					this.businessStoreFail();
				});	
			},
			deleteInspection(inspection) {
				axios
				.delete('/inspections/' + inspection.id)
				.then(response => {
					this.getApplication();
				})
				.catch(errors => {
					console.log('errors', errors);
					this.businessStoreFail();
				});	
			},
			saveLicenseForm() {
				axios
				.post('/api/applications/' + this.applicationId + '/licenses', {
					issued_at: this.formatDate(this.licenseForm.issued_at),
					expire_at: this.formatDate(this.licenseForm.expire_at),
					license_no: this.licenseForm.license_no
				})
				.then(response => {
					this.setFormFromModel(response.data);
				})
				.catch(errors => {
					console.log('errors', errors);
					this.businessStoreFail();
				});		
			},
			searchBusinesses() {
				axios
			  .get('/api/businesses/search?found=true&term=' + this.businessesSearchTerm)
				.then(response => {
					this.businesses = response.data;
		  		if (this.businesses.length == 1) {
		  			this.selectedBusiness = this.businesses[0];
		  		}
						console.log(response.data);
				})
				.catch(error => console.log(error));
			},
			toggelShowNewBusinessRegistration() {
				this.showNewBusinessRegistration = !this.showNewBusinessRegistration;
			},
			setBusinessRegistrationRelated() {
				if(this.business == null) {
					this.businessRegForm.name = this.form._2name;
					this.businessRegForm.name_dv = this.form._2name;
					this.businessRegForm.phone = this.form._2phone;
					this.businessRegForm.registration_no = this.form._1registrationNumber;
					this.businessesSearchTerm = this.form._1registrationNumber;
				} else {
					this.businessRegForm.name = this.business.name;
					this.businessRegForm.name_dv = this.business.name_dv;
					this.businessRegForm.phone = this.business._2phone;
					this.businessRegForm.registration_no = this.business.registration_no;
				}
			},
			submitNewBusinessForm() {
				this.businessRegForm.post('/api/applications/' + this.applicationId + '/businesses')
					.then(response => {
						console.log(response);
						this.setFormFromModel(response);
						// this.businessStoreSuccess();
					})
					.catch(errors => {
						console.log('errors', errors);
						this.businessStoreFail();
					});	
			},
			businessStoreSuccess() {
				this.businessStoreColor = 'is-success';
				this.businessStoreMessage = 'new business entity added and application attached to it.'
			},
			businessStoreFail() {
				this.businessStoreColor = 'is-danger';
				this.businessStoreMessage = 'error while creating new business entity or attaching it to the business.'
			},
			onSubmit() {
				this.form.patch('/applications/' + this.applicationId)
					.then(response => {
						console.log(response);
						this.setFormFromModel(response);
					})
					.catch(errors => console.log(errors));		
			},
			setFormFromModel(data) {
				this.application = data;
				this.license = this.application.license;
				this.business = data.business;
				this.business_id = data.business_id;

				if(this.license) {
					this.licenseForm.issued_at = new Date(this.license.issued_at);
					this.licenseForm.expire_at = new Date(this.license.expire_at);
					this.licenseForm.license_no = this.license.license_no;
				}

				this.form._1tobaccoOrFood = data._1tobaccoOrFood;
				this.form._1applicationType = data._1applicationType;
				this.form._1toRegisterPlace = data._1toRegisterPlace;
				this.form._1toRenewLicense = data._1toRenewLicense;
				this.form._1registerPlace = data._1registerPlace;
				this.form._1renewLicense = data._1renewLicense;
				this.form._1registrationNumber = data._1registrationNumber;
				this.form._1wantLicenseIndhivehi = data._1wantLicenseIndhivehi;
				this.form._1wantLicenseInenglish = data._1wantLicenseInenglish;
				this.form._1date = data._1date;
				this.form._2name = data._2name;
				this.form._2idNo = data._2idNo;
				this.form._2address = data._2address;
				this.form._2phone = data._2phone;
				this.form._3name = data._3name;
				this.form._3idNo = data._3idNo;
				this.form._3address = data._3address;
				this.form._3phone = data._3phone;
				this.form._4placeName = data._4placeName;
				this.form._4placeAddress = data._4placeAddress;
				this.form._4road = data._4road;
				this.form._4blockNumber = data._4blockNumber;
				this.form._4numberOfServingAreas = data._4numberOfServingAreas;
				this.form._4numberOfChairs = data._4numberOfChairs;
				this.form._5cat11 = data._5cat11;
				this.form._5cat12 = data._5cat12;
				this.form._5cat13 = data._5cat13;
				this.form._5cat14 = data._5cat14;
				this.form._5cat15 = data._5cat15;
				this.form._5cat21 = data._5cat21;
				this.form._5cat31 = data._5cat31;
				this.form._5cat32 = data._5cat32;
				this.form._5cat33 = data._5cat33;
				this.form._5cat41 = data._5cat41;
				this.form._5cat42 = data._5cat42;
				this.form._5cat43 = data._5cat43;
				this.form._5cat51 = data._5cat51;
				this.form._5cat61 = data._5cat61;
				this.form._5cat62 = data._5cat62;
				this.form._5cat71 = data._5cat71;
				this.form._5cat81 = data._5cat81;
				this.form._5cat91 = data._5cat91;
				this.form._5cat101 = data._5cat101;
				this.form._5cat101text = data._5cat101text;
				this.setBusinessRegistrationRelated();
			},
			updateStatus(item) {
				axios
				.patch("/api/applications/" + item.id  + "/updateStatus", {
					'status': item.status
				})
				.then(response => {
					item = response.data;
					this.statusChangeColor = 'is-success';
					this.statusChangeStatus = 'status changed successfully.'
				})
				.catch(error => {
					this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
					this.statusChangeColor = 'is-danger';
					console.log(error);
				});
			},
			submitAttachToSelectedBusiness() {
					axios
					.patch('/api/applications/' + this.applicationId + '/businesses/' + this.selectedBusiness.id + '/attach')
					.then(response => {
						this.setFormFromModel(response.data);
					})
					.catch(errors => {
					});
			},
			submitRemoveBusinessFromApplication() {
				if (confirm('Are you sure you want to detach this application from the attached business?')) {
					axios
					.patch('/api/applications/' + this.applicationId + '/businesses/detach')
					.then(response => {
						this.setFormFromModel(response.data);
					})
					.catch(errors => {
					});
				} else {}
			}
		}
	});
</script>
@endsection