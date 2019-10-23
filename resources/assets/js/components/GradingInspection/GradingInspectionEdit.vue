<template>
	<div v-can="'grading-inspections.edit'">
		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        Grading Inspection
		        <!-- 'GradingInspection of ' . $inspection->business->name . ' (id:' . $inspection->id . ')' -->
		      </h1>
			</div>
		</div>
		<div class="container">
			<br>
				<div class="columns" v-if="editMode">
					<div class="column box">
						<div class="columns">
							<div class="column">
							  <div class="label is-normal">
							    <label class="label">Updating Inspection id: {{inspectionForm2.inspection_id}}</label>
							  </div>
							</div>
						</div>
						<div class="columns">
							<div class="column">
								<div class="field">
								  <label class="label">Status</label>
									<div class="select">
									  <select v-model="inspectionForm2.status">
									    <option value="scheduled">Scheduled</option>
									    <option value="finished">Finished</option>
									    <option value="cancelled">Cancelled</option>
									  </select>
									</div>
								</div>
							</div>
							<div class="column">
								<div class="field">
									<template>
									    <b-field label="Select a date">
									        <b-datepicker
									            placeholder="Click to select..."
									            icon="calendar-today"
				                      			@input="datePickerInput2"
									            v-model="inspectionForm2.date">
									        </b-datepicker>
									    </b-field>
									</template>
								</div>
							</div>
							<div class="column">
								<div class="field">
								  <template>
									    <b-field label="Select timepicker">
									        <b-timepicker
									            placeholder="Type or select a date..."
									            icon="clock"
									            editable
				                      			@input="timePickerInput2"
									            v-model="inspectionForm2.time">
									        </b-timepicker>
									    </b-field>
									</template>
								</div>
							</div>
							<div class="column" v-if="inspectionForm2.type">
								<div class="field">
								  <label class="label">Type</label>
									<div class="select">
									  <select disabled v-model="inspectionForm2.type">
									    <option value="1">New Registration</option>
									    <option value="2">License Renewal</option>
									  </select>
									</div>
								</div>
							</div>
							<div class="column" v-if="!inspectionForm2.type">
								<div class="field">
								  <label class="label">Type</label>
									<div class="select">
										<select v-model="inspectionForm2.reason">
											<option value="complaint" selected>Complaint</option>
											<option value="routine">Routine</option>
											<option value="unspecified">Unspecified </option>
										</select>
									</div>
								</div>
							</div>
							<div class="column">
								<div class="field">
								  <label class="label">Remarks</label>
									<div class="input control">
										<input type="text" placeholder="remarks" class="input" v-model="inspectionForm2.remarks">
									</div>
								</div>
							</div>
							<div class="column">
								<div class="field">
								  <label class="label">&nbsp</label>
								  <div class="control">
								    <button class="button is-link" @click="updateInspection">Update Inspection</button>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/>

				<div class="columns" v-if="inspection">
					<div class="column box">
						<div class="columns">
							<div class="column">
							  <label class="label">Inspection Detail</label>
							</div>
						</div>
						<div class="columns">
							<div class="column">
							  <label class="label">Remarks: {{inspection.remarks}}</label>
							</div>
						</div>
						<div class="columns">
							<table class="table">
								<thead>
									<tr>
										<th>Id</th>
										<th>Status</th>
										<th>Type</th>
										<th>Inspection At</th>
										<th>Follow Up</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{inspection.id}}</td>
										<td>{{inspection.status}}</td>
										<td>{{inspection.reason}}</td>
										<td>{{inspection.inspection_at}}</td>
										<td>
											<router-link v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: inspection.follow_up_id }}">
												{{inspection.follow_up_id}}
											</router-link>
										</td>
										<td>
											<div class="tags">
												<div class="tag is-warning" v-if="inspection.is_followup_required">followup required</div>
												<div class="tag is-danger" v-if="inspection.is_fined">fined</div>
											</div>
										</td>
										<td>
						                  	<p class="buttons">
												  <a class="button" v-bind:class="[(inspection.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="goToReport(inspection, 'dv')">
												    <span class="icon is-small">
												      <i class="fa fa-book"></i>
												    </span>
										        <span>Dv</span>
												  </a>
												  <a class="button" v-bind:class="[(inspection.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="goToReport(inspection,'en')">
												    <span class="icon is-small">
												      <i class="fa fa-book"></i>
												    </span>
										        <span>En</span>
												  </a>
											  <a class="button is-warning" alt="dhivehi report" @click="toggleEditItemMode(inspection)">
											    <span class="icon is-small">
											      <i class="fa fa-edit"></i>
											    </span>
											  </a>
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br>
				
				<div class="columns" v-if="inspection.follow_up_inspection">
					<div class="column box">
						<div class="columns">
								<div class="column">
								  <label class="label">Followup Inspection</label>
								</div>
						</div>
						<div class="columns">
							<table class="table">
								<thead>
									<tr>
										<th>Id</th>
										<th>Status</th>
										<th>Inspection At</th>
										<th>Follow Up</th>
										<th></th>
										<th>Report</th>
										<th>Edit</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{item.id}}</td>
										<td>{{item.status}}</td>
										<td>{{item.inspection_at}}</td>
										<td>
											<router-link v-can="'api.inspections.show'" :to="{ name: 'inspections.show', params: { inspectionId: item.follow_up_id }}">
												{{item.follow_up_id}}
											</router-link>
										</td>
										<td>
											<div class="tags">
												<div class="tag is-warning" v-if="item.is_followup_required">followup required</div>
												<div class="tag is-danger" v-if="item.is_fined">fined</div>
											</div>
										</td>
										<td>
						                  	<p class="buttons">
												  <a class="button" v-bind:class="[(item.dhivehi_report_id == null) ? isWarning : isSuccess]" alt="dhivehi report" @click="goToReport(item, 'dv')">
												    <span class="icon is-small">
												      <i class="fa fa-book"></i>
												    </span>
										        <span>Dv</span>
												  </a>
												  <a class="button" v-bind:class="[(item.english_report_id == null) ? isWarning : isSuccess]" alt="english report" @click="goToReport(item,'en')">
												    <span class="icon is-small">
												      <i class="fa fa-book"></i>
												    </span>
										        <span>En</span>
												  </a>
											</p>
										</td>
										<td>
											<p class="buttons">
											  <a class="button is-warning" alt="dhivehi report" @click="toggleEditItemMode(item)">
											    <span class="icon is-small">
											      <i class="fa fa-edit"></i>
											    </span>
											  </a>
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br/>
				<div class="columns">
					<div class="column box">
						<div class="columns">
							<div class="column">
							  <div class="label is-normal">
							    <label class="label">Tools</label>
							  </div>
							</div>
						</div>
						<div class="columns">
							<div class="column">
						        <div class="field">
						            <b-switch 
						            v-model="isFollowUpRequired"
						            @input="changedisFollowUpRequired"
						            type="is-warning">
						                Followup is required
						            </b-switch>
						        </div>
							</div>
							<div class="column">
						        <div class="field">
						            <b-switch 
						            v-model="isFined"
						            @input="changedisFined"
						            type="is-danger">
						                Fined
						            </b-switch>
						        </div>
							</div>
						</div>
						<div class="columns" v-if="isFined">
							<div class="column">
							  <div class="label is-normal">
							    <label class="label">Fine Details</label>
							  </div>
							</div>
						</div>
						<div class="columns" v-if="isFined">
			        		<div class="column">
								<div class="field">
				        			Amount: <input type="number" name="amount" v-model="fineForm.amount" class="input">
						        </div>
			        		</div>
			        		<div class="column">
								<div class="field">
			        				Fined On: 
							        <b-datepicker
							            placeholder="Click to select..."
							            icon="calendar-today"
							            editable
							            v-model="fineForm.fined_on">
							        </b-datepicker>
								</div> 
			        		</div>
			        		<div class="column" v-if="!fineForm.is_paid">
			        			<br/>
								<div class="field">
						            <b-switch 
						            v-model="payEnabled"
						            type="is-danger">
						                Enable Pay
						            </b-switch>
						        </div>
			        		</div>
			        		<div class="column" v-if="fineForm.is_paid || payEnabled">
								<div class="field">
			        				Paid On: 
							        <b-datepicker
							            placeholder="Click to select..."
							            icon="calendar-today"
							            editable
							            v-model="fineForm.paid_on">
							        </b-datepicker>
								</div>
			        		</div>
			        		<div class="column" v-if="fineForm.is_paid || payEnabled">
								<div class="field">
			        				Receipt No: <input type="text" name="receipt_no" v-model="fineForm.receipt_no" class="input">
								</div>
			        		</div>
			        		<div class="column">
			        			<br>
			        			<p class="buttons">
								  <a class="button is-success"  @click="saveFine()">
								    <span class="icon is-small">
								      <i class="fa fa-save"></i>
								    </span>
								  </a>
								  <a class="button is-warning" @click="deleteFine()">
								    <span class="icon is-small">
								      <i class="fa fa-times"></i>
								    </span>
								  </a>
								</p>
			        		</div>
						</div>
					</div>
				</div>
				<div class="columns">
					<div class="column box">
						<div class="columns">
			        		<div class="column">
			        			<br/>
								<div class="field">
						            <b-switch 
						            v-model="enableHandover"
						            type="is-success">
						                Reports handed over
						            </b-switch>
						        </div>
			        		</div>
						</div>
						<div class="columns" v-if="enableHandover">
							<div class="column">
								Handed over Date and Time
							</div>
							<div class="column">
								<div class="field">
							        <b-datepicker
							            placeholder="Click to select..."
							            icon="calendar-today"
		                      			@input="datePickerInput"
		                      			editable
							            v-model="inspectionForm.date">
							        </b-datepicker>
								</div>
							</div>
							<div class="column">
								<div class="field">
							        <b-timepicker
							            placeholder="Type or select a date..."
							            icon="clock"
							            editable
		                      			@input="timePickerInput"
							            v-model="inspectionForm.time">
							        </b-timepicker>
								</div>
							</div>
							<div class="column">
			        			<p class="buttons">
								  <a class="button is-success"  @click="saveReportsHandedOver()">
								    <span class="icon is-small">
								      <i class="fa fa-save"></i>
								    </span>
								  </a>
								  <a class="button is-warning" @click="deleteReportsHandedOver()">
								    <span class="icon is-small">
								      <i class="fa fa-times"></i>
								    </span>
								  </a>
								</p>
							</div>
						</div>
					</div>
				</div>
				<br>
			<br>
		</div>
	</div>
</template>

<script>
export default {
	props: ['inspectionId'],
	data() {
		return {
			isSuccess: 'is-success',
			isWarning: 'is-warning',
			isDanger: 'is-danger',
			inspection: {},
			item: {},
			pageLoaded: false,
			isFollowUpRequired: '',
			isFined: '',
			payEnabled: false,
			enableHandover: false,
			inspectionForm: new Form({
				date: new Date(),
				time: new Date(),
				datetimeString: '',
				dateString: '',
				timeString: '',
				inspection_id: null,
				type: null
			}),
			fineForm: new Form({
				amount: null,
				fined_on: new Date(),
				is_paid: false,
				paid_on: new Date(),
			}),
			editMode: false,
			inspectionForm2: new Form({
				date:new Date(),
				time: new Date(),
				datetimeString: '',
				dateString: '',
				timeString: '',
				inspection_id: null,
				type: null
			})
		}
	},
	mounted() {
		this.getInspection();
		this.datePickerInput();
		this.timePickerInput();
		this.datePickerInput2();
		this.timePickerInput2();
	},
	methods: {
		datePickerInput(date) {
			var date = (date) ? date: this.inspectionForm.date;
			// YYYY-MM-DD HH:MI:SS
			this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
		},
		timePickerInput() {
			if (this.inspectionForm.time) {
				var date = this.inspectionForm.time;
				this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
			}
		},
		pad(value) {
		    if(value < 10) {
		        return '0' + value;
		    } else {
		        return value;
		    }
		},
		buildDateTimeString() {
			return this.inspectionForm.datetimeString = this.inspectionForm.dateString + ' ' + this.inspectionForm.timeString;
		},
		datePickerInput2(date) {
			var date = (date) ? date: this.inspectionForm2.date;
			// YYYY-MM-DD HH:MI:SS
			this.inspectionForm2.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
		},
		timePickerInput2() {
			if (this.inspectionForm2.time) {
				var date = this.inspectionForm2.time;
				this.inspectionForm2.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
			}
		},
		buildDateTimeString2() {
			return this.inspectionForm2.datetimeString = this.inspectionForm2.dateString + ' ' + this.inspectionForm2.timeString;
		},
		goToReport(item, lang) {
			// inspections/{inspection}/dhivehi/reports
  			switch(lang) {
			    case "dv":
							window.location.href= "/inspections/" + item.id + "/dhivehi/reports/edit"
			                // this.$router.push({ name: 'dhivehi-reports.show', params: { reportId: item.dhivehi_report_id } })
			        break;
			    case "en":
							window.location.href= "/inspections/" + item.id + "/english/reports"
	                        // this.$router.push({ name: 'english-reports.show', params: { reportId: item.english_report_id } })
			        break;
			    default:
							// window.location.href= "/inspections/" + item.id + "/reports"
							// 
                    break;
                case "en":
			}
		},
		changedisFined() {
			if(this.pageLoaded) {
				axios
	  			.patch('/api/inspections/' + this.inspectionId + '/updatefined', {
	  				fined: this.isFined
	  			})
				.then(response => {
				}).catch(erros => {
					this.getInspection();
				});
			}
		},
		changedisFollowUpRequired() {
			if(this.pageLoaded) {
				axios
	  			.patch('/api/inspections/' + this.inspectionId + '/updatefollowup', {
	  				followup: this.isFollowUpRequired
	  			})
				.then(response => {
				}).catch(erros => {
					this.getInspection();
				});
			}
		},
		saveFine() {
			axios
			.post('/inspections/' + this.inspectionId + '/fines', {
				amount: this.fineForm.amount,
				fined_on: this.formatDate(this.fineForm.fined_on),
				paid_on: this.paid(this.fineForm.paid_on),
				is_paid: this.fineForm.is_paid,
				receipt_no: (this.payEnabled) ? this.fineForm.receipt_no : null,
			})
			.then(response => {
				this.getInspection();
			})
			.catch(errors => console.log(errors));
		},
		paid(date) {
			if(this.payEnabled) {
				return this.formatDate(date);
			}

			return null;
		},
		formatDate(date) {
			return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' 00:00:00';
		},
		deleteFine() {
			axios
  			.delete('/inspections/' + this.inspectionId + '/fines')
			.then(response => {
				this.getInspection();
			})
			.catch(errors => console.log(errors));
		},
		deleteReportsHandedOver() {
			axios.patch('/api/inspections/' + this.inspectionId + '/handoverreports', {
				'report_handed_over_at': null
			}).then(response => {
				this.getInspection();
			})
			.catch(errors => console.log(errors));
		},
		saveReportsHandedOver() {
			axios.patch('/api/inspections/' + this.inspectionId + '/handoverreports', {
				'report_handed_over_at': this.buildDateTimeString()
			}).then(response => {
				this.getInspection();
			})
			.catch(errors => console.log(errors));
		},
		getInspection() {
			axios
  			.get('/api/inspections/' + this.inspectionId)
			.then(response => {
				this.setFromModel(response.data);
			})
			.catch(errors => console.log(errors));
		},
		setFromModel(data) {
			this.inspection = data;
			this.item = this.inspection.follow_up_inspection
			this.business = this.inspection.business;
			this.isFollowUpRequired = this.inspection.is_followup_required;
			this.isFined = this.inspection.is_fined;

			this.enableHandover = (this.inspection.report_handed_over_at) ? true : false;

			if(this.inspection.fine) {
				this.fineForm.amount = this.inspection.fine.amount;
				this.fineForm.fined_on = new Date(this.inspection.fine.fined_on);
				this.fineForm.paid_on = new Date(this.inspection.fine.paid_on);
				this.fineForm.is_paid = this.inspection.fine.is_paid;
				this.fineForm.receipt_no = this.inspection.fine.receipt_no;
			} else {
				this.fineForm.amount = null;
				this.fineForm.fined_on = new Date();
				this.fineForm.paid_on = new Date();
				this.fineForm.is_paid = false;
				this.fineForm.receipt_no = null;
			}

			this.pageLoaded = true;
		},
		toggleEditItemMode(item) {
			this.editMode = !this.editMode;
			if (item.id != this.inspectionForm2.inspection_id) {
				this.editMode = true;
			}
			if (this.editMode) {
				var date = new Date(item.inspection_at);
				this.inspectionForm2.date = date;
				this.inspectionForm2.time =  date;
				this.inspectionForm2.type =  item.type;
				this.inspectionForm2.reason =  item.reason;
				this.inspectionForm2.remarks =  item.remarks;
				this.inspectionForm2.status =  item.status;
				this.inspectionForm2.inspection_id = item.id;
			}
		},
		updateInspection() {
			axios.patch('/inspections/' + this.inspectionForm2.inspection_id, {
				'inspection_at': this.buildDateTimeString(),
				'status': this.inspectionForm2.status,
				'reason': this.inspectionForm2.reason,
				'remarks': this.inspectionForm2.remarks
				// 'is_followup': this.inspectionForm2.is_followup,
			}).then(response => {
				this.getInspection();
			})
			.catch(errors => console.log(errors));
		}
	}
}
</script>