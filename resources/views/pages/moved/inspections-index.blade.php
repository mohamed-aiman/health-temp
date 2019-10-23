@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'Inspections'])

@verbatim
<template v-if="inspections">
	<div class="columns" v-can="'inspections.indexApi'">
		<div class="column">
			<table class="table is-fullwidth is-narrow is-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Application Id</th>
						<th>Registration No.</th>
						<th class="dhivehi right">ތަނުގެ ނަން.</th>
						<th>Status</th>
						<th>Type</th>
						<th>Inspection At</th>
						<th></th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th>
							<input type="text"  class="control" size="4" name="inspectionId" v-model="form.inspectionId">
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
						<th>Status</th>
						<th>Type</th>
						<th>Inspection At</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item in inspections">
						<td><a target='_blank' :href="'/inspections/'+ item.id">{{item.id}}</a></td>
						<td v-if="item.application_id"><a target='_blank' :href="'/applications/'+ item.application_id">{{item.application_id}}</a></td>
						<td v-if="!item.application_id"></td>
						<td v-if="item.business_id"><a :href="'/businesses/'+item.business_id">{{item.business.registration_no}}</a></td>
						<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
						<td v-if="!item.business_id">Nill</td>
						<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
						<td>{{item.status}}</td>
						<td v-if="!item.register_or_renew">{{item.reason}}</td>
						<td v-if="item.register_or_renew">{{item.register_or_renew}}(<a target='_blank' :href="'/applications/' + item.application_id + '/process'">{{item.application_id}}</a>)</td>
						<td>{{item.inspection_at}}</td>
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
<script type="text/javascript" src="{{mix('/js/inspections-index.js')}}"></script>
@endsection