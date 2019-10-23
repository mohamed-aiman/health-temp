<template>
	<span>
		<button class="button is-primary is-small" @click="isModalActive = true" v-if="can('api.businesses.fees.store')">New Fee</button>

		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Apply New Fee</p>
		      </header>
		      <section class="modal-card-body">
		      		<b-notification
		      			v-if="errorMessage"
			            type="is-danger"
			            role="alert">
			            {{errorMessage}}
			        </b-notification>

		          <b-field label="Establishment">
	                <b-input size="is-small" :value="business.name + ' (' + business.registration_no + ')'" type="text"></b-input>
	            </b-field>


              <b-field label="Fee Slip"></b-field>
              <b-field class="file">
                <template>
                    <b-field class="file">
                        <b-upload  v-model="form.file">
                            <a class="button is-primary is-small">
                                <b-icon icon="upload"></b-icon>
                            </a>
                        </b-upload>
                        <span class="file-name is-small" v-if="form.file" style="color:grey;border: none;">
                            {{ form.file.name }}
                        </span>
                    </b-field>    
                </template>
              </b-field>

		          <b-field label="Fee Type" v-if="feeTypes.length>0">
                <div class="select dhivehi is-small">
                    <select v-model="form.fee_type_id">
                        <option v-for="option in feeTypes" v-bind:value="option.id">
                        {{ option.description }}
                        </option>
                    </select>
                </div>
              </b-field>

		          <b-field label="Amount(MVR)">
	                <b-input size="is-small" v-model="form.amount" type="number"></b-input>
	            </b-field>

		          <b-field label="Applied On">
		              <datetime type="date" class="input is-small" v-model="form.applied_on" format="yyyy-MM-dd"></datetime>
		          </b-field>

		          <b-field label="Fee Slip Number">
	                <b-input size="is-small" type="text" v-model="form.fee_slip_no"></b-input>
	            </b-field>

		          <b-field label="Remarks">
	                <b-input size="is-small" type="text" v-model="form.remarks"></b-input>
	            </b-field>


		      </section>
		      <footer class="modal-card-foot">
		          <button 
		          	v-if="form.file && form.amount && form.applied_on && form.fee_type_id && form.fee_slip_no"
		          	class="button is-primary"
		          	@click="save()">Save</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: {
		  	'business': {
		  		default: {}
		  	}
		  },
		  mounted() {
        this.getFeeTypes();
		  },
		  data() {
		  	return {
					isModalActive:false,
					errorMessage: null,
					feeTypes: [],
					form: {
            amount: null,
            applied_on: "",
            fee_slip_no: "",
            remarks: "",
            fee_type_id: null,
            file: null,
					}
		  	}
		  },
      watch: {
        'form.fee_type_id': function() {
            this.autoFillUsingFeeType()
        }
      },
		  methods: {
        getFeeTypes() {
          if (this.hasPermission('api.fee-types.index')) {
              axios
              .get('/api/fee-types?business_id=' + this.business.id)
              .then(response => {
                  this.feeTypes = response.data;
              })
              .catch(errors => console.log(errors));
          }
        },
		  	refreshPage() {
      		this.$emit('refresh')
		  	},
        autoFillUsingFeeType() {
            let selectedFeeType = this.feeTypes.find(function(feeType) {
                return feeType.id == this.form.fee_type_id;
            }, this)

            this.form.amount = selectedFeeType.amount;
        },
        save() {
            const fd = new FormData();
            fd.set('amount', this.form.amount);
            fd.set('applied_on', this.form.applied_on);
            fd.set('fee_slip_no', this.form.fee_slip_no);
            fd.set('remarks', this.form.remarks);
            fd.set('fee_type_id', this.form.fee_type_id);
            fd.append('image', this.form.file, this.form.file.name);
            this.makeRequest('/api/businesses/' + this.business.id + '/fees', fd);
        },
        makeRequest(uri, fd) {
  					axios
						.post(uri, fd)
						.then(response => {
	          		this.refreshPage();
	          		this.isModalActive = false;
						}, error => {
							if (errors.response.status == 422) {
	          		if ("message" in errors.response.data.errors) {
	          			this.errorMessage = errors.response.data.errors.message[0]
	          		}
	          	} else {
								this.errorMessage = 'Error saving fee file';
	          	}
						});
        }
			}
    }
</script>