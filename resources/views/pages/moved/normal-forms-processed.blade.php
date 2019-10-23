@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Approved Inspection Forms'])
@verbatim
<div v-can="'normal-forms.processedApi'">
	<div>
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Applied Date</th>
					<th>Applied Reason</th>
					<th>Reason</th>
					<th>Place Name and Address</th>
					<th>Updated On</th>
					<th>Options</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item,key in normalforms">
					<td>{{item.id}}</td>
					<td>{{item.applied_date}}</td>
					<td>{{item.applied_reason}}</td>
					<td>{{item.inspection_reason}}</td>
					<td>{{item.place_name_address}}</td>
					<td>{{item.updated_at}}</td>
					<td>
	                  	<p class="buttons">
						  <a class="button is-info" v-can="'normal-forms.show'" target='_blank' :href="'/normalforms/'+item.id">
						    <span class="icon is-small">
						      <i class="fa fa-eye"></i>
						    </span>
						    <span>Check List</span>
						  </a>

						  <a class="button" v-can="'inspections.dhivehi-reports.edit'" v-bind:class="[(item.normal_inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(item.normal_inspection, 'dv')">
						    <span class="icon is-small">
						      <i class="fa fa-book"></i>
						    </span>
				        <span>Dv</span>
						  </a>
						  <a class="button" v-can="'inspections.english-reports.edit'" v-bind:class="[(item.normal_inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(item.normal_inspection,'en')">
					    <span class="icon is-small">
					      <i class="fa fa-book"></i>
					    </span>
			        	<span>En</span>
						  </a>
							<a class="button is-info" v-can="'inspections.show'" target='_blank'  :href="'/inspections/'+item.normal_inspection.id">
								<span class="icon is-small">
							    <i class="fa fa-eye"></i>
							  </span>
						      <span>Inspection</span>
							</a>

						</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div>
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
	</div>
</div>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/normal-forms-processed.js')}}"></script>
@endsection