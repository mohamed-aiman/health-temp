@extends('layouts.app')

@section('content')

@verbatim
<div v-can="'applications.index'">
@endverbatim

@include('components.heading', ['title' => '‫Inspection Applications'])
@verbatim
<div>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Permit Type</th>
				<th>New/Renew</th>
				<th>Status</th>
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
				<th>
					<div class="control select is-primary">
					<select v-model="form.status">
						<option value="all" selected>all</option>
						<option value="draft">draft</option>
						<option value="pending">pending</option>
						<option value="processed">processed</option>
						<option value="cancelled">cancelled</option>
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
				<td>{{item.id}}</td>
				<td>{{item.permit_type}}</td>
				<td>{{item.register_or_renew}}</td>
				<td>
                  	<p class="buttons">
						<span class="control select">
		  					<select v-model="item.status" @change="updateStatus(item)">
								<option value="draft" >draft</option>
								<option value="pending" >pending</option>
								<option value="processed" >processed</option>
								<option value="cancelled" >cancelled</option>
							</select>
						</span>
					</p>
				</td>
				<td>{{item.created_at}}</td>
				<td>{{item.updated_at}}</td>
				<td>
                  	<p class="buttons">
					  <a class="button is-warning" @click="processItem(item)">
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
<script type="text/javascript" src="{{mix('/js/applications-index.js')}}"></script>
@endsection