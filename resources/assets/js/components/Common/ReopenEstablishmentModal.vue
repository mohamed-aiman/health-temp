<template>
	<span>
		<a class="button is-orange is-small" @click="isModalActive = true" v-if="business.termination_id && can('api.businesses.reopen')">
    		<span>Reopen Establishment</span>
  	</a>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Reopen Establishment</p>
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

		          <b-field label="Remarks">
	                <b-input type="text" v-model="form.remarks"></b-input>
	            </b-field>


		      </section>
		      <footer class="modal-card-foot">
		          <button 
		          	class="button is-primary"
		          	@click="closeEstablishment()">Reopen Establishment</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['business' ,'inspection'],
		  data() {
		  	return {
					isModalActive:false,
					errorMessage: null,
					form: {
						remarks:  "",
					}
		  	}
		  },
		  methods: {
		  	closeEstablishment() {
		  		this.errorMessage = null;
          axios
          .patch('/api/businesses/' + this.business.id + '/reopen', {
          	remarks: this.form.remarks,
          	inspection_id: (this.inspection) ? this.inspection.id : null
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