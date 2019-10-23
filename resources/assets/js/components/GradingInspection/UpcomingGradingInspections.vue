<template>
<div v-can="'api.grading-inspections.upcoming'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Upcoming Grading Inspections
          </h1>
      </div>
    </div>
	<template v-if="inspections">
	<div>
		<div class="columns" v-if="editMode">
			<div class="column box">
				<div class="columns">
					<div class="column">
					  <div class="label is-normal">
					    <label class="label">Updating Inspection id: {{inspectionForm.inspection_id}}</label>
					  </div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field">
						  <label class="label">Status</label>
							<div class="select">
							  <select v-model="inspectionForm.status">
							    <option value="scheduled">Scheduled</option>
							    <option value="finished">Finished</option>
							    <option value="cancelled">Cancelled</option>
							  </select>
							</div>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<template>
							    <b-field label="Select a date">
							        <b-datepicker
							            placeholder="Click to select..."
							            icon="calendar-today"
		                      			@input="datePickerInput"
							            v-model="inspectionForm.date">
							        </b-datepicker>
							    </b-field>
							</template>
						</div>
					</div>
					<div class="column">
						<div class="field">
						  <template>
							    <b-field label="Select timepicker">
							        <b-timepicker
							            placeholder="Type or select a date..."
							            icon="clock"
							            editable
		                      			@input="timePickerInput"
							            v-model="inspectionForm.time">
							        </b-timepicker>
							    </b-field>
							</template>
						</div>
					</div>
					<div class="column">
						<div class="field">
						  <label class="label">&nbsp</label>
						  <div class="control">
						    <button class="button is-link" @click="updateInspection">Update Inspection</button>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="columns">
			<div class="column box">
				<div class="columns">
						<div class="column">
						  <label class="label">Inspections</label>
						</div>
				</div>
				<div class="columns">
					<table class="table">
						<thead>
							<tr>
								<th>Id</th>
								<th>Business Name</th>
								<th>Status</th>
								<th>Type</th>
								<th>Inspection At</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="item in inspections">
								<td>{{item.id}}</td>
								<td><router-link v-can="'api.businesses.show'" :to="{ name: 'businesses.show', params: { businessId: item.business.id }}">{{item.business.name}}</router-link>
								<td>{{item.status}}</td>
								<td>{{(item.reason) ? item.reason : '-'}}</td>
								<td>{{item.inspection_at}}</td>
								<td>
									<p class="buttons">
										<router-link v-can="'api.grading-inspections.show'" class="button is-link" :to="{ name: 'grading-inspections.show', params: { inspectionId: item.id }}">
											<span class="icon is-small">
												<i class="fa fa-eye"></i>
											</span>
										</router-link>
										<a class="button is-warning"  v-can="'api.grading-inspections.update'" alt="dhivehi report" @click="toggleEditItemMode(item)">
											<span class="icon is-small">
										  		<i class="fa fa-edit"></i>
											</span>
										</a>
					                    <router-link 
					                      class="button "
					                      v-can="'api.grading-inspections.gradingforms.show'"
					                      v-bind:class="[isFormAttached(item)]"
					                      alt="go to inspection form"
					                      :to="{ name: 'grading-inspections.gradingforms.show', params: { inspectionId: item.id }}">
					                        <span class="icon is-small">
					                          <i class="fa fa-list"></i>
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
        	isSuccess: 'is-success',
	        isWarning: 'is-warning',
	        isDanger: 'is-danger',
	        states: ['scheduled', 'finished', 'cancelled'],
	        inspections: [],
	        editMode: false,
	        inspectionForm: new Form({
	            date:new Date(),
	            time: new Date(),
	            datetimeString: '',
	            dateString: '',
	            timeString: '',
	            inspection_id: null
	        }),
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
	watch: {
    },
    mounted() {
        this.getInspections();
        this.datePickerInput();
        this.timePickerInput();
    },
    methods: {
        getInspections(page = 1) {
        	if (this.hasPermission('api.grading-inspections.upcoming')) {
	            axios
	              .get('/api/gradinginspections/upcoming?page=' + page)
	            .then(response => {
	                this.inspections = response.data.data;
	                this.setPagination(response.data);
	            })
	            .catch(errors => console.log(errors));
	        }
        },
        pageChange(page) {
            this.pagination.current = page;
            this.getInspections(page);
        },
        setPagination(data) {
            this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
        },
        updateInspection() {
            axios.patch('/api/gradinginspections/' + this.inspectionForm.inspection_id, {
                'inspection_at': this.buildDateTimeString(),
                'status': this.inspectionForm.status
            }).then(response => {
                this.getInspections();
            })
            .catch(errors => console.log(errors));
        },
        datePickerInput(date) {
            var date = (date) ? date: this.inspectionForm.date;
            // YYYY-MM-DD HH:MI:SS
            this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        },
        timePickerInput() {
            if (this.inspectionForm.time) {
                var date = this.inspectionForm.time;
                this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
            }
        },
        pad(value) {
            if(value < 10) {
                return '0' + value;
            } else {
                return value;
            }
        },
        buildDateTimeString() {
            return this.inspectionForm.datetimeString = this.inspectionForm.dateString + ' ' + this.inspectionForm.timeString;
        },
        toggleEditItemMode(item) {
            this.editMode = !this.editMode;
            if (item.id != this.inspectionForm.inspection_id) {
                this.editMode = true;
            }
            if (this.editMode) {
                var date = new Date(item.inspection_at);
                this.inspectionForm.date = date;
                this.inspectionForm.time =  date;
                this.inspectionForm.type =  item.type;
                this.inspectionForm.reason =  item.reason;
                this.inspectionForm.remarks =  item.remarks;
                this.inspectionForm.status =  item.status;
                this.inspectionForm.inspection_id = item.id;
            }
        },
        isFormAttached(inspection) {
	      return (inspection.grading_form_id != null) ? 'is-success' : 'is-warning';
	    }
    }

}
</script>