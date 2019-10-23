@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Handover Reports / Finish Inspection'])
@verbatim
<div v-can="'api.inspections.processed-reports'">
<div>
	<table class="table is-fullwidth is-narrow is-striped">
		<thead>
			<tr>
				<th>Id</th>
				<th>Status</th>
				<th>type</th>
				<th>Inspection At</th>
				<th>Follow Up</th>
				<th>Handover Reports</th>
				<th>Options</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="item,key in inspections">
				<td>{{item.id}}</td>
				<td>{{item.status}}</td>
				<td v-if="!item.register_or_renew">{{item.reason}}</td>
				<td v-if="item.register_or_renew">{{item.register_or_renew}}(<a target='_blank' :href="'/applications/' + item.application_id + '/process'">{{item.application_id}}</a>)</td>
				<td>{{item.inspection_at}}</td>
				<td>{{item.follow_up_id}}</td>
				<td>
                  	<p class="buttons">
					  <a v-can="'dhivehi-reports.process'" class="button" v-if="item.dhivehi_report" v-bind:class="[(item.dhivehi_report.status != 'issued') ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(item, 'dv')">
					    <span class="icon is-small">
					      <i class="fa fa-book"></i>
					    </span>
			        <span>Dv</span>
					  </a>
					  <a v-can="'english-reports.process'" class="button" v-if="item.english_report" v-bind:class="[(item.english_report.status != 'issued') ? isWarning : isSuccess]" alt="english report" @click="gotToReport(item,'en')">
					    <span class="icon is-small">
					      <i class="fa fa-book"></i>
					    </span>
			        	<span>En</span>
					  </a>
					</p>
				</td>
				<td>
                  	<p class="buttons">
						<a v-can="'normal-forms.show'" class="button is-info" target='_blank' :href="'/normalforms/'+item.normal_form_id">
							<span class="icon is-small">
							  <i class="fa fa-eye"></i>
							</span>
							<span>Check List</span>
						</a>
						<a v-can="'inspections.finish'" class="button is-warning" target='_blank'  :href="'/inspections/'+item.id+'/finish'">
							<span class="icon is-small">
						    <i class="fa fa-gear"></i>
						  </span>
					      <span>Finish</span>
						</a>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="container">
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
<script type="text/javascript" src="{{mix('/js/inspections-processed-reports.js')}}"></script>
@endsection