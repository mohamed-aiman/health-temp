<template>
	<div v-can="'api.inspections.index'">
	    <div class="columns">
	      <div class="column is-fullwidth">
	          <h1 class="title">
	            Inspections Assigned To Me
	          </h1>
	      </div>
	    </div>
		<template v-if="inspections">
			<div class="columns" v-can="'api.inspections.index'">
				<div class="column">
					<table class="table is-fullwidth is-narrow is-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Type</th>
								<th>Registration No.</th>
								<th class="dhivehi right">ތަނުގެ ނަން.</th>
								<th>State</th>
								<th>Inspection At</th>
								<th>Options</th>
							</tr>
						</thead>
						<thead>
							<tr>
								<th>
									<input type="text"  class="input" size="4" name="inspectionId" v-model="form.inspectionId">
								</th>
								<th>
									<input type="text"  class="input" size="4" name="applicationId" v-model="form.applicationId">
								</th>
								<th>
									<input type="text"  class="input"  size="10" name="registrationNo" v-model="form.registrationNo">
								</th>
								<th class="dhivehi" style="direction: rtl">
									<input type="text"  class="input pull-right dhivehi"  size="10" name="placeNameDv" v-model="form.placeNameDv">
								</th>
								<th>
									<div class="select">
					                  <select v-model="form.state">
					                    <option value="" selected>all</option>
										<option value="created">created</option>
										<option value="scheduled">scheduled</option>
										<option value="started">started</option>
										<option value="ongoing">ongoing</option>
										<option value="completed">completed</option>
										<option value="decision_made">decision_made</option>
										<option value="finished">finished</option>
										<option value="closed">closed</option>
					                  </select>
					                </div>
								</th>
								<th>
									<b-field>
										<b-datepicker
										editable
										placeholder="Click to select..."
										icon="calendar-today"
										@input="datePickerInput"
										v-model="datePickerValue"
										>
										</b-datepicker>
										<b-button
						                @click="datePickerInput(null)"
						                icon-left="undo"
						                type="is-warning" />
									</b-field>
								</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="item in inspections">
								<td>
									<router-link v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: item.id }}">{{item.id}}</router-link>
								</td>
								<td>{{item.inspection_type_reason}}<router-link  v-if="item.application_id" v-can="'api.applications.show'" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}">({{item.application_id}})</router-link>
									{{item.is_graded ? ' (graded)' : null}}
								</td>
								<td v-if="item.business_id">
									<router-link v-can="'api.businesses.show'" :to="{ name: 'businesses.show', params: { businessId: item.business_id }}">{{item.business.registration_no}}</router-link>
								</td>
								<td v-if="item.business_id" class="dhivehi">{{item.business.name_dv}}</td>
								<td v-if="!item.business_id">Nill</td>
								<td v-if="!item.business_id" class="dhivehi">ވިޔަފާރިއަކާ ގުޅުމެއް ނެތް</td>
								<td>{{item.state}}</td>
								<td>{{item.inspection_at}}</td>
								<td>
									<router-link v-can="'api.inspections.show'" class="button is-link" :to="{ name: 'inspections.show', params: { inspectionId: item.id }}">
										<span class="icon is-small">
											<i class="fa fa-eye"></i>
										</span>
									</router-link>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
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
		</template>
	</div>
</template>

<script>
export default {
	data() {
		return {
			inspections: [],
			inspectors:[],
	        pagination: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
			},
			form: new Form({
				inspectionId: '',
				applicationId: '',
				registrationNo:'',
				placeNameDv:'',
				state: 'scheduled',
				inspectionAt: ''
			}),
			datePickerValue: null
		}
	},
  	watch: {
  		'form.inspectionId': _.debounce(function() {
  			this.getInspections();
  		}, 500),
  		'form.applicationId': _.debounce(function() {
  			this.getInspections();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getInspections();
  		}, 500),
  		 'form.placeNameDv': _.debounce(function() {
  			this.getInspections();
  		}, 500),
		'form.state': _.debounce(function() {
  			this.getInspections();
  		}, 1),
  		'form.inspectionAt': _.debounce(function() {
  			this.getInspections();
  		}, 1),
	},
	mounted() {
		this.getInspections();
	},
	methods: {
 
		datePickerInput(value) {
			if (value) {
				this.form.inspectionAt = moment(value).format('YYYY-MM-DD')
			} else {
				this.form.inspectionAt = ''
				this.datePickerValue = null
			}
		},
		getInspections(page = 1) {
			if (this.hasPermission('api.inspections.my')) {
	            axios
		  		.get('/api/inspections/my?'
		  			+ 'inspectionId=' + this.form.inspectionId
		  			+ '&applicationId=' + this.form.applicationId
		  			+ '&registrationNo=' + this.form.registrationNo
		  			+ '&placeNameDv=' + this.form.placeNameDv
		  			+ '&state=' + this.form.state
		  			+ '&inspectionAt=' + this.form.inspectionAt
		  			+ '&page=' + page
		  			)
				.then(response => {
					this.inspections = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));
			}
		},
	    pageChange(page) {
		    this.current = page;
		    this.getInspections(page);
        },
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		},
	    isFormAttached(inspection) {
	      return (inspection.normal_form_id != null) ? 'is-success' : 'is-warning';
	    }
	}
}
</script>