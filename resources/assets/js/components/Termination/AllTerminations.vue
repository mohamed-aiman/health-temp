<template>
<div v-can="'api.terminations.index'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            All Terminations
          </h1>
      </div>
    </div>

    <div class="columns">
	    <div class="column">
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Registration No.</th>
					<th class="dhivehi right">ތަނުގެ ނަން.</th>
					<th>Terminated On</th>
					<th>Reason</th>
					<th>Added On</th>
					<th>Updated On</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						<input type="text"  class="control" size="4" name="terminationId" v-model="form.terminationId">
					</th>
					<th>
						<input type="text"  class="control"  size="10" name="registrationNo" v-model="form.registrationNo">
					</th>
					<th class="dhivehi" style="direction: rtl">
						<input type="text"  class="control pull-right dhivehi"  size="10" name="placeNameDv" v-model="form.placeNameDv">
					</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item,key in terminations">
					<td>{{item.id}}</td>
					<td v-if="item.business_id">
						<router-link v-can="'api.businesses.show'" :to="{ name: 'businesses.show', params: { businessId: item.business_id }}">{{item.business.registration_no}}</router-link>
					</td>
					<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
					<td v-if="!item.business_id">Nill</td>
					<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
					<td>{{item.terminated_on}}</td>
					<td>{{item.reason}}</td>
					<td>{{item.created_at}}</td>
					<td>{{item.updated_at}}</td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	<div class="columns">
		<div class="column">
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
			terminations: [],
			form: new Form({
				terminationId: '',
				inspectionId: '',
				registrationNo:'',
				placeNameDv:''
			})
		}
	},
  	watch: {
  		'form.terminationId': _.debounce(function() {
  			this.getTerminations();
  		}, 500),
  		'form.inspectionId': _.debounce(function() {
  			this.getTerminations();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getTerminations();
  		}, 500),
  		'form.placeNameDv': _.debounce(function() {
  			this.getTerminations();
  		}, 500)
	},
	mounted() {
		this.getTerminations();
	},
	methods: {
		getTerminations(page = 1) {
			if (this.hasPermission('api.terminations.index')) {
				axios
		  		.get('/api/terminations?' 
		  			+ 'terminationId=' + this.form.terminationId
		  			+ '&inspectionId=' + this.form.inspectionId
		  			+ '&registrationNo=' + this.form.registrationNo
		  			+ '&placeNameDv=' + this.form.placeNameDv
		  			+ '&page=' + page
		  			)
					.then(response => {
						this.terminations = response.data.data;
						this.setPagination(response.data);
					})
					.catch(errors => console.log(errors));
			}
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getTerminations(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
}

</script>