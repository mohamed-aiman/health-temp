@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Pending Applications'])
@verbatim
<div v-can="'applications.pendingApi'">
	<div>
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Registration No.</th>
					<th class="dhivehi right">ތަނުގެ ނަން.</th>
					<th>Permit Type</th>
					<th>New/Renew</th>
					<th>Added On</th>
					<th>Updated On</th>
					<th>Process</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						<div class="control input is-primary">
							<input type="text"  class="control" size="4" name="applicationId" v-model="form.applicationId">
						</div>
					</th>
					<th>
						<div class="control input is-primary">
							<input type="text"  class="control" size="4" name="registrationNo" v-model="form.registrationNo">
						</div>
					</th>
					<th>
						<div class="control input is-primary">
							<input type="text"  class="control" size="4" name="placeNameDv" v-model="form.placeNameDv">
						</div>
					</th>
					<th>
						<div class="control select is-primary">
						<select v-model="form.tobaccoOrFood">
							<option value="all" selected>all</option>
							<option value="1">tobacco</option>
							<option value="2">food</option>
						</select>
						<div>
					</th>
					<th>
						<div class="control select is-primary">
						<select v-model="form.registerOrRenew">
							<option value="all" selected>all</option>
							<option value="1">register</option>
							<option value="2">renew</option>
						</select>
						<div>
					</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item,key in applications">
					<td><a :href="'/applications/'+item.id">{{item.id}}</a></td>
					<td v-if="!item.business_id">{{item._1registrationNumber}}</td>
					<td v-if="item.business_id"><a :href="'/businesses/'+item.business_id">{{item._1registrationNumber}}</a></td>
					<td class="dhivehi">{{item._4placeName}}</td>
					<td>{{item.permit_type}}</td>
					<td>{{item.register_or_renew}}</td>
					<td>{{item.created_at}}</td>
					<td>{{item.updated_at}}</td>
					<td>
	                  	<p class="buttons">
						  <a class="button is-warning" v-can="'applications.process'" @click="processItem(item)">
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
<script type="text/javascript" src="{{mix('/js/applications-pending.js')}}"></script>
@endsection