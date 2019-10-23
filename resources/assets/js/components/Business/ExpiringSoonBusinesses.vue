<template>
<div v-can="'api.businesses.expiringsoon'">
	<div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            License Expiring Soon
          </h1>
      </div>
    </div>

	<div class="container">
		<template v-if="businesses">
		<div class="container">
			<div class="columns">
				<div class="column box">
					<div class="columns">
							<div class="column">
							  <label class="label">businesses</label>
							</div>
					</div>
					<div class="columns">
						<table class="table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Business Name</th>
									<th>Expires At</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in businesses">
									<td>{{item.id}}</td>
									<td><router-link v-can="'api.businesses.show'" :to="{ name: 'businesses.show', params: { businessId: item.id }}">{{item.name}}</router-link></td>
									<td>{{item.expire_at}}</td>
									<td>
										<p class="buttons">
											<router-link v-can="'api.businesses.show'" class="button is-link" :to="{ name: 'businesses.show', params: { businessId: item.id }}">
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
				</div>
			</div>
			<br/>
			<br/>
		</div>
		</template>
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
        	businesses: [],
	        pagination: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
	        }
	    }
    },
    mounted() {
        this.getbusinesses();
    },
    methods: {
        getbusinesses(page = 1) {
        	if (this.hasPermission('api.businesses.expiringsoon')) {
	            axios
	              .get('/api/businesses/expiringsoon?'
	                  + 'page=' + page
	                  )
	            .then(response => {
	                this.businesses = response.data.data;
	                this.setPagination(response.data);
	            })
	            .catch(errors => console.log(errors));
	        }
        },
        pageChange (page) {
            this.current = page
            // this.filter.offset = ((this.current - 1) * this.filter.limit)
            this.getbusinesses(page);
        },
        setPagination(data) {
            this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
        },
    }
}

</script>