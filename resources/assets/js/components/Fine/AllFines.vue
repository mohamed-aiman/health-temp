<template>
<div v-can="'api.fines.index'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            All Fines
          </h1>
      </div>
    </div>

    <div class="columns">
		<div class="column">
		<table class="table is-fullwidth is-narrow is-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th v-can="'api.inspections.show'">Inspection Id</th>
					<th>Registration No.</th>
					<th class="dhivehi right">ތަނުގެ ނަން.</th>
					<th>Fined On</th>
					<th>Amount(MVR)</th>
					<th>Is Paid</th>
					<th>Paid On</th>
					<th>Receipt</th>
					<th>Remarks</th>
					<th>Added On</th>
					<th>Updated On</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>
						<input type="text"  class="control" size="4" name="fineId" v-model="form.fineId">
					</th>
					<th v-can="'api.inspections.show'">
						<input type="text"  class="control" size="4" name="inspectionId" v-model="form.inspectionId">
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
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="item,key in fines">
					<td>{{item.id}}</td>
					<td v-can="'api.inspections.show'"><router-link :to="{ name: 'inspections.show', params: { inspectionId: item.inspection_id }}">{{item.inspection_id}}</router-link></td>
					<td v-if="item.business_id"><router-link v-can="'api.businesses.show'" :to="{ name: 'businesses.show', params: { businessId: item.business_id }}">{{item.business.registration_no}}</router-link></td>
					<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
					<td v-if="!item.business_id">Nill</td>
					<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
					<td>{{item.fined_on}}</td>
					<td>{{item.amount}}</td>
					<td>{{(item.is_paid) ? 'Yes' : 'No'}}</td>
					<td>{{item.paid_on}}</td>
					<td><a v-can="'fines.receipt.show'" class="button is-success is-small" target="_blank" :href="'/fines/'+item.id +'/receipt'"><b-icon icon="eye"></b-icon></a></td>
					<td>{{item.remarks}}</td>
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
			fines: [],
			form: new Form({
				fineId: '',
				inspectionId: '',
				registrationNo:'',
				placeNameDv:''
			})
		}
	},
  	watch: {
  		'form.fineId': _.debounce(function() {
  			this.getFines();
  		}, 500),
  		'form.inspectionId': _.debounce(function() {
  			this.getFines();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getFines();
  		}, 500),
  		'form.placeNameDv': _.debounce(function() {
  			this.getFines();
  		}, 500)
	},
	mounted() {
		this.getFines();
	},
	methods: {
		getFines(page = 1) {
			if (this.hasPermission('api.fines.index')) {
				axios
		  		.get('/api/fines?' 
		  			+ 'fineId=' + this.form.fineId
		  			+ '&inspectionId=' + this.form.inspectionId
		  			+ '&registrationNo=' + this.form.registrationNo
		  			+ '&placeNameDv=' + this.form.placeNameDv
		  			+ '&page=' + page
		  			)
					.then(response => {
						this.fines = response.data.data;
						this.setPagination(response.data);
					})
					.catch(errors => console.log(errors));	
			}
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getFines(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
}
</script>