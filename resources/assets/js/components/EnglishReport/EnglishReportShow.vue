<template>
	<div v-can="'api.english-reports.show'">

		<div class="columns">
	      <div class="column is-fullwidth">
	          <h1 class="title">
				INSPECTION REPORT OF FOOD ESTABLISHMENT
	          </h1>
	      </div>
	    </div>


		<div>
			<div class="columns box">
				<table class="table is-narrow">
					<tr>
						<td>Establishment Name</td>
						<td>
							<div class="field">
							  <div class="control">
									{{form.establishmentName}}
							  </div>
							</div>
						</td>
					</tr>
					<tr>
						<td>Date of Inspection</td>
						<td>
							<div class="field">
							  <div class="control">
									{{form.dateOfInspection}}
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
							{{form.scopeOfInspection}}
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
							{{form.areasInspected}}
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
					<table class="table is-narrowed is-bordered">
						<tr>
							<th>VIOLATIONS</th>
							<th>CORRECTIVE ACTION</th>
						</tr>
						<tr v-for="item,key in critical">
							<td style="width: 50%;">{{item.v}}</td>
							<td style="width: 50%;">{{item.r}}</td>
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
					<table class="table is-narrowed is-bordered">
						<tr>
							<th>VIOLATIONS</th>
							<th>CORRECTIVE ACTIONS</th>
						</tr>
						<tr v-for="item,key in major">
							<td style="width: 50%;">{{item.v}}</td>
							<td style="width: 50%;">{{item.r}}</td>
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
					<table class="table is-narrowed is-bordered">
						<tr>
							<th>OBSERVATIONS</th>
							<th>RECOMMENDED CORRECTIVE ACTIONS</th>
						</tr>
						<tr v-for="item,key in other">
							<td style="width: 50%;">{{item.v}}</td>
							<td style="width: 50%;">{{item.r}}</td>
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
							{{form.comments}}
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
										{{form.inspectionMember1Name}}
								  </div>
								</div>
							</td>
							<td>Designation</td>
							<td>
								<div class="field">
								  <div class="control">
										{{form.inspectionMember1Designation}}
								  </div>
								</div>
							</td>
							<td>Date</td>
							<td>
								<div class="field">
								  <div class="control">
										{{form.inspectionMember1Date}}
								  </div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Name</td>
							<td>
								<div class="field">
								  <div class="control">
										{{form.inspectionMember2Name}}
								  </div>
								</div>
							</td>
							<td>Designation</td>
							<td>
								<div class="field">
								  <div class="control">
										{{form.inspectionMember2Designation}}
								  </div>
								</div>
							</td>
							<td>Date</td>
							<td>
								<div class="field">
								  <div class="control">
										{{form.inspectionMember2Date}}
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
										{{form.verifiedByName}}
								  </div>
								</div>
							</td>
							<td>Designation</td>
							<td>
								<div class="field">
								  <div class="control">
										{{form.verifiedByDesignation}}
								  </div>
								</div>
							</td>
							<td>Date</td>
							<td>
								<div class="field">
								  <div class="control">
										{{form.verifiedByDate}}
								  </div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<br>
		<div class="columns no-print">
			<div class="column" style="text-align: center;"><button class="is-info button is-large" @click="launchPrint()">Print</button></div>
		</div>

	</div>
</template>

<script>
export default {
    props: ['reportId'],
    data() {
        return {
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
        },
        launchPrint() {
            window.print(); 
        }
    }
}
</script>