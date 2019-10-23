<template>
<div v-can="'api.licenses.index'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            All Licenses
          </h1>
      </div>
    </div>

    <div class="columns">
    	<div class="column">
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Application</th>
					<th>Registration No.</th>
					<th class="dhivehi right">ތަނުގެ ނަން.</th>
					<th>License No.</th>
					<th>Issued On</th>
					<th>Expires At</th>
					<th>Receipt</th>
					<th>Register/Renew</th>
					<th>Tobacco/Food</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						<input type="text"  class="control" size="4" name="licenseId" v-model="form.licenseId">
					</th>
					<th>
						<input type="text"  class="control" size="4" name="applicationId" v-model="form.applicationId">
					</th>
					<th>
						<input type="text"  class="control"  size="10" name="registrationNo" v-model="form.registrationNo">
					</th>
					<th class="dhivehi" style="direction: rtl">
						<input type="text"  class="control pull-right dhivehi"  size="10" name="placeNameDv" v-model="form.placeNameDv">
					</th>
					<th>
						<input type="text"  class="control"  size="10" name="licenseNo" v-model="form.licenseNo">
					</th>
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
				<tr v-for="item,key in licenses">
					<td>{{item.id}}</td>
					<td>
						<router-link v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}">{{item.application_id}}</router-link>
					</td>
					<td v-if="item.business_id">
						<router-link v-can="'api.businesses.show'" :to="{ name: 'businesses.show', params: { businessId: item.business_id }}">{{item.business.registration_no}}</router-link>
					</td>
					<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
					<td v-if="!item.business_id">Nill</td>
					<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
					<td>{{item.license_no}}</td>
					<td>{{item.issued_at}}</td>
					<td>{{item.paid_on}}</td>
					<td><a v-can="'licenses.receipt.show'" class="button is-success is-small" target="_blank" :href="'/licenses/'+item.id +'/receipt'"><b-icon icon="eye"></b-icon></a></td>
					<td>{{item.register_or_renew}}</td>
					<td>{{item.tobacco_or_food}}</td>
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
			licenses: [],
			form: new Form({
				licenseId: '',
				applicationId: '',
				registrationNo:'',
				placeNameDv:'',
				licenseNo:''
			})
		}
	},
  	watch: {
  		'form.licenseId': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
  		'form.applicationId': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
  		'form.placeNameDv': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
		'form.licenseNo': _.debounce(function() {
  			this.getLicenses();
  		}, 500)
	},
	mounted() {
		this.getLicenses();
	},
	methods: {
		getLicenses(page = 1) {
			if (this.hasPermission('api.licenses.index')) {
				axios
		  		.get('/api/licenses?' 
		  			+ 'licenseId=' + this.form.licenseId
		  			+ '&applicationId=' + this.form.applicationId
		  			+ '&registrationNo=' + this.form.registrationNo
		  			+ '&placeNameDv=' + this.form.placeNameDv
		  			+ '&licenseNo=' + this.form.licenseNo
		  			+ '&page=' + page
		  			)
					.then(response => {
						this.licenses = response.data.data;
						this.setPagination(response.data);
					})
					.catch(errors => console.log(errors));
			}
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getLicenses(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
}
</script>