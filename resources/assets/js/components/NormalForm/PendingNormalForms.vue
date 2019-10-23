<template>
	
	<div v-can="'api.normal-forms.pending'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Inspection forms to be processed
          </h1>
      </div>
    </div>
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
						<th>Process</th>
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
							  <a class="button is-warning" v-can="'api.normal-forms.changedStatusToProcessed'" @click="processItem(item)">
							    <span class="icon is-small">
							      <i class="fa fa-gear"></i>
							    </span>
							  </a>
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
			if (this.hasPermission('api.normal-forms.pending')) {
					axios
		  		.get('/api/normalforms/pending?'
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
		processItem(item) {
			if (this.hasPermission('api.normal-forms.changedStatusToProcessed')) {
		      this.$router.push({ name: 'normal-forms.process', params: { normalFormId: item.id } })
			}
		}
	}
}

</script>