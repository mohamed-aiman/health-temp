@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Licenses'])
@verbatim
<!-- <div v-can="'licenses.indexApi'"> -->
<div>
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Application</th>
					<th>Registration No.</th>
					<th class="dhivehi right">ތަނުގެ ނަން.</th>
					<th>License No.</th>
					<th>Issued On</th>
					<th>Expires At</th>
					<th>Receipt</th>
					<th>Register/Renew</th>
					<th>Tobacco/Food</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						<input type="text"  class="control" size="4" name="licenseId" v-model="form.licenseId">
					</th>
					<th>
						<input type="text"  class="control" size="4" name="applicationId" v-model="form.applicationId">
					</th>
					<th>
						<input type="text"  class="control"  size="10" name="registrationNo" v-model="form.registrationNo">
					</th>
					<th class="dhivehi" style="direction: rtl">
						<input type="text"  class="control pull-right dhivehi"  size="10" name="placeNameDv" v-model="form.placeNameDv">
					</th>
					<th>
						<input type="text"  class="control"  size="10" name="licenseNo" v-model="form.licenseNo">
					</th>
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
				<tr v-for="item,key in licenses">
					<td>{{item.id}}</td>
					<td><a :href="'/applications/'+item.application_id">{{item.application_id}}</a></td>
					<td v-if="item.business_id"><a :href="'/businesses/'+item.business_id">{{item.business.registration_no}}</a></td>
					<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
					<td v-if="!item.business_id">Nill</td>
					<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
					<td>{{item.license_no}}</td>
					<td>{{item.issued_at}}</td>
					<td>{{item.paid_on}}</td>
					<td><a v-can="'licenses.receipt.show'" class="button is-success is-small" target="_blank" :href="'/licenses/'+item.id +'/receipt'"><b-icon icon="eye"></b-icon></a></td>
					<td>{{item.register_or_renew}}</td>
					<td>{{item.tobacco_or_food}}</td>
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
<script type="text/javascript" src="{{mix('/js/licenses-index.js')}}"></script>
@endsection