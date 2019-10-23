<template>
	<div class="columns" v-if="inspections.length>0 && can('api.inspections.show')">
		<div class="column">
			<table class="table is-bordered is-fullwidth is-narrow is-striped">
				<tr>
					<th colspan="7">Inspections</th>
				</tr>
				<tr>
					<th class="is-info">Id</th>
					<th class="is-info">Status</th>
					<th class="is-info">type</th>
					<th class="is-info">Inspection At</th>
					<th class="is-info">Follow Up</th>
					<th class="is-info">Tags</th>
					<th class="is-info">Options</th>
				</tr>
				<tr v-for="item in inspections">
					<td>{{item.id}}</td>
					<td>{{item.status}}</td>
					<td v-if="!item.register_or_renew">{{(item.reason == 'Complaint') ? item.reason+' ('+item.complaint_id+')' : item.reason}}</td>
					<td v-if="item.register_or_renew">
						{{item.register_or_renew}}
						<!-- <router-link v-can="'api.applications.show'" class="button is-success" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}"> -->
						<router-link v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}">
							({{item.application_id}})
						</router-link>
					</td>
					<td>{{item.inspection_at}}</td>
					<td>{{item.follow_up_id}}</td>
					<td>
						<div class="tags">
							<div class="tag is-warning" v-if="item.is_followup_required">followup required</div>
							<div class="tag is-danger" v-if="item.is_fined">fined</div>
						</div>
					</td>
					<td>
		      <p class="buttons pull-right">
							  <a class="button is-success" v-if="item.dhivehi_report_id != null && can('api.dhivehi-reports.show')" alt="dhivehi report" @click="gotToReport(item, 'dv')">
							    <span class="icon is-small">
							      <i class="fa fa-book"></i>
							    </span>
					        <span>Dv</span>
							  </a>
							  <a class="button is-success" v-if="item.english_report_id != null && can('api.english-reports.show')" alt="english report" @click="gotToReport(item,'en')">
						    <span class="icon is-small">
						      <i class="fa fa-book"></i>
						    </span>
				        	<span>En</span>
							  </a>
								<router-link class="button is-info" v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: item.id }}">
									<span class="icon is-small">
								    <i class="fa fa-eye"></i>
								  </span>
								</router-link>

								<router-link 
									class="button is-success"
									v-if="item.normal_form_id != null && can('api.normal-inspections.normalforms.show')"
									alt="go to inspection form"
									:to="{ name: 'normal-inspections.normalforms.show', params: { inspectionId: item.id }}">
										<span class="icon is-small">
										  <i class="fa fa-list"></i>
										</span>
								</router-link>
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
    export default {
		  props: ['inspections'],
		  data() {
		  	return {
		  		file: []
		  	}
		  },
		  methods: {
				gotToReport(item, lang) {
		  			switch(lang) {
					    case "dv":
								this.$router.push({ name: 'inspections.dhivehi-reports.show', params: { inspectionId: item.id } })
					        break;
					    case "en":
								this.$router.push({ name: 'inspections.english-reports.show', params: { reportId: item.id } })
					        break;
					    default:
					}
				}
		  }
    }
</script>
