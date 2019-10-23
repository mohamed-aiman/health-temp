@extends('layouts.admin-light.app')

@section('content')

@include('components.heading', ['title' => '‫Dashboard'])
@verbatim

<template id="search">
	<div class="columns" v-can="'api.businesses.search'">
		<div class="column is-fullwidth">
			<div class="field">
			  <label class="label">Search for a business</label>
			  <div class="control">
			    <input class="input" name="businessesSearchTerm" type="text" v-model="businessesSearchTerm" placeholder="Business name or registration no or phone">
			  </div>
			</div>
			<template id="search-results" v-if="businesses.length > 0">
			<table  class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
				<tr>
					<td>Name</td>
					<td>Registration No.</td>
				</tr>
				<template v-for="item in businesses">
					<tr @click="goToBusiness(item.id)">
						<td>{{item.name}}</td>
						<td>{{item.registration_no}}</td>
					</tr>
				</template>
			</table>
			</template>
		</div>
	</div>
</template>
<template id="license-lists">
	<section class="hero is-warning" v-can="'api.businesses.expiringsoon'">
	  <div class="hero-body">
		<h2 class="subtitle">Expiring Soon Businesses</h2>
		<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
			<thead>
				<tr>
					<th>Name</th>
					<th>Name (dhivehi)</th>
					<th>Phone</th>
					<th>Registration No</th>
					<th>Expires On</th>
				</tr>
			</thead>
			<tbody>
				<template v-for="item,key in expiringBusinesses">
					<tr @click="goToBusiness(item.id)">
						<td>{{item.name}}</td>
						<td>{{item.name_dv}}</td>
						<td>{{item.phone}}</td>
						<td>{{item.registration_no}}</td>
						<td>{{item.expire_at}}</td>
					</tr>
				</template>
			</tbody>
		</table>
	    <b-pagination
	        :total="pagination1.total"
	        :current.sync="pagination1.current"
	        :order="pagination1.order"
	        :size="pagination1.size"
	        :simple="pagination1.isSimple"
	        :rounded="pagination1.isRounded"
	        :per-page="pagination1.perPage"
	        @change="pageChange1">
	    </b-pagination>
	  </div>
	</section>
	<br>
	<section class="hero is-danger" v-can="'api.businesses.expired'" v-if="expiredBusinesses.length>0">
	  <div class="hero-body">
		<h2 class="subtitle">Expired Businesses</h2>
		<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
			<thead>
				<tr>
					<th>Name</th>
					<th>Name (dhivehi)</th>
					<th>Phone</th>
					<th>Registration No</th>
					<th>Expired On</th>
				</tr>
			</thead>
			<tbody>
				<template v-for="item,key in expiredBusinesses">
					<tr @click="goToBusiness(item.id)">
						<td>{{item.name}}</td>
						<td>{{item.name_dv}}</td>
						<td>{{item.phone}}</td>
						<td>{{item.registration_no}}</td>
						<td>{{item.expire_at}}</td>
					</tr>
				</template>
			</tbody>
		</table>
	    <b-pagination
	        :total="pagination2.total"
	        :current.sync="pagination2.current"
	        :order="pagination2.order"
	        :size="pagination2.size"
	        :simple="pagination2.isSimple"
	        :rounded="pagination2.isRounded"
	        :per-page="pagination2.perPage"
	        @change="pageChange2">
	    </b-pagination>
	  </div>
	</section>
</template>

<template id="inspection-lists">
	<br>
	<section class="hero is-warning" v-can="'api.inspections.upcoming'" v-if="upcomingInspections.length>0">
	  <div class="hero-body">
		<h2 class="subtitle">Upcoming Inspections</h2>
		<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
			<thead>
				<tr>
					<th>Name</th>
					<th>Name (dhivehi)</th>
					<th>Phone</th>
					<th>Registration No</th>
					<th>Expires On</th>
					<th>Inspection At</th>
				</tr>
			</thead>
			<tbody>
				<template v-for="item,key in upcomingInspections">
					<tr @click="goToBusiness(item.business.id)">
						<td>{{item.business.name}}</td>
						<td>{{item.business.name_dv}}</td>
						<td>{{item.business.phone}}</td>
						<td>{{item.business.registration_no}}</td>
						<td>{{item.business.expire_at}}</td>
						<td>{{item.inspection_at}}</td>
					</tr>
				</template>
			</tbody>
		</table>
	    <b-pagination
	        :total="pagination4.total"
	        :current.sync="pagination4.current"
	        :order="pagination4.order"
	        :size="pagination4.size"
	        :simple="pagination4.isSimple"
	        :rounded="pagination4.isRounded"
	        :per-page="pagination4.perPage"
	        @change="pageChange4">
	    </b-pagination>
	  </div>
	</section>
	<br>
</template>

<template id="grading-lists">
	<br>
	<section class="hero is-warning" v-can="'api.grading-inspections.upcoming'"v-if="upcomingGradingInspections.length>0">
	  <div class="hero-body">
		<h2 class="subtitle">Upcoming Grading Inspections</h2>
		<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
			<thead>
				<tr>
					<th>Name</th>
					<th>Name (dhivehi)</th>
					<th>Phone</th>
					<th>Registration No</th>
					<th>Expires On</th>
					<th>Inspection At</th>
				</tr>
			</thead>
			<tbody>
				<template v-for="item,key in upcomingGradingInspections">
					<tr @click="goToGradingInspection(item.id)">
						<td>{{item.business.name}}</td>
						<td>{{item.business.name_dv}}</td>
						<td>{{item.business.phone}}</td>
						<td>{{item.business.registration_no}}</td>
						<td>{{item.business.expire_at}}</td>
						<td>{{item.inspection_at}}</td>
					</tr>
				</template>
			</tbody>
		</table>
	    <b-pagination
	        :total="pagination3.total"
	        :current.sync="pagination3.current"
	        :order="pagination3.order"
	        :size="pagination3.size"
	        :simple="pagination3.isSimple"
	        :rounded="pagination3.isRounded"
	        :per-page="pagination3.perPage"
	        @change="pageChange3">
	    </b-pagination>
	  </div>
	</section>
	<br>
</template>
@endverbatim
@endsection

@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/dashboard-search-list.js')}}"></script>
@endsection