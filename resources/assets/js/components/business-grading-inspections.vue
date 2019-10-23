<template>
	<div class="columns" v-can="'api.grading-inspections.show'">
		<div class="column">
			<table class="table is-bordered is-fullwidth is-narrow is-striped">
				<tr>
					<th colspan="9">‫‫‪Grading Inspections</th>
				</tr>
				<tr v-if="grading_inspections.length>0">
					<th class="is-info">id</th>
					<th class="is-info">inspection at</th>
					<th class="is-info">status</th>
					<th class="is-info">place_name</th>
					<th class="is-info">food registration no</th>
					<!-- <th class="is-info">owner</th> -->
					<th class="is-info">inspection date</th>
					<!-- <th class="is-info">permit limit</th> -->
					<th class="is-info">phone</th>
					<!-- <th class="is-info">information provider</th> -->
					<th class="is-info">reason</th>
					<th class="is-info">options</th>
				</tr>
				<tr v-for="item in grading_inspections">
					<td>{{item.id}}</td>
					<td>{{item.inspection_at}}</td>
					<td>{{item.status}}</td>
					<td><span v-if="item.grading_form_single">{{item.grading_form_single.place_name}}</span></td>
					<td><span v-if="item.grading_form_single">{{item.grading_form_single.food_registration_no}}</span></td>
					<!-- <td><span v-if="item.grading_form_single">{{item.grading_form_single.owner}}</span></td> -->
					<td><span v-if="item.grading_form_single">{{item.grading_form_single.inspection_date}}</span></td>
					<!-- <td><span v-if="item.grading_form_single">{{item.grading_form_single.permit_limit}}</span></td> -->
					<td><span v-if="item.grading_form_single">{{item.grading_form_single.phone}}</span></td>
					<!-- <td><span v-if="item.grading_form_single">{{item.grading_form_single.information_provider}}</span></td> -->
					<td><span v-if="item.grading_form_single">{{item.grading_form_single.inspection_reason}}</span></td>
					<td>
  						<router-link 
  							class="button"
  							v-bind:class="[(item.grading_form_id == null) ? 'is-warning' : 'is-success']"
  							alt="report"
  							v-can="'api.grading-forms.update'"
  							:to="{ name: 'grading-inspections.gradingforms.edit', params: { inspectionId: item.id }}">
						  <span class="icon is-small">
						      <i class="fa fa-book"></i>
						  </span>
						</router-link>
						<router-link class="button is-link" v-can="'api.grading-inspections.update'" :to="{ name: 'grading-inspections.edit', params: { inspectionId: item.id }}">
						  <span class="icon is-small"><i class="fa fa-gear"></i></span>
						</router-link>
					</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
export default {
	  props: ['grading_inspections'],
	  data() {
	  	return {
	  		file: []
	  	}
	  }
}
</script>