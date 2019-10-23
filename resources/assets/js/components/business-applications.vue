<template>
	<div id="applications" v-if="applications.length>0 && can('api.applications.show')">
		<div class="columns">
			<div class="column">
				<table class="table is-bordered is-fullwidth is-narrow is-striped">
					<thead>
						<tr>
							<th colspan="7">Applications</th>
						</tr>
						<tr>
							<th class="is-info">Id</th>
							<th class="is-info">Permit Type</th>
							<th class="is-info">Status</th>
							<th class="is-info">Register/Renew</th>
							<th class="is-info">Added On</th>
							<th class="is-info">Updated On</th>
							<th class="is-info">Options</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item,key in applications">
							<td>{{item.id}}</td>
							<td>{{item.permit_type}}</td>
							<td>{{item.status}}</td>
							<td>{{item.register_or_renew}}</td>
							<td>{{item.created_at}}</td>
							<td>{{item.updated_at}}</td>
							<td >
					      <p class="buttons pull-right">
								  <router-link v-can="'api.applications.show'" class="button is-info" :to="{ name: 'applications.show', params: { applicationId: item.id }}">
								    <span class="icon is-small">
								      <i class="fa fa-eye"></i>
								    </span>
								  </router-link>
								  <router-link v-if="item.status === 'draft' && can('api.applications.update')" class="button is-warning" :to="{ name: 'applications.edit', params: { applicationId: item.id }}">
								    <span class="icon is-small">
								      <i class="fa fa-edit"></i>
								    </span>
								  </router-link>
								  <router-link v-if="item.status === 'pending' && can('api.applications.process')" class="button is-warning" :to="{ name: 'applications.process', params: { applicationId: item.id }}">
								    <span class="icon is-small">
								      <i class="fa fa-gear"></i>
								    </span>
									</router-link>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
		  props: ['applications']
    }
</script>