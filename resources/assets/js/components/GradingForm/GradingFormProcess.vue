<template>
	<div v-can="'api.grading-forms.changedStatusToProcessed'">

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
							<a class="button is-warning" v-can="'api.grading-forms.sendBackToEditing'" @click="sendForEditing()">އަލުން ބަދަލު ގެނައުމަށް ފޮނުވާ</a>
	  						<!-- <a class="button is-success" @click="generateReports()">ރިޕޯޓް ޖެނެރޭޓް ކުރައްވާ</a> -->
	  						<a class="button is-warning" v-can="'api.grading-inspections.close'" @click="goToInspectionFinish()">ގޮތް ނިންމުން</a>
							<a class="button is-info" @click="launchPrint()">ޕްރިންޓް</a>
							<a class="button is-warning" v-can="'api.grading-forms.changedStatusToProcessed'" v-if="gradingForm.status == 'pending'" @click="processed()">އެޕްރޫވް ކުރުމަށް ފޮނުވާ</a>
				    	</td>
			  		</tr>
				</table>
			</div>
		</div>

		<div>
			<div class="columns">
		      <div class="column is-fullwidth dhivehi">
		          <h1 class="title">
		            ކާބޯތަކެތީގެ ޚިދުމަތްދޭތަންތަން ބަލާ ފާސްކުރާ ފޯމް
		          </h1>
		      </div>
		    </div>
			<div class="columns">
				<div class="column dhivehi">
					<table class="table">
						<tr><td colspan="4"><b>ތަނާއި ބެހޭ މަޢުލޫމާތު:</b></td></tr>
						<tr>
							<td>ތަނުގެ ނަން</td>
							<td>{{gradingForm.place_name}}</td>
							<td>ކާބޯތަކެތީގެ ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
							<td>{{gradingForm.food_registration_no}}</td>
						</tr>
						<tr>
							<td>ތަން ހިންގާ ފަރާތް:</td>
							<td>{{gradingForm.owner}}</td>
							<td>ހުއްދައިގެ މުއްދަތު</td>
							<td>{{gradingForm.permit_limit}}</td>
						</tr>
						<tr>
							<td>ގުޅޭނެ ނަމްބަރ:</td>
							<td>{{gradingForm.phone}}</td>
							<td>ތާރީޚް:</td>
							<td>{{gradingForm.inspection_date}}</td>
						</tr>
						<tr>
							<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
							<td colspan="4">{{gradingForm.information_provider}}</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="columns">
				<div class="column dhivehi">
					<table class="table">
						<tr><td colspan="8"><b>ބަލާ ފާސް ކުރާ ސަބަބު:</b></td></tr>
						<tr>
							<td>ގްރޭޑް ކުރުމާއި ގުޅިގެން</td>
							<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.grading"></td>
							<td>ހުއްދަ އާކުރުމާ ގުޅިގެން</td>
							<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.license_renewal"></td>
							<td>ޝަކުވާއާއި ގުޅިގެން</td>
							<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.complaint"></td>
							<td>ކޮމްޕްލިއެންސީ އޯޑިޓް</td>
							<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.compliance_audit"></td>
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
									<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.value"></td>
									<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.not_applicable"></td>
									<td>{{item.code}}</td>
									<td>{{item.text}}</td>
								</tr>
								</template>
						</template>
					</table>
				</div>
			</div>
			<div class="columns dhivehi no-print">
				<div class="column" style="text-align: center;"><button class="is-info button is-large" @click="launchPrint()">ޕްރިންޓް</button></div>
			</div>
		</div>
	</div>
</template>

<script>

export default {
    props: ['gradingFormId'],
    data() {
        return {
			isSuccess: 'is-success',
			isDisabled: 'grey',
			isDanger: 'is-danger',
        	reasons: {
				'grading': false,
				'license_renewal': false,
				'complaint': false,
				'compliance_audit': false
        	},
	        gradingForm: {
	        	grading_inspection: {}
	        },
	        categorizedFormPoints: [],
	        statusChangeStatus: null,
	        statusChangeColor: 'is-success'
	    }
    },
    mounted() {
        this.getGradingForm();
        this.getGradingFormPoints();
    },
    watch: {
	    "gradingForm.reason": function() {
	      Object.keys(this.reasons).forEach(key => {
	        this.reasons[key] = this.isReason(key);
	      });
	    }
    },
    methods: {
        getGradingForm() {
        	if (this.hasPermission('api.grading-forms.show')) {
	            axios
	              .get('/api/gradingforms/' + this.gradingFormId)
	                .then(response => {
	                    this.gradingForm = response.data;
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
        isReason(reason) {
            return (this.gradingForm.reason == reason) ? true : false;
        },
        launchPrint() {
            window.print();
        },
        sendForEditing() {
        	if (this.hasPermission('api.grading-forms.sendBackToEditing')) {
	            axios
	            .patch("/api/gradingforms/" + this.gradingFormId  + "/status/draft")
	            .then(response => {
	                this.statusChangeColor = 'is-success';
	                this.statusChangeStatus = 'status changed successfully.'
	                this.goToForm();
	            })
	            .catch(error => {
	                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
	                this.statusChangeColor = 'is-danger';
	            });
			}
        },
        processed() {
        	if (this.hasPermission('api.grading-forms.changedStatusToProcessed')) {
	        	if (!confirm('Is checklist filled? Did you take actions? Are the reports ready? Are you sure you want to send this for approval? ')) 
	                return;

	            axios
	            .patch("/api/gradingforms/" + this.gradingFormId  + "/status/processed")
	            .then(response => {
	                this.statusChangeColor = 'is-success';
	                this.statusChangeStatus = 'status changed successfully.'
	                this.getGradingForm();
	            })
	            .catch(error => {
	                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
	                this.statusChangeColor = 'is-danger';
	            });
	        }
        },
        goToForm() {
        	if (this.hasPermission('api.grading-forms.show')) {
	            this.$router.push({ name: 'gradingforms.show', params: { gradingFormId: this.gradingFormId } })
	        }
        },
		gotToReport(item, lang) {
  			switch(lang) {
			    case "dv":
		        	if (this.hasPermission('api.english-reports.update')) {
			            this.$router.push({ name: 'inspections.dhivehi-reports.edit', params: { inspectionId: item.id } })
                    }
			        break;
			    case "en":
		        	if (this.hasPermission('api.english-reports.update')) {
			            this.$router.push({ name: 'inspections.english-reports.edit', params: { inspectionId: item.id } })
                    }
			        break;
			    default:
			}
		},
		goToInspectionFinish() {
        	if (this.hasPermission('api.grading-inspections.close')) {
	            this.$router.push({ name: 'grading-inspections.finish', params: { inspectionId: this.gradingForm.grading_inspection_id } })
            }
		}
    }
}

</script>