<template>
<div v-can="'api.inspections.processed-reports'">
	
	<div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Handover Reports / Finish Inspection
          </h1>
      </div>
    </div>

	<div class="columns">
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Status</th>
					<th>type</th>
					<th>Inspection At</th>
					<th>Follow Up</th>
					<th>Handover Reports</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item,key in inspections">
					<td>{{item.id}}</td>
					<td>{{item.status}}</td>
					<td v-if="!item.register_or_renew">{{item.reason}}</td>
					<td v-if="item.register_or_renew">{{item.register_or_renew}}
						<!-- <router-link v-can="'api.applications.show'" class="button is-success" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}"> -->
						<router-link v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}">
							({{item.application_id}})
						</router-link>
					</td>
					<td>{{item.inspection_at}}</td>
					<td>{{item.follow_up_id}}</td>
					<td>
	                  	<p class="buttons">
						  <a v-can="'api.dhivehi-reports.issueReport'" class="button" v-if="item.dhivehi_report" v-bind:class="[(item.dhivehi_report.status != 'issued') ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(item, 'dv')">
						    <span class="icon is-small">
						      <i class="fa fa-book"></i>
						    </span>
				        <span>Dv</span>
						  </a>
						  <a v-can="'api.english-reports.issueReport'" class="button" v-if="item.english_report" v-bind:class="[(item.english_report.status != 'issued') ? isWarning : isSuccess]" alt="english report" @click="gotToReport(item,'en')">
						    <span class="icon is-small">
						      <i class="fa fa-book"></i>
						    </span>
				        	<span>En</span>
						  </a>
						</p>
					</td>
					<td>
	                  	<p class="buttons">
							<router-link class="button is-info" v-can="'api.normal-forms.show'" :to="{ name: 'normal-forms.show', params: { normalFormId: item.normal_form_id }}">
								<span class="icon is-small">
								  <i class="fa fa-list"></i>
								</span>
							</router-link>
							<router-link class="button is-warning" v-can="'api.inspections.close'" :to="{ name: 'inspections.finish', params: { inspectionId: item.id }}">
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
</template>



<script>
export default {
	data() {
		return {
			isSuccess: 'is-success',
			isWarning: 'is-grey',
			isDanger: 'is-danger',
			pagination: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
			},
			inspections: []
		}
	},
	mounted() {
		this.getInspections();
	},
	methods: {
		getInspections(page = 1) {
			if (this.hasPermission('api.inspections.processed-reports')) {
				axios
		  		.get('/api/inspections/reports/processed?'
		  			+ 'page=' + page
		  			)
					.then(response => {
						this.inspections = response.data;
						this.setPagination(response.data);
					})
					.catch(errors => console.log(errors));	
	    	}
		},
		pageChange (page) {
		    this.current = page;
		    this.getInspections(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		},
		gotToReport(item, lang) {
  			switch(lang) {
			    case "dv":
			    	this.goToDhivehiReport(item);
			        break;
			    case "en":
				    this.goToEnglishReport(item);
			        break;
			    default:
			}
		},
		goToDhivehiReport(item) {
			if (!~['processed', 'issued'].indexOf(item.dhivehi_report.status)) {
				alert('the report does not exist or is not ready to be processed.');
				return;
			} else {
				if (this.hasPermission('api.dhivehi-reports.issueReport')) {
					this.$router.push({ name: 'dhivehi-reports.handover', params: { reportId: item.dhivehi_report.id } })
				}
			}
		},
		goToEnglishReport(item) {
		    if (!~['processed', 'issued'].indexOf(item.english_report.status)) {
				alert('the report does not exist or is not ready to be processed.');
				return;
			} else {
				if (this.hasPermission('api.english-reports.issueReport')) {
					this.$router.push({ name: 'english-reports.handover', params: { reportId: item.english_report.id } })
				}
			}
		}
	}
}
</script>