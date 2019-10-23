<template>
	<span v-if="~['created', 'scheduled'].includes(inspection.state) && can('api.inspections.update')">
	<!-- <span> -->
		<a class="button is-small is-dark" @click="isModalActive = true">
			<b-icon type="is-warning" size="is-small" pack="fas" icon="edit"></b-icon>
      <span>Edit</span>
		</a>
		<b-modal :active.sync="isModalActive" has-modal-card trap-focus>
		  <div class="modal-card" style="width: auto">
		      <header class="modal-card-head">
		          <p class="modal-card-title">Edit Inspection</p>
		      </header>
		      <section class="modal-card-body">
	      		<b-notification
	      				v-if="errorMessage"
		            type="is-danger"
		            role="alert">
		            {{errorMessage}}
		        </b-notification>

	            <b-field label="Assignee" v-if="inspectors.length>0">
		            <div class="select">
                        <select v-model="form.inspector_id">
                          <option value="unassigned">Unassigned</option>
                          <option v-for="option in inspectors" v-bind:value="option.id">
                          {{ option.name }}({{ option.id }})
                          </option>
                        </select>
                      </div>
                </b-field>

	            <b-field label="State">
		            <div class="select">
                        <select v-model="form.state">
                          <option value="created">Created</option>
                          <option value="scheduled">Scheduled</option>
                        </select>
                      </div>
                </b-field>

              <b-field label="Time">
                <datetime type="datetime" class="input" v-model="form.inspection_at" format="yyyy-MM-dd HH:mm"></datetime>
              </b-field>

	        <b-field label="Remarks">
                <b-input v-model="form.remarks" type="text" ></b-input>
            </b-field>

		      </section>
		      <footer class="modal-card-foot">
		          <button class="button is-primary"@click="updateInspection()">Update</button>
		      </footer>
		  </div>
    </b-modal>
	</span>
					
</template>

<script>
    export default {
		  props: ['inspection'],
		  watch: {
		  	'inspection.remarks': function() {
		  		this.form.remarks = this.inspection.remarks
		  	},
		  	'inspection.inspection_at': function() {
		  		let parsedDate = moment(this.inspection.inspection_at, 'YYYY-MM-DD H:mm:ss')
		  		this.form.inspection_at = parsedDate.toISOString();
		  	},
		  	'inspection.inspector_id': function() {
		  		this.form.inspector_id = (this.inspection.inspector_id) ? this.inspection.inspector_id : 'unassigned';
		  	},
		  	'inspection.state': function() {
		  		this.form.state = this.inspection.state;
		  	}
		  },
		  data() {
		  	return {
					isModalActive:false,
					errorMessage: null,
					inspectors: [],
					form: {
						// reason: "",
						remarks:  "",
						inspection_at: "",
						inspector_id: 'unassigned',
						state: ""
					}
		  	}
		  },
		  mounted() {
		  	this.getInspectors();
		  },
		  methods: {
	  	    getInspectors() {
		      if (this.hasPermission('api.inspectors.index')) {
		        axios
		        .get('/api/inspectors')
		        .then(response => {
		          this.inspectors = response.data
		        })
		        .catch(errors => console.log(errors));
		      }
		    },
		  	updateInspection() {
		  		this.errorMessage = null;
	        axios.patch('/api/inspections/' + this.inspection.id, {
	          'inspector_id': this.form.inspector_id,
	          'inspection_at': moment(this.form.inspection_at).format("Y-MM-DD HH:mm:ss"),
	          // 'reason': this.form.reason,
	          'remarks': this.form.remarks,
	          'state': this.form.state
	        }).then(response => {
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