@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Inspection forms to be processed'])
@verbatim
<div v-can="'normal-forms.pendingApi'">
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
					<th>Process</th>
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
						  <a class="button is-warning" v-can="'normal-forms.process'" @click="processItem(item)">
						    <span class="icon is-small">
						      <i class="fa fa-gear"></i>
						    </span>
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
<script type="text/javascript" src="{{mix('/js/normal-forms-pending.js')}}"></script>
@endsection