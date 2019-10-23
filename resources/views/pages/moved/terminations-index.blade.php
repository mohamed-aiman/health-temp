@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Terminations'])
@verbatim
<!-- <div v-can="'terminations.indexApi'"> -->
<div>
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Registration No.</th>
					<th class="dhivehi right">ތަނުގެ ނަން.</th>
					<th>Terminated On</th>
					<th>Reason</th>
					<th>Added On</th>
					<th>Updated On</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						<input type="text"  class="control" size="4" name="terminationId" v-model="form.terminationId">
					</th>
					<th>
						<input type="text"  class="control"  size="10" name="registrationNo" v-model="form.registrationNo">
					</th>
					<th class="dhivehi" style="direction: rtl">
						<input type="text"  class="control pull-right dhivehi"  size="10" name="placeNameDv" v-model="form.placeNameDv">
					</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item,key in terminations">
					<td>{{item.id}}</td>
					<td v-if="item.business_id"><a :href="'/businesses/'+item.business_id">{{item.business.registration_no}}</a></td>
					<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
					<td v-if="!item.business_id">Nill</td>
					<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
					<td>{{item.terminated_on}}</td>
					<td>{{item.reason}}</td>
					<td>{{item.created_at}}</td>
					<td>{{item.updated_at}}</td>
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
<script type="text/javascript" src="{{mix('/js/terminations-index.js')}}"></script>
@endsection