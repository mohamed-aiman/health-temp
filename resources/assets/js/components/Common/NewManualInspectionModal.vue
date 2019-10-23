<template>
	<span v-can="'api.businesses.inspections.store'">
		<button class="button is-primary is-small" @click="isModalActive = true">Schedule a new Inspection</button>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Schedule an Inspection</p>
		      </header>
		      <section class="modal-card-body">
		      		<b-notification
		      				v-if="errorMessage"
			            type="is-danger"
			            role="alert">
			            {{errorMessage}}
			        </b-notification>

		          <b-field label="Time">
		              <datetime type="datetime" class="input" v-model="form.inspection_at" format="yyyy-MM-dd HH:mm:ss"></datetime>
		          </b-field>

							<b-field label="Reason">
							  <b-select v-model="form.reason" placeholder="Select a reason" rounded>
											<option value="Complaint" selected>Complaint</option>
											<!-- <option value="routine">Routine</option> -->
											<option value="Spot check">Spot check</option>
											<!-- <option value="unspecified">Unspecified </option> -->
							  </b-select>
							</b-field>

							<b-field label="Complaint" v-if="form.reason == 'Complaint'">
							  <b-select v-model="form.complaint_id" placeholder="Select a reason" rounded>
									<option v-for="complaint in complaints" v-bind:value="complaint.id">
									    {{ complaint.id }} - {{ complaint.reference }}
									 </option>
							  </b-select>
							</b-field>

		          <b-field label="Remarks">
			          	<b-input v-model="form.remarks"></b-input>
	            </b-field>

		      </section>
		      <footer class="modal-card-foot">
		          <button 
		          	class="button is-primary"
		          	v-if="form.inspection_at && form.reason"
		          	@click="saveInspection()">Schedule Inspection</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['businessId', 'complaints'],
		  data() {
		  	return {
					isModalActive:false,
					errorMessage: null,
					form: {
						'inspection_at': "",
						'complaint_id': "",
						'reason': "",
						'remarks': "",
					}
		  	}
		  },
		  methods: {
		  	saveInspection() {
		  		this.errorMessage = null;
				  axios
					.post('/api/businesses/' + this.businessId + '/inspections', {
						'inspection_at': moment(this.form.inspection_at).format("Y-MM-DD HH:mm:ss"),
						'complaint_id': this.form.complaint_id,
						'reason':this.form.reason,
						'remarks':this.form.remarks,
					})
					.then(response => {
          		this.$emit('refresh')
          		this.isModalActive = false;
					})
					.catch(errors => {
          	if (errors.response.status == 422) {
          		if ("message" in errors.response.data.errors) {
          			this.errorMessage = errors.response.data.errors.message[0]
          		}
          	}
					});
		  	}
			}
    }
</script>