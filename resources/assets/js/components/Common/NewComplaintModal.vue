<template>
	<span v-can="'api.businesses.complaints.store'">
		<button class="button is-primary is-small" @click="isModalActive = true">New Complaint</button>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Add New Complaint</p>
		      </header>
		      <section class="modal-card-body">
		      		<b-notification
		      				v-if="errorMessage"
			            type="is-danger"
			            role="alert">
			            {{errorMessage}}
			        </b-notification>

		          <b-field label="Time">
		              <datetime type="datetime" class="input" v-model="form.complaint_at" format="yyyy-MM-dd HH:mm:ss"></datetime>
		          </b-field>

		          <b-field label="Reference">
			          	<b-input v-model="form.reference"></b-input>
	            </b-field>

		          <b-field class="dhivehi right" label="ޚުލާސާ">
			          	<b-input type="textarea" class="dhivehi" placeholder="ޙުލާސާ ތާނައިން" v-model="form.summary"></b-input>
	            </b-field>

		      </section>
		      <footer class="modal-card-foot">
		          <button 
		          	class="button is-primary"
		          	v-if="form.complaint_at && form.summary"
		          	@click="saveComplaint()">Save Complaint</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['businessId'],
		  data() {
		  	return {
					isModalActive:false,
					errorMessage: null,
					form: {
						'complaint_at': "",
						'reference': "",
						'summary': "",
					}
		  	}
		  },
		  methods: {
		  	saveComplaint() {
		  		this.errorMessage = null;
				  axios
					.post('/api/businesses/' + this.businessId + '/complaints', {
						'complaint_at': moment(this.form.complaint_at).format("Y-MM-DD HH:mm:ss"),
						'reference':this.form.reference,
						'summary':this.form.summary,
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