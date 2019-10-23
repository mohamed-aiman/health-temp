@extends('layouts.app')

@section('content')

@include('components.heading', ['title' => 'License Expiring Soon'])

<div class="container">
@verbatim
	<template v-if="businesses">
	<div class="container">
		<div class="columns">
			<div class="column box">
				<div class="columns">
						<div class="column">
						  <label class="label">businesses</label>
						</div>
				</div>
				<div class="columns">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Business Name</th>
								<th>Expires At</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="item in businesses">
								<td>{{item.id}}</td>
								<td><a target='_blank' :href="'/businesses/'+ item.id">{{item.name}}</a></td>
								<td>{{item.expire_at}}</td>
								<td>
									<p class="buttons">
									    <a class="button is-link" target='_blank'  :href="'/businesses/'+item.id">
									    	<span class="icon is-small">
										      <i class="fa fa-eye"></i>
										    </span>
										</a>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br/>
		<br/>
	</div>
	</template>
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
@endverbatim
@endsection
@section('page-last-scripts')
<script type="text/javascript" src="{{mix('/js/expiring-soon-businesses.js')}}"></script>
@endsection