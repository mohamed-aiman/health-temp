<template>
	<span v-can="'api.licenses.pay'">
		<a class="button is-small is-info" @click="isLicensePayModalActive = true">Pay</a>
		<b-modal :active.sync="isLicensePayModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Pay Registration/Renew Fee</p>
		      </header>
		      <section class="modal-card-body">
		      		<b-notification
		      				v-if="errorMessage"
			            type="is-danger"
			            role="alert">
			            {{errorMessage}}
			        </b-notification>

		          <b-field label="Amount(MVR)">
	                <b-input
	                		:value="license.amount"
	                    type="text"
	                    readonly>
	                </b-input>
	            </b-field>

		          <b-field label="Upload Receipt">
		          </b-field>
		          <b-field class="file">
			      			<template v-if="!license.is_paid">
									    <b-field class="file" v-can="'uploads.licenses.receipt'">
									        <b-upload  v-model="file" v-if="uploadStatus!=='uploading'">
									            <a class="button is-primary is-small">
									                <b-icon icon="upload"></b-icon>
									            </a>
									        </b-upload>
									        <span class="file-name is-small" v-if="file" style="color:grey;border: none;">
									            {{ file.name }}
									        </span>
									    </b-field>    
									</template>
									<template v-if="license.receipt_path != null && can('licenses.receipt.show')">
										<a class="button is-success is-small" target="_blank" :href="'/licenses/'+license.id +'/receipt'"><b-icon icon="eye"></b-icon></a>
									</template>
		          </b-field>

		          <b-field label="Receipt No.">
	                <b-input
	                    type="text"
	                    v-model="form.receipt_no"
	                    required>
	                </b-input>
	            </b-field>

		          <b-field label="Paid On">
		              <datetime type="datetime" class="input" v-model="form.paid_on" format="yyyy-MM-dd HH:mm:ss"></datetime>
		          </b-field>

		      </section>
		      <footer class="modal-card-foot">
		          <button 
			          class="button is-primary" 
		          	v-if="license.receipt_path && form.receipt_no && form.paid_on"
			          @click="markAsPaid()"
		          >
			        Mark as Paid
				      </button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['license'],
		  watch: {
		  	file: function() {
		  		this.uploadLicensePaymentReceipt()
		  	}
		  },
		  data() {
		  	return {
					isLicensePayModalActive:false,
					file: null,
					uploadStatus: null,
					errorMessage: null,
					form: {
						paid_on: "",
						receipt_no:  ""
					}
		  	}
		  },
		  methods: {
		  	markAsPaid() {
          axios
          .patch('/api/licenses/'+this.license.id+'/pay', {
          	paid_on: moment(this.form.paid_on).format("Y-MM-DD HH:mm:ss"),
          	receipt_no: this.form.receipt_no
          })
          .then(response => {
          		this.$emit('refresh')
          		this.isLicensePayModalActive = false;
          })
          .catch(errors => {
          	if (errors.response.status == 422) {
          		if ("message" in errors.response.data.errors) {
          			this.errorMessage = errors.response.data.errors.message[0]
          		}
          	}
          });
		  	},
				uploadLicensePaymentReceipt() {
		  		this.errorMessage = null;
					this.uploadStatus = 'uploading';
					const fd = new FormData();
					fd.append('image', this.file, this.file.name);

					axios
					.post('/uploads/licenses/'+this.license.id+'/receipt', fd)
					.then(response => {
						this.license.receipt_path = response.data.receipt_path;
						this.uploadStatus = null;
					}, error => {
						alert('Error uploading file: ' + error.response.data.message);
						this.uploadStatus = null;
					});
				}
		  }
    }
</script>