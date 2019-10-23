<template>
<div v-can="'api.english-reports.show'">
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
                        <a class="button is-warning" v-can="'api.english-reports.changedStatusToProcessed'" @click="processed()">ޕްރޮސެސް ކޮށް ނިމުނީ</a>
                        <a class="button is-warning" v-can="'api.english-reports.sendBackToEditing'" @click="sendForEditing()">އަލުން ބަދަލު ގެނައުމަށް ފޮނުވާ</a>
	    			    <a class="button is-info" @click="launchPrint()">ޕްރިންޓް</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

	<div>
		<div class="columns">
	      <div class="column is-fullwidth">
	          <h1 class="title">
				INSPECTION REPORT OF FOOD ESTABLISHMENT
	          </h1>
	      </div>
	    </div>
		<div class="columns box">
			<table class="table is-narrow">
				<tr>
					<td>Establishment Name</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" disabled v-model="form.establishmentName">
						  </div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Date of Inspection</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" disabled v-model="form.dateOfInspection">
						  </div>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<br>
		<div class="columns box">
			<div class="column">
				<div class="field">
				  <label class="label">SCOPE OF INSPECTION:</label>
				  <div class="control">
						<textarea class="textarea" v-model="form.scopeOfInspection"></textarea>
				  </div>
				</div>
			</div>
		</div>
		<br>
		<div class="columns box">
			<div class="column">
				<div class="field">
				  <label class="label">AREAS INSPECTED:</label>
				  <div class="control">
						<textarea class="textarea" v-model="form.areasInspected"></textarea>
				  </div>
				</div>
			</div>
		</div>


		<div class="columns">
			<div class="column">
				<label class="label">1. CRITICAL FACTORS / VIOLATIONS that require immediate corrective action</label>
			</div>
		</div>

		<div class="columns box">
			<div class="column">
				<table class="table is-narrowed">
					<tr>
						<th>VIOLATIONS</th>
						<th>CORRECTIVE ACTION</th>
						<th>action</th>
					</tr>
					<tr>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.criticalViolation">
							  </div>
							</div>
						</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.criticalCorrectiveAction">
							  </div>
							</div>
						</td>
					</tr>
					<tr v-for="item,key in critical">
						<td>{{item.v}}</td>
						<td>{{item.r}}</td>
					</tr>
				</table>
			</div>
		</div>


		<div class="columns">
			<div class="column">
				<label class="label">2. MAJOR FACTORS / VIOLATIONS that require corrective actions in a given time</label>
			</div>
		</div>

		<div class="columns box">
			<div class="column">
				<table class="table is-narrowed">
					<tr>
						<th>VIOLATIONS</th>
						<th>CORRECTIVE ACTIONS</th>
						<th>action</th>
					</tr>
					<tr>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.majorViolation">
							  </div>
							</div>
						</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.majorCorrectiveAction">
							  </div>
							</div>
						</td>
					</tr>
					<tr v-for="item,key in major">
						<td>{{item.v}}</td>
						<td>{{item.r}}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<label class="label">3. OTHER OBSERVATIONS (Requires corrective actions)</label>
			</div>
		</div>

		<div class="columns box">
			<div class="column">
				<table class="table is-narrowed">
					<tr>
						<th>OBSERVATIONS</th>
						<th>RECOMMENDED CORRECTIVE ACTIONS</th>
						<th>action</th>
					</tr>
					<tr>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.otherObservationsViolation">
							  </div>
							</div>
						</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.otherObservationsCorrectiveAction">
							  </div>
							</div>
						</td>
					</tr>
					<tr v-for="item,key in other">
						<td>{{item.v}}</td>
						<td>{{item.r}}</td>
					</tr>
				</table>
			</div>
		</div>
		<br>
		<div class="columns box">
			<div class="column">
				<div class="field">
				  <label class="label">Comments:</label>
				  <div class="control">
						<textarea class="textarea" v-model="form.comments"></textarea>
				  </div>
				</div>
			</div>
		</div>
		<br>

		<div class="columns box">
			<div class="column">
				<table class="table">
					<tr>
						<td colspan="6">
						  <label class="label">Inspection team:</label>
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.inspectionMember1Name">
							  </div>
							</div>
						</td>
						<td>Designation</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.inspectionMember1Designation">
							  </div>
							</div>
						</td>
						<td>Date</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.inspectionMember1Date">
							  </div>
							</div>
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.inspectionMember2Name">
							  </div>
							</div>
						</td>
						<td>Designation</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.inspectionMember2Designation">
							  </div>
							</div>
						</td>
						<td>Date</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.inspectionMember2Date">
							  </div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	  	<br>

		<div class="columns box">
			<div class="column">
				<table class="table">
					<tr>
						<td colspan="6">
						  <label class="label">Report verified by:</label>
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.verifiedByName">
							  </div>
							</div>
						</td>
						<td>Designation</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.verifiedByDesignation">
							  </div>
							</div>
						</td>
						<td>Date</td>
						<td>
							<div class="field">
							  <div class="control">
									<input class="input" type="text" v-model="form.verifiedByDate">
							  </div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

</div>
</template>

<script>
export default {
    props: ['reportId'],
    data() {
        return {
        	statusChangeStatus: null,
	        statusChangeColor: 'is-success',
	        report: {},
	        critical: [],
	        major: [],
	        other: [],
	        pageLoaded: false,
	        form: new Form({
	            establishmentName: "",
	            dateOfInspection: "",
	            scopeOfInspection: "",
	            areasInspected: "",
	            criticalViolation: "",
	            criticalCorrectiveAction: "",
	            majorViolation: "",
	            majorCorrectiveAction: "",
	            otherObservationsViolation: "",
	            otherObservationsCorrectiveAction: "",
	            comments: "",
	            inspectionMember1Name: "",
	            inspectionMember1Designation: "",
	            inspectionMember1Date: "",
	            inspectionMember2Name: "",
	            inspectionMember2Designation: "",
	            inspectionMember2Date: "",
	            verifiedByName: "",
	            verifiedByDesignation: "",
	            verifiedByDate: "",
	        })
	    }
    },
    mounted() {
        this.getReport();
    },
    methods: {
        launchPrint() {
            window.print();
        },
        sendForEditing() {
        	if (this.hasPermission('api.english-reports.sendBackToEditing')) {
	            axios
	            .patch("/api/english/reports/" + this.reportId  + "/status/draft")
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
        	if (this.hasPermission('api.english-reports.changedStatusToProcessed')) {
	            axios
	            .patch("/api/english/reports/" + this.reportId  + "/status/processed")
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
        getReport() {
        	if (this.hasPermission('api.english-reports.show')) {
	            axios
	              .get('/api/english/reports/' + this.reportId)
	            .then(response => {
	                this.setFromModel(response.data);
	            })
	            .catch(errors => console.log(errors));
	       	}
        },
        setFromModel(data) {
            this.report = data;
            this.inspection = data.inspection;
            this.business = this.inspection.business;

            this.critical = (data.critical) ? JSON.parse(data.critical) : [];
            this.major = (data.major) ? JSON.parse(data.major) : [];
            this.other = (data.observations) ? JSON.parse(data.observations) : [];
            this.form.establishmentName = this.business.name;
            this.form.dateOfInspection = this.inspection.inspection_at;
            this.form.scopeOfInspection = data.scope;
            this.form.areasInspected = data.areas;
            this.form.criticalViolation = '';//data.criticalViolation;
            this.form.criticalCorrectiveAction = '';//data.criticalCorrectiveAction;
            this.form.majorViolation = '';//data.majorViolation;
            this.form.majorCorrectiveAction = '';//data.majorCorrectiveAction;
            this.form.otherObservationsViolation = '';//data.otherObservationsViolation;
            this.form.otherObservationsCorrectiveAction = '';//data.otherObservationsCorrectiveAction;
            this.form.comments = data.comments;
            this.form.inspectionMember1Name = data.inspectionMember1Name;
            this.form.inspectionMember1Designation = data.inspectionMember1Designation;
            this.form.inspectionMember1Date = data.inspectionMember1Date;
            this.form.inspectionMember2Name = data.inspectionMember2Name;
            this.form.inspectionMember2Designation = data.inspectionMember2Designation;
            this.form.inspectionMember2Date = data.inspectionMember2Date;
            this.form.verifiedByName = data.verifiedByName;
            this.form.verifiedByDesignation = data.verifiedByDesignation;
            this.form.verifiedByDate = data.verifiedByDate;

            this.pageLoaded = true;
        }
    }
}

</script>