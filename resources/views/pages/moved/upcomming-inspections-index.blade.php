@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Upcoming Inspections'])

@verbatim
<template v-if="inspections">
	<div class="columns" v-can="'inspections.update'" v-if="editMode">
		<div class="column box">
			<div class="columns">
				<div class="column">
				  <div class="label is-normal">
				    <label class="label">Updating Inspection id: {{inspectionForm.inspection_id}}</label>
				  </div>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<div class="field">
					  <label class="label">Status</label>
						<div class="select">
						  <select v-model="inspectionForm.status">
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
	                      			@input="timePickerInput"
						            v-model="inspectionForm.time">
						        </b-timepicker>
						    </b-field>
						</template>
					</div>
				</div>
				<div class="column" v-if="inspectionForm.type">
					<div class="field">
					  <label class="label">Type</label>
						<div class="select">
						  <select disabled v-model="inspectionForm.type">
						    <option value="1">New Registration</option>
						    <option value="2">License Renewal</option>
						  </select>
						</div>
					</div>
				</div>
				<div class="column" v-if="!inspectionForm.type">
					<div class="field">
					  <label class="label">Type</label>
						<div class="select">
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
						<div class="input control">
							<input type="text" placeholder="remarks" class="input" v-model="inspectionForm.remarks">
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

	<div class="columns" v-can="'inspections.upcoming'">
		<div class="column">
			<table class="table is-fullwidth is-narrow is-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Business Name</th>
						<th>Status</th>
						<th>Type</th>
						<th>Inspection At</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item in inspections">
						<td>{{item.id}}</td>
						<td><a target='_blank' :href="'/businesses/'+ item.business.id">{{item.business.name}}</a></td>
						<td>{{item.status}}</td>
						<td v-if="!item.register_or_renew">{{item.reason}}</td>
						<td v-if="item.register_or_renew">{{item.register_or_renew}}(<a target='_blank' :href="'/applications/' + item.application_id + '/process'">{{item.application_id}}</a>)</td>
						<td>{{item.inspection_at}}</td>
						<td>
							<p class="buttons">
							    <a class="button is-link" v-can="'inspections.show'" target='_blank'  :href="'/inspections/'+item.id">
							    <span class="icon is-small">
								      <i class="fa fa-eye"></i>
								    </span>
								  </a>
								<a class="button is-warning" v-can="'inspections.update'" alt="edit mode on off" @click="toggleEditItemMode(item)">
								<span class="icon is-small">
								  <i class="fa fa-edit"></i>
								</span>
								</a>
								<a class="button " v-can="'normal-inspections.normalforms.edit'" v-bind:class="[isFormAttached(item)]" alt="go to inspection form" target='_blank' :href="'/normalinspections/' + item.id + '/normalforms/edit'">
								<span class="icon is-small">
								  <i class="fa fa-list"></i>
								</span>
								</a>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
    <b-pagination
    :total="pagination.total"
    :current.sync="pagination.current"
    :order="pagination.order"
    :size="pagination.size"
    :simple="pagination.isSimple"
    :rounded="pagination.isRounded"
    :per-page="pagination.perPage"
    @change="pageChange">
</b-pagination>
</template>
@endverbatim
@endsection
@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/upcomming-inspections-index.js')}}"></script>
@endsection