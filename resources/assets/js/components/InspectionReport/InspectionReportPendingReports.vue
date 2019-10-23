<template>
<div v-can="'api.inspections.pending-reports'">
	<div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Processed Inspection Forms having Pending Reports
          </h1>
      </div>
    </div>

	<div>
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Status</th>
					<th>type</th>
					<th>Inspection At</th>
					<th>Follow Up</th>
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
						<router-link v-if="item.application_id" v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}">
							({{item.application_id}})
						</router-link>
					</td>
					<td>{{item.inspection_at}}</td>
					<td>{{item.follow_up_id}}</td>
					<td>
              <router-link class="button is-success" v-can="'api.normal-inspections.normalforms.show'" alt="go to inspection form" :to="{ name: 'normal-inspections.normalforms.show', params: { inspectionId: item.id }}">
                  <span class="icon is-small">
                    <i class="fa fa-list"></i>
                  </span>
              </router-link>

						  <a class="button" v-can="'api.dhivehi-reports.changedStatusToProcessed'" v-if="item.dhivehi_report" v-bind:class="[(item.dhivehi_report.status != 'pending') ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(item, 'dv')">
						    <span class="icon is-small">
						      <i class="fa fa-book"></i>
						    </span>
					        <span>Dv</span>
						  </a>
						  <a class="button" v-can="'api.english-reports.changedStatusToProcessed'"  v-if="item.english_report" v-bind:class="[(item.english_report.status != 'pending') ? isWarning : isSuccess]" alt="english report" @click="gotToReport(item,'en')">
					    	<span class="icon is-small">
					      		<i class="fa fa-book"></i>
					    	</span>
				        	<span>En</span>
						  </a>
						  <router-link class="button is-success" v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: item.id }}">
								<span class="icon is-small">
								    <i class="fa fa-eye"></i>
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
			if (this.hasPermission('api.inspections.pending-reports')) {
				axios
		  		.get('/api/inspections/reports/pending?'
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
			if (item.dhivehi_report.status != 'pending') {
				alert('the report does not exist or is not ready to be processed.');
				return;
			} else {
				if (this.hasPermission('api.dhivehi-reports.changedStatusToProcessed')) {
          			this.$router.push({ name: 'dhivehi-reports.process', params: { reportId: item.dhivehi_report.id } })
  				}
			}
		},
		goToEnglishReport(item) {
		    if (item.english_report.status != 'pending') {
				alert('the report does not exist or is not ready to be processed.');
				return;
			} else {
				if (this.hasPermission('api.english-reports.changedStatusToProcessed')) {
          			this.$router.push({ name: 'english-reports.process', params: { reportId: item.english_report.id } })
	  			}
			}
		}
	}
}

</script>