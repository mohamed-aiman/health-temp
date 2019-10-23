<template>
<div v-can="'api.english-reports.show'">

	<div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
			INSPECTION REPORT OF FOOD ESTABLISHMENT
          </h1>
      </div>
    </div>

	<div class="container">
		<div class="columns box">
			<table class="table is-narrow">
				<tr>
					<td>Establishment Name</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.establishmentName">
						  </div>
						</div>
					</td>
				</tr>
				<tr>
					<td>Date of Inspection</td>
					<td>
						<div class="field">
						  <div class="control">
								<input class="input" type="text" v-model="form.dateOfInspection">
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
						<th>#</th>
						<th>VIOLATIONS</th>
						<th>CORRECTIVE ACTION</th>
						<th>action</th>
					</tr>
					<tr>
						<td>1</td>
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
						<td>
						  <p class="buttons">
							  <a class="button is-success"  @click="saveItem('criticalFactors')">
							    <span class="icon is-small">
							      <i class="fa fa-plus"></i>
							    </span>
							  </a>
							  <a class="button is-warning" @click="cancel('criticalFactors')">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
						  </p>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td>sdf</td>
						<td>dsf</td>
						<td>
							<p class="buttons">
							  <a class="button is-warning" @click="editItem('criticalFactors',item, key)">
							    <span class="icon is-small">
							      <i class="fa fa-edit"></i>
							    </span>
							  </a>
							  <a class="button is-danger" @click="removeItem('criticalFactors', item)">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
							</p>
						</td>
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
						<th>#</th>
						<th>VIOLATIONS</th>
						<th>CORRECTIVE ACTIONS</th>
						<th>action</th>
					</tr>
					<tr>
						<td>1</td>
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
						<td>
						  <p class="buttons">
							  <a class="button is-success"  @click="saveItem('majorFactors')">
							    <span class="icon is-small">
							      <i class="fa fa-plus"></i>
							    </span>
							  </a>
							  <a class="button is-warning" @click="cancel('majorFactors')">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
						  </p>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td>sdf</td>
						<td>dsf</td>
						<td>
							<p class="buttons">
							  <a class="button is-warning" @click="editItem('majorFactors',item, key)">
							    <span class="icon is-small">
							      <i class="fa fa-edit"></i>
							    </span>
							  </a>
							  <a class="button is-danger" @click="removeItem('majorFactors', item)">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
							</p>
						</td>
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
						<th>#</th>
						<th>OBSERVATIONS</th>
						<th>RECOMMENDED CORRECTIVE ACTIONS</th>
						<th>action</th>
					</tr>
					<tr>
						<td>1</td>
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
						<td>
						  <p class="buttons">
							  <a class="button is-success"  @click="saveItem('otherObservations')">
							    <span class="icon is-small">
							      <i class="fa fa-plus"></i>
							    </span>
							  </a>
							  <a class="button is-warning" @click="cancel('otherObservations')">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
						  </p>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td>sdf</td>
						<td>dsf</td>
						<td>
							<p class="buttons">
							  <a class="button is-warning" @click="editItem('otherObservations',item, key)">
							    <span class="icon is-small">
							      <i class="fa fa-edit"></i>
							    </span>
							  </a>
							  <a class="button is-danger" @click="removeItem('otherObservations', item)">
							    <span class="icon is-small">
							      <i class="fa fa-times"></i>
							    </span>
							  </a>
							</p>
						</td>
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
						<td>
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
						<td>
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


		<div class="columns">
			<div class="column">
				<div class="field is-grouped">
				  <div class="control">
				    <button class="button is-link" @click="onSubmit()">Submit</button>
				  </div>
				  <div class="control">
				    <button class="button is-text">Cancel</button>
				  </div>
				</div>
			</div>
		</div>
	</div>

</div>
</template>

<script>

export default {
    data() {
        return {
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
	            verifiedByDate: ""
	        })
	    }
    },
    mounted() {
    },
    methods: {
        onSubmit() {
            this.form.post('/applications')
                .then(data => {
					this.$router.push({ name: 'applications.show', params: { applicationId: data.id } })
                })
                .catch(errors => console.log(errors));
        },
        saveItem(type) {
          switch(type) {
                case "criticalFactors":
                    break;
                case "majorFactors":
                    break;
                case "otherObservations":
                    break;
                default:
                    this.form._1toRegisterPlace = true
          }
        },
        removeItem(type, item, key) {

        },
        editItem(type, item) {

        }
    }
}

</script>

