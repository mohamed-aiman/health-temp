<template>
<div v-can="'api.grading-forms.update'">
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
						<a v-can="'api.grading-forms.sendForProcessing'" class="is-warning button" @click="sendForProcessing()">ޗެކްލިސްޓް ފުރާ ނިމުނީ</a>
  						<router-link v-can="'api.grading-inspections.gradingforms.show'" v-if="gradingForm.grading_inspection_id != null" class="button is-info" :to="{ name: 'grading-inspections.gradingforms.show', params: { inspectionId: inspectionId }}">
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
					<tr><td colspan="4">ތަނާއި ބެހޭ މަޢުލޫމާތު:</td></tr>
					<tr>
						<td>ތަނުގެ ނަން</td>
						<td><input type="text" class="input" v-model="gradingForm.place_name"></td>
						<td>ކާބޯތަކެތީގެ ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
						<td><input type="text" class="input" v-model="gradingForm.food_registration_no"></td>
					</tr>
					<tr>
						<td>ތަން ހިންގާ ފަރާތް:</td>
						<td><input type="text" class="input" v-model="gradingForm.owner"></td>
						<td>ހުއްދައިގެ މުއްދަތު</td>
						<td><input type="text" class="input" v-model="gradingForm.permit_limit"></td>
					</tr>
					<tr>
						<td>ގުޅޭނެ ނަމްބަރ:</td>
						<td><input type="text" class="input" v-model="gradingForm.phone"></td>
						<td>ތާރީޚް:</td>
						<td><input type="text" class="input" v-model="gradingForm.inspection_date"></td>
					</tr>
					<tr>
						<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
						<td colspan="4"><input type="text" class="input" v-model="gradingForm.information_provider"></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns">
			<div class="column dhivehi">
				<table class="table">
					<tr><td colspan="8">ބަލާ ފާސް ކުރާ ސަބަބު:</td></tr>
					<tr>
						<td colspan="8">
							<div class="select">
								<select v-model="gradingForm.reason">
									<option value="grading">ގްރޭޑް ކުރުމާއި ގުޅިގެން</option>
									<option value="license_renewal">ހުއްދަ އާކުރުމާ ގުޅިގެން</option>
									<option value="complaint">ޝަކުވާއާއި ގުޅިގެން</option>
									<option value="compliance_audit">ކޮމްޕްލިއެންސީ އޯޑިޓް</option>
								</select>
							</div>
						</td>
					</tr>
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
							</tr>
					<template v-for="category in categorizedFormPoints">
							<tr>
								<td colspan="5"><b>{{category[0].category}}</b></td>
							</tr>
							<template v-for="item in category" >
							<tr  v-bind:style="{ backgroundColor: rowColor(item) }">
								<td>{{item.no}}</td>
								<td><input type="checkbox" v-model="item.value" @change="changedValue(item)"></td>
								<td><input type="checkbox" v-model="item.not_applicable" @change="changedNotApplicable(item)"></td>
								<td>{{item.code}}</td>
								<td>{{item.text}}</td>
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

	</div>
</div>
</template>

<script>
export default {
	props: ['inspectionId'],
	data() {
        return {
	        statusChangeStatus: null,
	        statusChangeColor: 'is-success',
        	gradingFormId: null,
        	gradingForm: {},
	        categorizedFormPoints: []
	    }
    },
    mounted() {
        this.getGradingForm();
    },
    watch: {
    	gradingFormId: function() {
    		this.getGradingFormPoints();
    	}
    },
    methods: {
        getGradingForm() {
        	if (this.hasPermission('api.grading-inspections.gradingforms.show')) {
	            axios
	              // .get('/api/gradingforms/' + this.gradingFormId)
	              .get('/api/gradinginspections/' + this.inspectionId + '/gradingforms')
	                .then(response => {
	                    this.gradingForm = response.data;
	                	this.gradingFormId = this.gradingForm.id;
	                })
	                .catch(errors => console.log(errors));
	       	}
        },
        getGradingFormPoints() {
        	if (this.hasPermission('api.grading-forms.points')) {
            axios
              .get('/api/gradingforms/' + this.gradingFormId + '/points')
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
        	if (this.hasPermission('api.grading-forms.form-points.valueChanged')) {
            axios
              .patch('/api/gradingforms/' + this.gradingFormId + '/formpoints/' + point.id + '/value/changed', {
                  value: point.value
              })
                .then(response => {
                    point = response.data;
                })
                .catch(errors => alert('unable to mark or unmark(value)!'));
            }
        },
        changedNotApplicable(point) {
        	if (this.hasPermission('api.grading-forms.form-points.notApplicableChanged')) {
            axios
              .patch('/api/gradingforms/' + this.gradingFormId + '/formpoints/' + point.id + '/notapplicable/changed', {
                  not_applicable: point.not_applicable
              })
                .then(response => {
                    point = response.data;
                })
                .catch(errors => alert('unable to mark or unmark(not_applicable)!'));
            }
        },
        savePlaceInfoReason() {
        	if (this.hasPermission('api.grading-forms.update')) {
            axios
              .patch('/api/gradingforms/' + this.gradingFormId, this.gradingForm)
                .then(response => {
                    this.gradingForm = response.data;
                })
                .catch(error => {
                    this.statusChangeStatus = 'unable to save: ' + error.response.data.message;
                    this.statusChangeColor = 'is-danger';
                });
            }
        },
        goToShow() {
        	if (this.hasPermission('api.grading-inspections.gradingforms.show')) {
	            if (this.gradingForm.grading_inspection_id != null) {
	                this.$router.push({ name: 'grading-inspections.gradingforms.show', params: { inspectionId: this.gradingForm.grading_inspection_id } })
	            }
            }
        },
        sendForProcessing() {
        	if (this.hasPermission('api.grading-forms.sendForProcessing')) {
        		if (!confirm('Check if the form is filled. Are you sure you want to send this form for processing? this action cannot be undone.')) return;
	            axios
	            .patch('/api/gradingforms/' + this.gradingFormId + '/status/pending')
	            .then(response => {
	                this.gradingForm = response.data;
	                this.statusChangeColor = 'is-success';
	                this.statusChangeStatus = 'updated successfully'
	                // this.goToShow();
	            })
	            .catch(error => {
	                this.statusChangeStatus = 'Error changing status: '  + error.response.data.message;
	                this.statusChangeColor = 'is-danger';
	            });
            }
        }
    }
}
</script>