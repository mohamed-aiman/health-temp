<template>
	<span>
		<reopen-establishment :business="business" :inspection="inspection" @refresh="refreshPage"></reopen-establishment>
		<a class="button is-danger is-small" @click="isModalActive = true" v-if="business.termination_id == null  && can('api.businesses.terminate')">
      <b-icon type="is-dark" size="is-small" pack="fas" icon="close"></b-icon>
      <span class="is-danger">Terminate</span>
    </a>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Close Establishment</p>
		      </header>
		      <section class="modal-card-body">
		      		<b-notification
		      				v-if="errorMessage"
			            type="is-danger"
			            role="alert">
			            {{errorMessage}}
			        </b-notification>

		          <b-field label="Establishment">
	                <b-input
	                	:value="business.name + ' (' + business.registration_no + ')'"
	                    type="text"
	                    readonly>
	                </b-input>
	            </b-field>

		          <b-field label="Inspection Id" v-if="inspection">
	                <b-input
	                		:value="inspection.id"
	                    type="text"
	                    readonly>
	                </b-input>
	            </b-field>

		          <b-field label="Closed On">
		              <datetime type="date" class="input" v-model="form.terminated_on" format="yyyy-MM-dd"></datetime>
		          </b-field>

		          <b-field label="Closed Reason">
                <div class="select">
                  <select v-model="form.reason">
										<option value="Poor Hygiene standards">Poor Hygiene standards</option>
										<option value="Pest issue">Pest issue</option>
										<option value="License Expired">License Expired</option>
										<option value="3 follow up done and still major issues are present">3 follow up done and still major issues are present</option>
										<option value="Requested by Owner">Requested by Owner</option>
										<option value="Other violation under Food establishment hygiene standard Regulation">Other violation under Food establishment hygiene standard Regulation</option>
										<option value="Other">Other</option>
                  </select>
                </div>
              </b-field>

		          <b-field label="Remarks">
	                <b-input type="text" v-model="form.remarks"></b-input>
	            </b-field>


		      </section>
		      <footer class="modal-card-foot">
		          <button 
		          	class="button is-primary"
		          	@click="closeEstablishment()">Close Establishment</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
	import ReopenEstablishmentModal from './ReopenEstablishmentModal';

    export default {
		  props: ['business' ,'inspection'],
		  components: {
		  	'reopen-establishment' : ReopenEstablishmentModal
		  },
		  data() {
		  	return {
					isModalActive:false,
					errorMessage: null,
					form: {
						terminated_on: "",
						reason:  "",
						remarks:  "",
					}
		  	}
		  },
		  methods: {
		  	refreshPage() {
      		this.$emit('refresh')
		  	},
		  	closeEstablishment() {
		  		this.errorMessage = null;
          axios
          .post('/api/businesses/' + this.business.id + '/terminate', {
          	terminated_on: moment(this.form.terminated_on).format("Y-MM-DD HH:mm:ss"),
          	reason: this.form.reason,
          	remarks: this.form.remarks,
          	inspection_id: (this.inspection) ? this.inspection.id : null
          })
          .then(response => {
          		this.refreshPage();
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