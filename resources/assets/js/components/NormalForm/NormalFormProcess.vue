<template>
	<div v-can="'api.normal-forms.changedStatusToProcessed'">

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
							<a class="button is-warning" v-can="'api.normal-forms.sendBackToEditing'" v-if="normalForm.status === 'pending' && normalForm.normal_inspection.state === 'completed'" @click="sendForEditing()">އަލުން ބަދަލު ގެނައުމަށް ފޮނުވާ</a>
	  						<!-- <a class="button is-success" @click="generateReports()">ރިޕޯޓް ޖެނެރޭޓް ކުރައްވާ</a> -->
	  						<a class="button is-warning"  v-if="normalForm.normal_inspection.state === 'completed'" v-can="'api.inspections.show'" @click="goToInspection()">ގޮތް ނިންމުން</a>
							<a class="button" v-if="~['decision_made','finished'].indexOf(normalForm.normal_inspection.state)" v-can="'api.dhivehi-reports.update'" v-bind:class="[(normalForm.normal_inspection.dhivehi_report_id == null) ? isDisabled : isSuccess]" alt="dhivehi report" @click="gotToReport(normalForm.normal_inspection, 'dv')">
						        <span>ދިވެހި ރިޕޯޓް</span>
							</a>
							<a class="button" v-if="~['decision_made','finished'].indexOf(normalForm.normal_inspection.state)" v-can="'api.english-reports.update'" v-bind:class="[(normalForm.normal_inspection.english_report_id == null) ? isDisabled : isSuccess]" alt="english report" @click="gotToReport(normalForm.normal_inspection,'en')">
					        	<span>އިނގިރޭސި ރިޕޯޓް</span>
							</a>
							<a class="button is-info" @click="launchPrint()">ޕްރިންޓް</a>
							<a class="button is-warning" v-can="'api.normal-forms.changedStatusToProcessed'" v-if="normalForm.status == 'pending'" @click="processed()">އެޕްރޫވް ކުރުމަށް ފޮނުވާ</a>
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
						<tr><td colspan="6"><b>އިންސްޕެކްޓް ކުރި ބޭނުން:</b></td></tr>
						<tr>
							<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isAppliedFor.new_registration"></td>
							<td>ރަޖިސްޓްރީ ކުރުމަށް،</td>
							<td><template v-if="isAppliedFor.new_registration">{{normalForm.applied_date}}</template></td>
							<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isReason.routine"></td>
							<td>ރޫޓީން އިންސްޕެކްޝަން</td>
						</tr>
						<tr>
							<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isAppliedFor.license_renewal"></td>
							<td>ހުއްދަ އާކުރުމާ ގުޅިގެން</td>
							<td><template v-if="isAppliedFor.license_renewal">{{normalForm.applied_date}}</template></td>
							<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isReason.spot_check"></td>
							<td>ސްޕޮޓް ޗެކް</td>
						</tr>
						<tr>
							<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isAppliedFor.place_name_or_address_changed"></td>
							<td> ތަނުގެ އެޑްރެސް / މެނޭޖްމަންޓް ބަދަލުވެގެން</td>
							<td><template v-if="isAppliedFor.place_name_or_address_changed">{{normalForm.applied_date}}</template></td>
							<td><input onclick="this.checked=!this.checked;" type="checkbox" v-model="isReason.complaint"></td>
							<td>ޝަކުވާއާއި ގުޅިގެން</td>
						</tr>
					</table>


					<table class="table">
						<tr>
							<td colspan="4"><b>ތަނާއި ބެހޭ މަޢުލޫމާތު:</b></td>
						</tr>
						<tr>
							<td>ތަނުގެ ނަމާއި އެޑްރެސް</td>
							<td>{{normalForm.place_name_address}}</td>
							<td>ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
							<td>{{normalForm.registration_no}}</td>
						</tr>
						<tr>
							<td>ތަން ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
							<td>{{normalForm.place_owner_name_address}}</td>
							<td>ހުއްދަ ހަމަވާ  ތާރީޚް:</td>
							<td>{{normalForm.permit_expiry_date}}</td>
						</tr>
						<tr>
							<td>ގުޅޭނެ ނަމްބަރ:</td>
							<td>{{normalForm.phone}}</td>
							<td>
								ސާރވިންގ އޭރިޔާގެ އަދަދު: {{normalForm.serving_area_count}}
							</td>
							<td>
								ގޮނޑި ހުރި އަދަދު: {{normalForm.chair_count}}
							</td>
						</tr>
						<tr>
							<td>މަޢުލޫމާތު ދިން ފަރާތުގެ ނަމާއި ގުޅޭނެ ނަމްބަރު:</td>
							<td>{{normalForm.info_provider_name_no}}</td>
							<td>ތަނުގައި ބަދިގެ ހުރި އަދަދު:</td>
							<td>{{normalForm.kitchen_count}}</td>
						</tr>
						<tr>
							<td>އިންސްޕެކްޓް ކުރި ތާރީޚާއި ގަޑި:</td>
							<td>{{normalForm.inspected_at}}</td>
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
										<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.value"></td>
										<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.not_applicable"></td>
										<td>{{item.code}}</td>
										<td>{{item.text}}</td>
										<td style="max-width: 500px;">{{item.remarks}}</td>
									</tr>
								</template>
						</template>
					</table>
				</div>
			</div>

		<br>

		</div>
	</div>
</template>

<script>

export default {
    props: ['normalFormId'],
    data() {
        return {
			isSuccess: 'is-success',
			isDisabled: 'grey',
			isDanger: 'is-danger',
			isAppliedFor: {
				new_registration: false,
				license_renewal: false,
				place_name_or_address_changed: false
			},
			isReason: {
				'routine': false,
				'spot_check': false,
				'complaint': false
			},
	        normalForm: {
	        	normal_inspection: {}
	        },
	        categorizedFormPoints: [],
	        statusChangeStatus: null,
	        statusChangeColor: 'is-success'
	    }
    },
    mounted() {
        this.getNormalForm();
        this.getNormalFormPoints();
    },
    watch: {
    	'normalForm.applied_for': function() {
			Object.keys(this.isAppliedFor).forEach(key => {
				this.isAppliedFor[key] = this.isAppliedForCheck(key);
			});
    	},
    	'normalForm.reason': function() {
			Object.keys(this.isReason).forEach(key => {
				this.isReason[key] = this.isReasonCheck(key);
			});
    	}
    },
    methods: {
        getNormalForm() {
        	if (this.hasPermission('api.normal-forms.show')) {
	            axios
	              .get('/api/normalforms/' + this.normalFormId)
	                .then(response => {
	                    this.normalForm = response.data;
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
        isReasonCheck(reason) {
            return (this.normalForm.reason == reason) ? true : false;
        },
        isAppliedForCheck(appliedFor) {
            return (this.normalForm.applied_for == appliedFor) ? true : false;
        },
        launchPrint() {
            window.print();
        },
        sendForEditing() {
        	if (this.hasPermission('api.normal-forms.sendBackToEditing')) {
	            axios
	            .patch("/api/normalforms/" + this.normalFormId  + "/status/draft")
	            .then(response => {
	                this.statusChangeColor = 'is-success';
	                this.statusChangeStatus = 'status changed successfully.'
	            })
	            .catch(error => {
	                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
	                this.statusChangeColor = 'is-danger';
	            });
			}
        },
        processed() {
        	if (this.hasPermission('api.normal-forms.changedStatusToProcessed')) {
	        	if (!confirm('Is checklist filled? Did you take actions? Are the reports ready? Are you sure you want to send this for approval? ')) 
	                return;

	            axios
	            .patch("/api/normalforms/" + this.normalFormId  + "/status/processed")
	            .then(response => {
	                this.statusChangeColor = 'is-success';
	                this.statusChangeStatus = 'status changed successfully.'
	                this.getNormalForm();
	            })
	            .catch(error => {
	                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
	                this.statusChangeColor = 'is-danger';
	            });
	        }
        },
        goToForm() {
        	if (this.hasPermission('api.normal-forms.show')) {
	            this.$router.push({ name: 'normalforms.show', params: { normalFormId: this.normalFormId } })
	        }
        },
    //     generateReports() {
    //     	axios
    //         .post("/api/normalforms/" + this.normalFormId  + "/reports/generate")
    //         .then(response => {
    //             this.statusChangeColor = 'is-success';
    //             this.statusChangeStatus = 'reports generated successfully.'
				// this.normalForm = response.data;
    //         })
    //         .catch(error => {
    //             this.statusChangeStatus = 'error generating reports: ' + error.response.data.message;
    //             this.statusChangeColor = 'is-danger';
    //         });
    //     },
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
		// goToInspectionFinish() {
  //       	if (this.hasPermission('api.inspections.close')) {
	 //            this.$router.push({ name: 'inspections.finish', params: { inspectionId: this.normalForm.normal_inspection_id } })
  //           }
		// },
		goToInspection() {
        	if (this.hasPermission('api.inspections.show')) {
	            this.$router.push({ name: 'inspections.show', params: { inspectionId: this.normalForm.normal_inspection_id } })
            }
		}
    }
}

</script>


<style scoped>
	table td:not([align]), table th:not([align]) {
	text-align: right;
	}
</style>