@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Fines'])
@verbatim
<!-- <div v-can="'fines.indexApi'"> -->
<div>
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Inspection Id</th>
					<th>Registration No.</th>
					<th class="dhivehi right">ތަނުގެ ނަން.</th>
					<th>Fined On</th>
					<th>Amount(MVR)</th>
					<th>Is Paid</th>
					<th>Paid On</th>
					<th>Receipt</th>
					<th>Remarks</th>
					<th>Added On</th>
					<th>Updated On</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						<input type="text"  class="control" size="4" name="fineId" v-model="form.fineId">
					</th>
					<th>
						<input type="text"  class="control" size="4" name="inspectionId" v-model="form.inspectionId">
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
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item,key in fines">
					<td>{{item.id}}</td>
					<td><a :href="'/inspections/'+item.inspection_id">{{item.inspection_id}}</a></td>
					<td v-if="item.business_id"><a :href="'/businesses/'+item.business_id">{{item.business.registration_no}}</a></td>
					<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
					<td v-if="!item.business_id">Nill</td>
					<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
					<td>{{item.fined_on}}</td>
					<td>{{item.amount}}</td>
					<td>{{(item.is_paid) ? 'Yes' : 'No'}}</td>
					<td>{{item.paid_on}}</td>
					<td><a v-can="'fines.receipt.show'" class="button is-success is-small" target="_blank" :href="'/fines/'+item.id +'/receipt'"><b-icon icon="eye"></b-icon></a></td>
					<td>{{item.remarks}}</td>
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
<script type="text/javascript" src="{{mix('/js/fines-index.js')}}"></script>
@endsection