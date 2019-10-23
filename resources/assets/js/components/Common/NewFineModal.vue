<template>
	<span>
		<a class="button is-orange is-small" @click="isModalActive = true" v-if="can('api.businesses.fines.store') || can('api.inspections.fines.store')">
      <b-icon type="is-dark" size="is-small" pack="fas" icon="close"></b-icon>
      <span class="is-orange tag">New Fine</span>
    </a>

		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Add New Fine</p>
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

		          <b-field label="Inspection Id" v-if="inspection">
	                <b-input size="is-small" :value="inspection.id" type="text"></b-input>
	            </b-field>

              <b-field label="Upload File"></b-field>
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

		          <b-field label="Fine Type">
                <div class="select dhivehi is-small">
                    <select v-model="form.fine_type_id">
                        <option v-for="option in fineTypes" v-bind:value="option.id">
                        {{ option.description }}
                        </option>
                    </select>
                </div>
              </b-field>

		          <b-field label="Amount(MVR)">
	                <b-input size="is-small" v-model="form.amount" type="number"></b-input>
	            </b-field>

		          <b-field label="Fined On">
		              <datetime type="date" class="input is-small" v-model="form.fined_on" format="yyyy-MM-dd"></datetime>
		          </b-field>


		          <b-field label="Fine Slip Number">
	                <b-input size="is-small" type="text" v-model="form.fine_slip_no"></b-input>
	            </b-field>

		          <b-field label="Remarks">
	                <b-input size="is-small" type="text" v-model="form.remarks"></b-input>
	            </b-field>


		      </section>
		      <footer class="modal-card-foot">
		          <button 
		          	class="button is-primary"
		          	@click="save()">Save</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>

    export default {
		  props: ['business' ,'inspection'],
		  mounted() {
        this.getFineTypes();
		  },
		  data() {
		  	return {
					isModalActive:false,
					errorMessage: null,
					fineTypes: [],
					form: {
            amount: null,
            fined_on: "",
            fine_slip_no: null,
            remarks: null,
            fine_type_id: null,
            file: null,
					}
		  	}
		  },
      watch: {
        'form.fine_type_id': function() {
            this.autoFillUsingFineType()
        }
      },
		  methods: {
        getFineTypes() {
          if (this.hasPermission('api.fine-types.index')) {
              axios
              .get('/api/fine-types')
              .then(response => {
                  this.fineTypes = response.data;
              })
              .catch(errors => console.log(errors));
          }
        },
		  	refreshPage() {
      		this.$emit('refresh')
		  	},
        autoFillUsingFineType() {
            let selectedFineType = this.fineTypes.find(function(fineType) {
                return fineType.id == this.form.fine_type_id;
            }, this)

            this.form.amount = selectedFineType.amount;
        },
        save() {
            const fd = new FormData();
            fd.set('amount', this.form.amount);
            fd.set('fined_on', this.form.fined_on);
            fd.set('fine_slip_no', this.form.fine_slip_no);
            fd.set('remarks', this.form.remarks);
            fd.set('fine_type_id', this.form.fine_type_id);
            fd.append('image', this.form.file, this.form.file.name);
            if (this.inspection && this.inspection.id) {
	          if (this.hasPermission('api.inspections.fines.store')) {
	            this.makeRequest('/api/inspections/' + this.inspection.id + '/fines', fd);
		      }
            } else {
	          if (this.hasPermission('api.businesses.fines.store')) {
	            this.makeRequest('/api/businesses/' + this.business.id + '/fines', fd);
		      }
            }
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
								this.errorMessage = 'Error saving fine file';
	          	}
						});
        }
			}
    }
</script>