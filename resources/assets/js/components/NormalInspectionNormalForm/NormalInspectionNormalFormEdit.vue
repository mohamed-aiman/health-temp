<template>
<div v-can="'api.normal-forms.update'">

	<div class="columns no-print" v-if="statusChangeStatus">
		<div class="column">
			<div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
		</div>
	</div>

	<div class="columns no-print">
		<div class="column dhivehi">
			<table class="table">
				<tr>
					<td class="right">
						<a v-if="normalForm.status == 'draft' && can('api.normal-forms.sendForProcessing')" class="is-warning button" @click="sendForProcessing()">ޗެކްލިސްޓް ފުރާ ނިމުނީ</a>
  						<router-link v-if="normalForm.normal_inspection_id != null && can('api.normal-inspections.normalforms.show')" class="button is-info" :to="{ name: 'normal-inspections.normalforms.show', params: { inspectionId: inspectionId }}">
							ވިއު ކުރުމަށް
						</router-link>
			    	</td>
		  		</tr>
			</table>
		</div>
	</div>

	<div class="columns">
      <div class="column is-fullwidth dhivehi">
          <h1 class="title">
            ކާބޯތަކެތީގެ ޚިދުމަތްދޭތަންތަން ބަލާ ފާސްކުރާ ފޯމް
          </h1>
      </div>
    </div>

	<div>
		<div class="columns">
			<div class="column dhivehi">
				<table class="table">
					<tr><td colspan="4">‫<b>އިންސްޕެކްޓް ކުރި ބޭނުން:</b></td></tr>
					<tr>
						<td class="fit">
							<div class="select">
								<select v-model="normalForm.applied_for">
									<option value="new_registration">ރަޖިސްޓްރީ ކުރުމަށް،</option>
									<option value="license_renewal">ހުއްދަ އާކުރުމާ ގުޅިގެން</option>
									<option value="place_name_or_address_changed"> ތަނުގެ އެޑްރެސް / މެނޭޖްމަންޓް ބަދަލުވެގެން</option>
								</select>
							</div>
						</td>
						<td class="fit">ހުށަހެޅި  ތާރީޚް:</td>
						<td><input type="text" class="input" v-model="normalForm.applied_date"></td>
						<td>
							<div class="select">
								<select v-model="normalForm.reason">
									<option value="routine">ރޫޓީން އިންސްޕެކްޝަން </option>
									<option value="spot_check">ސްޕޮޓް ޗެކް</option>
									<option value="complaint">ޝަކުވާއާއި ގުޅިގެން</option>
								</select>
							</div>
						</td>
					</tr>
				</table>
				<table class="table">
					<tr>
						<td colspan="4"><b>ތަނާއި ބެހޭ މަޢުލޫމާތު:</b></td>
					</tr>
					<tr>
						<td>ތަނުގެ ނަމާއި އެޑްރެސް</td>
						<td><input type="text" class="input" v-model="normalForm.place_name_address"></td>
						<td>ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
						<td><input type="text" class="input" v-model="normalForm.registration_no"></td>
					</tr>
					<tr>
						<td>ތަން ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
						<td><input type="text" class="input" v-model="normalForm.place_owner_name_address"></td>
						<td>ހުއްދަ ހަމަވާ  ތާރީޚް:</td>
						<td><input type="text" class="input" v-model="normalForm.permit_expiry_date"></td>
					</tr>
					<tr>
						<td>ގުޅޭނެ ނަމްބަރ:</td>
						<td><input type="text" class="input" v-model="normalForm.phone"></td>
						<td>
							<div class="columns">
								<div class="column">ސާރވިންގ އޭރިޔާގެ އަދަދު:</div>
							</div>
						</td>
						<td>
							<div class="columns">
								<div class="column"><input type="number" class="input" v-model="normalForm.serving_area_count"></div>
								<div class="column">ގޮނޑި ހުރި އަދަދު:</div>
								<div class="column"><input type="number" class="input" v-model="normalForm.chair_count"></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>މަޢުލޫމާތު ދިން ފަރާތުގެ ނަމާއި ގުޅޭނެ ނަމްބަރު:</td>
						<td><input type="text" class="input" v-model="normalForm.info_provider_name_no"></td>
						<td>ތަނުގައި ބަދިގެ ހުރި އަދަދު:</td>
						<td><input type="number" class="input" v-model="normalForm.kitchen_count"></td>
					</tr>
					<tr>
						<td>އިންސްޕެކްޓް ކުރި ތާރީޚާއި ގަޑި:</td>
						<td><input type="text" class="input" v-model="normalForm.inspected_at"></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns">
			<div class="column dhivehi">
				<table class="table">
					<tr>
						<td><b>ކޯޑް:</b></td>
						<td>މައިނަރ [MN]</td>
						<td>މޭޖަރ [MJ]</td>
						<td>ކްރިޓިކަލް [CR]</td>
						<td><b>ބަލަން ނުޖެހޭ: </b>[NA]</td>
					</tr>
				</table>
			</div>
		</div>

		<hr>
		<div class="columns dhivehi">
			<div class="column" style="text-align: center;">
				<div class="box">
				ތިރާގައިވާ ޗެކް ބޮކްސްތަކުގައި ފާހަގަ ޖެހުމުން އޮޓޯއިން އެ މިންގަނޑެއް އަދާހަމަ ކުރެވޭނެއެވެ.
				</div>
			</div>
		</div>
		
		<div class="columns">
			<div class="column dhivehi">
				<table class="table">
							<tr>
								<td><b>#</b></td>
								<td><b>ފުރިހަމަވެފައި</b></td>
								<td><b>(NA) ބަލަން ނުޖެހޭ</b></td>
								<td><b>ކޯޑް</b></td>
								<td><b>މިންގަނޑު</b></td>
								<td><b>އިތުރު ބަޔާން</b></td>
							</tr>
					<template v-for="category in categorizedFormPoints">
							<tr>
								<td colspan="6"><b>{{category[0].category}}</b></td>
							</tr>
							<template v-for="item in category">
								<tr  v-bind:style="{ backgroundColor: rowColor(item) }">
									<td>{{item.no}}</td>
									<td><input type="checkbox" v-model="item.value" @change="changedValue(item)"></td>
									<td><input type="checkbox" v-model="item.not_applicable" @change="changedNotApplicable(item)"></td>
									<td>{{item.code}}</td>
									<td>{{item.text}}</td>
									<td style="max-width: 500px;">
										<span class="is-dark no-print" @click="openRemarksForm(item)">
								            <b-icon v-if="!item.remarks" icon="comment" size="is-small"></b-icon>
								            <b-icon v-if="item.remarks" icon="pencil" size="is-small"></b-icon>
								        </span>
										<span v-if="item.remarks">{{item.remarks}}</span>
									</td>
								</tr>
							</template>
					</template>
				</table>
			</div>
		</div>

		<div class="columns no-print" v-if="statusChangeStatus">
			<div class="column">
			  <div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column"></div>
			<div class="column" style="text-align: center;">
				<a class="is-warning button" @click="savePlaceInfoReason()">ތަނާއި ބެހޭ މައުލޫމާތު އަދި ސަބަބު އަދާހަމަ ކުރޭ</a>
				<a class="is-info button" @click="goToShow()">ވިއު ކުރުމަށް</a>
			</div>
			<div class="column"></div>
		</div>

		<b-modal :active.sync="isRemarksModalActive" has-modal-card>
			<div class="columns modal-card">
				<response-messages :response.sync="remarksResponse"></response-messages>
				<div class="column box">
					<div class="columns">
						<div class="column left">
						  <div class="label is-normal">
						    <label class="label">Add/Edit Remarks</label>
						  </div>
						</div>
						<div class="column">
							<div class="field is-pulled-right">
							  <div class="control">
							    <button class="button is-link" @click="saveRemarks">Save</button>
							  </div>
							</div>
						</div>
					</div>
					<div class="columns">
						<div class="column">
							<div class="field">
							  <label class="label">Comment</label>
								<div class="control">
									<textarea rows="10" placeholder="remarks" class="textarea dhivehi" v-model="remarksForm.remarks"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</b-modal>


		
	</div>

</div>
</template>

<script>

export default {
    props: ['inspectionId'],
    data() {
        return {
        	normalFormId: null,
        	normalForm: {},
	        categorizedFormPoints: [],
	        statusChangeStatus: null,
	        statusChangeColor: 'is-success',
	        remarksEditingId: null,
	        remarksForm: {
	            remarks: ''
	        },
	        remarksResponse: {},
	        isRemarksModalActive: false
	    }
    },
    mounted() {
        this.getNormalForm();
        // this.getNormalFormPoints();
    },
    watch: {
    	normalFormId: function() {
    		this.getNormalFormPoints();
    	}
    },
    methods: {
        getNormalForm() {
        	if (this.hasPermission('api.normal-inspections.normalforms.show')) {
            	axios
            	.get('/api/normalinspections/'+this.inspectionId+'/normalforms')
                .then(response => {
                    this.normalForm = response.data;
                	this.normalFormId = this.normalForm.id;
                })
                .catch(errors => console.log(errors));
	       	}
        },
        getNormalFormPoints() {
        	if (this.hasPermission('api.normal-forms.points')) {
	            axios
	            .get('/api/normalforms/' + this.normalFormId + '/points')
	                .then(response => {
	                    this.categorizedFormPoints = response.data;
	                })
	                .catch(errors => console.log(errors));
            }
        },
        rowColor(point) {
            switch(point.code) {
              case 'CR':
                    return '#f29696';
                break;
              case 'MJ':
                    return '#f2c196';
                break;
              case 'MN':
                    return '#95f1ca';
                break;
              default:
                    return '#95d0f0';
            }
        },
        changedValue(point) {
          axios
          .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + point.id + '/value/changed', {
              value: point.value
          })
          .then(response => {
              point = response.data;
          })
          .catch(errors => alert('unable to mark or unmark(value)!'));
        },
        changedNotApplicable(point) {
          axios
          .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + point.id + '/notapplicable/changed', {
              not_applicable: point.not_applicable
          })
          .then(response => {
              point = response.data;
          })
          .catch(errors => alert('unable to mark or unmark(not_applicable)!'));
        },
        updatePointRemarks(point, remarks) {
          axios
          .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + point.id + '/remarks/changed', {
              remarks: point.remarks
          })
          .then(response => {
              point = response.data;
          })
          .catch(errors => alert('unable to change remarks!'));
        },
        savePlaceInfoReason(markAsCompleted = false) {
          axios
          .patch('/api/normalforms/' + this.normalFormId, this.normalForm)
          .then(response => {
              this.normalForm = response.data;
            this.statusChangeColor = 'is-success';
            this.statusChangeStatus = 'updated successfully.'
						if (markAsCompleted) {
							this.changeFormToPendingStatus();
						}
          })
          .catch(error => {
              if (error.response.status == 422) {
              	var displayMessage = '';
              	for (let [field, messages] of Object.entries(error.response.data.errors)) {
                  	displayMessage += messages + '\n';
                  }
                this.statusChangeStatus = displayMessage;
              } else {
                this.statusChangeStatus = 'unable to save: ' + error.response.data.message;
              }
              this.statusChangeColor = 'is-danger';
          });
        },
        changeFormToPendingStatus() {
          axios
          .patch('/api/normalforms/' + this.normalFormId + '/status/pending')
          .then(response => {
              this.normalForm = response.data;
              this.statusChangeColor = 'is-success';
              this.statusChangeStatus = 'status changed successfully.'
              if (this.hasPermission('api.inspections.show')) {
                this.goToInspection();
              } else {
                this.goToShow();
              }
          })
          .catch(error => {
              this.statusChangeStatus = 'Error changing status: '  + error.response.data.message;
              this.statusChangeColor = 'is-danger';
          });
        },
	    	goToInspection() {
	        this.$router.push({ name: 'inspections.show', params: { inspectionId: this.normalForm.normal_inspection_id } })
        },
        goToShow() {
        	if (this.hasPermission('api.normal-inspections.normalforms.show')) {
            if (this.normalForm.normal_inspection_id != null) {
                this.$router.push({ name: 'normal-inspections.normalforms.show', params: { inspectionId: this.normalForm.normal_inspection_id } })
            }
          }
        },
        sendForProcessing() {
      		if (!confirm('Check if the form is filled. Are you sure you want to send this form for processing? this action cannot be undone.')) return;
      		this.savePlaceInfoReason(true);
        },
        openRemarksForm(item) {
            this.remarksResponse = {};
            this.remarksEditingId = item.id;
            this.remarksForm = item;
            this.isRemarksModalActive = true;
        },
        saveRemarks() {
          axios
          .patch('/api/normalforms/' + this.normalFormId + '/formpoints/' + this.remarksEditingId + '/remarks/changed', this.remarksForm)
          .then(response => {
              this.remarksResponse = response; 
              setTimeout(function() {
                  this.remarksResponse = {};
                  this.$emit('update:remarksResponse', {});
                  this.isRemarksModalActive = false;
              }.bind(this), 1000);
          })
          .catch(errors => {
              this.remarksResponse = errors.response;
          });
        }
    }
}
</script>


<style scoped>
	table td:not([align]), table th:not([align]) {
	text-align: right;
	}
</style>