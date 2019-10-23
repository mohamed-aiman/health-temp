<template>
	<!-- <div class="columns" v-if="complaints.length>0 && can('api.complaints.index')"> -->
	<div class="columns" v-if="complaints.length>0">
		<div class="column">
			<table class="table is-bordered is-fullwidth is-narrow is-striped">
				<tr>
					<th colspan="7">Complaints</th>
				</tr>
				<tr>
					<th class="is-info">Id</th>
					<th class="is-info">Reference</th>
					<th class="is-info dhivehi right">ޚުލާސާ</th>
					<th class="is-info">Complaint At</th>
				</tr>
				<tr v-for="item in complaints">
					<td>{{item.id}}</td>
					<td>{{item.reference}}</td>
					<td class="dhivehi right">{{item.summary}}</td>
					<td>{{item.complaint_at}}</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
    export default {
		  props: ['complaints'],
		  data() {
		  	return {
		  		file: []
		  	}
		  },
		  methods: {
		  	scheduleComplaintInspection(complaint) {
		  		console.log(complaint);
		  		this.$emit('scheduleAnInspection', complaint)
		  	}
			// deleteComplaint(complaint) {
			// 	axios
			// 	.delete('/api/complaints/' + complaint.id)
			// 	.then(response => {
			// 		this.$emit('refresh');
			// 	})
			// 	.catch(errors => {
			// 		console.log('errors', errors);
			// 	});	
			// }
		  }
    }
</script>
