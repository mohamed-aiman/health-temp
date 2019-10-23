<template>
	<span>
		<a class="button is-dark is-small" @click="isModalActive = true">
      <b-icon type="is-success" size="is-small" pack="fas" icon="check"></b-icon>
      <span>Issue License</span>
    </a>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Issue License</p>
		      </header>
		      <section class="modal-card-body">
		      		<b-notification
		      			v-if="errorMessage"
			            type="is-danger"
			            role="alert">
			            {{errorMessage}}
			        </b-notification>

		          <b-field label="Establishment Name">
	                <b-input :value="business.name" type="text" readonly></b-input>
	            </b-field>

							<!-- address -->

		          <b-field label="Registration No">
	                <b-input v-if="!business.identification_code" type="text" v-model="form.registration_no"></b-input>
	                <b-input v-if="business.identification_code" :value="business.identification_code" type="text" readonly></b-input>
	            </b-field>

							<!-- category -->

							<!-- owner -->

					    <b-field label="License Type">
                <div class="select">
                  <select v-model="form.license_type">
										<option value="food_new_registration">New Food Permit</option>
										<option value="food_renewal">Renew Food Permit</option>
										<option value="tobacco">Tobacco</option>
                  </select>
                </div>
              </b-field>

		          <b-field label="License No">
	                <b-input type="text" v-model="form.license_no"></b-input>
	            </b-field>

			       	<b-field label="Issued Date">
		              <datetime type="date" class="input" v-model="form.issued_date" format="yyyy-MM-dd"></datetime>
		          </b-field>

		          <b-field label="Expiry Date">
		              <datetime type="date" class="input" v-model="form.expiry_date" format="yyyy-MM-dd"></datetime>
		          </b-field>

		          <b-field label="Fee (yearly)">
	                <b-input type="text" v-model="form.amount"></b-input>
	            </b-field>


		      </section>
		      <footer class="modal-card-foot">
		          <button 
		          	class="button is-primary"
		          	@click="issueLicense()">Save</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['inspection'],
		  watch: {
		  	'form.issued_date': function() {
		  		this.form.expiry_date = moment(this.form.issued_date).add(1, 'year').toISOString();
		  	}
		  },
		  data() {
		  	return {
		  		business: {},
					isModalActive:false,
					errorMessage: null,
					form: {
						registration_no:  "",
						license_type: null,
						license_no: null,
						expiry_date: "",
						issued_date: "",
						amount: null,
					}
		  	}
		  },
		  mounted() {
		  	this.getAutofillValues();
		  	this.setBusiness();
		  },
		  methods: {
		  	getAutofillValues() {
		  		axios.post('/api/businesses/' + this.inspection.business_id + '/license/autofill', {
		  			inspection_id: this.inspection.id,
		  			application_id: this.inspection.application_id
		  		}).then(response => {
		  			this.form.registration_no = response.data.registration_no;
		  			this.form.license_type = response.data.license_type;
		  			this.form.license_no = response.data.license_no;
		  			this.form.amount = response.data.amount;
		  			this.form.category = response.data.category;
		  		}).catch(errors => console.log(errors));
		  	},
		  	setBusiness() {
		  		if (!this.inspection.business) {
		  			axios.get('/api/businesses/' + this.inspection.business_id)
		  			.then(response => {
		  				this.business = response.data;
		  			}).catch(errors => {
		  				console.log(errors);
		  			})
		  		} else {
		  			this.business = this.inspection.business;
		  		}
		  	},
		  	refreshPage() {
      		this.$emit('refresh')
		  	},
		  	issueLicense() {
		  		this.errorMessage = null;
          axios
          .post('/api/applications/'+this.inspection.application_id+'/licenses', {
          	registration_no: this.form.registration_no,
          	license_type: this.form.license_type,
          	license_no: this.form.license_no,
          	issued_date: moment(this.form.issued_date).format("Y-MM-DD HH:mm:ss"),
          	expiry_date: moment(this.form.expiry_date).format("Y-MM-DD HH:mm:ss"),
          	amount: this.form.amount,
          	inspection_id: this.inspection.id
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