<template>
	
	<div v-can="'api.normal-forms.processed'">
		<div>
			<table class="table is-fullwidth is-narrow is-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Applied Date</th>
						<th>Applied Reason</th>
						<th>Reason</th>
						<th>Place Name and Address</th>
						<th>Updated On</th>
						<th>Options</th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item,key in normalforms">
						<td>{{item.id}}</td>
						<td>{{item.applied_date}}</td>
						<td>{{item.applied_reason}}</td>
						<td>{{item.inspection_reason}}</td>
						<td>{{item.place_name_address}}</td>
						<td>{{item.updated_at}}</td>
						<td>
		          <p class="buttons">
                <router-link class="button is-info" v-can="'api.normal-forms.show'" :to="{ name: 'normal-forms.show', params: { normalFormId: item.id }}">
							    <span class="icon is-small">
							      <i class="fa fa-eye"></i>
							    </span>
							    <span>Check List</span>
                </router-link>
							  <a class="button" v-can="'api.dhivehi-reports.update'" v-bind:class="[(item.normal_inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="gotToReport(item.normal_inspection, 'dv')">
							    <span class="icon is-small">
							      <i class="fa fa-book"></i>
							    </span>
					        <span>Dv</span>
							  </a>
							  <a class="button" v-can="'api.english-reports.update'" v-bind:class="[(item.normal_inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="gotToReport(item.normal_inspection,'en')">
						    	<span class="icon is-small">
						      	<i class="fa fa-book"></i>
						    	</span>
				        	<span>En</span>
							  </a>
			          <router-link class="is-info button" v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: item.normal_inspection.id }}">
								  <span class="icon is-small">
								    <i class="fa fa-eye"></i>
								  </span>
							    <span>Inspection</span>
			          </router-link>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div>
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
			isWarning: 'is-warning',
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
			normalforms: [],
		}
	},
	mounted() {
		this.getNormalForms();
	},
	methods: {
		getNormalForms(page = 1) {
			if (this.hasPermission('api.normal-forms.processed'))
				axios
		  		.get('/api/normalforms/processed?'
		  			+ 'page=' + page
		  			)
					.then(response => {
						this.normalforms = response.data.data;
						this.setPagination(response.data);
					})
					.catch(errors => console.log(errors));
			}
		},
		pageChange (page) {
		    this.current = page;
		    this.getNormalForms(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		},
		gotToReport(item, lang) {
  			switch(lang) {
			    case "dv":
		                this.$router.push({ name: 'inspections.dhivehi-reports.edit', params: { inspectionId: item.id } })
			        break;
			    case "en":
		                this.$router.push({ name: 'inspections.english-reports.edit', params: { inspectionId: item.id } })
			        break;
			    default:
			}
		}
	}

}

</script>