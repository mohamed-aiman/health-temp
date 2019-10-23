<template>
		<div class="columns" v-can="'api.businesses.show'">
			<div class="column">
				<table class="table is-bordered is-fullwidth is-narrow is-striped">
					<tr>
						<th colspan="2">
							<router-link v-can="'api.businesses.show'" class="is-link" :to="{ name: 'businesses.show', params: { businessId: business.id }}">Business Details
							</router-link>
							<div class="tag is-danger" v-if="business.termination_id != null">
								TERMINATED
							</div>
							<div class="pull-right">
					            <close-establishment-modal :business="business" :inspection="null" @refresh="refreshPage"></close-establishment-modal>
							</div>
						</th>
					</tr>
					<tr>
						<td>Name:</td>
						<td>{{business.name}}</td>
					</tr>
					<tr>
						<td>Name (Dhivehi):</td>
						<td class="dhivehi">{{business.name_dv}}</td>
					</tr>
					<tr>
						<td>Registration No:</td>
						<td>{{business.registration_no}}</td>
					</tr>
					<tr>
						<td>Phone:</td>
						<td>{{business.phone}}</td>
					</tr>
					<tr>
						<td>Expires at:</td>
						<td>{{business.expire_at}}</td>
					</tr>
					<slot></slot>
				</table>
			</div>
		</div>
</template>

<script>
	import CloseEstablishmentModal from './Common/CloseEstablishmentModal';
    export default {
		  props: ['business'],
		  components: {
		  	'close-establishment-modal': CloseEstablishmentModal
		  },
		  methods: {
		  	refreshPage() {
		  		this.$emit('refresh')
		  	}
		  }
    }
</script>
