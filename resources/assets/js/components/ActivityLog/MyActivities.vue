<template>
	<div v-can="'api.my.activities'">
		<div>
		    <table class="table is-narrow">
		        <thead>
		            <td>Description</td>
		            <td>Subject id</td>
		            <td>Subject type</td>
		            <td>Logged At</td>
		        </thead>
		        <tbody>
		            <tr v-for="item,key in activities">
		                <td>{{item.description}}</td>
		                <td>{{item.subject_id}}</td>
		                <td>{{item.subject_type}}</td>
		                <td>{{item.created_at}}</td>
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
			pagination: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
			},
			activities: []
		}
	},
	mounted() {
		this.getActivities();
	},
	methods: {
		getActivities(page = 1) {
			axios
	  		.get('/api/my/activities?'
	  			+ 'page=' + page
	  			)
				.then(response => {
					this.activities = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getActivities(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}

}
</script>