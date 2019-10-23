@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Upcoming Grading Inspections'])

<div>
@verbatim
	<template v-if="inspections">
	<div>


		<div class="columns" v-if="editMode">
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
			<div class="column box">
				<div class="columns">
						<div class="column">
						  <label class="label">Inspections</label>
						</div>
				</div>
				<div class="columns">
					<table class="table">
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
								<td v-if="!item.register_or_renew">{{(item.reason) ? item.reason : '-'}}</td>
								<td v-if="item.register_or_renew">{{item.register_or_renew}}(<a target='_blank' :href="'/applications/' + item.application_id + '/process'">{{item.application_id}}</a>)</td>
								<td>{{item.inspection_at}}</td>
								<td>
									<p class="buttons">
									    <a class="button is-link" target='_blank'  :href="'/gradinginspections/' + item.id + '/gradingforms'">
									    <span class="icon is-small">
										      <i class="fa fa-eye"></i>
										    </span>
										  </a>
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
		<br/>
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
</div>
@endverbatim
@endsection
@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/upcomming-grading-inspections.js')}}"></script>
@endsection