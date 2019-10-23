Vue.component('business-details', require('./components/business-details.vue'));

const app = new Vue({
	el: "#app",
	data: {
		inspectionId: document.getElementById('inspection_id').value,
		isSuccess: 'is-success',
		isWarning: 'is-warning',
		isDanger: 'is-danger',
		inspection: {
			fines:[]
		},
		fines: [],
		item: {},
		pageLoaded: false,
		isFollowUpRequired: '',
		isIssueLicenseFormOpen: false,
		isRenewLicenseFormOpen: false,
		isNewFineFormOpened: false,
		isTerminateFormOpened: false,
		isUpdateFineFormOpened: false,
		isComponentModalActive: false,
		isFined: '',
		payEnabled: false,
		enableHandover: false,
		// inspectionForm: new Form({
		// 	date: new Date(),
		// 	time: new Date(),
		// 	datetimeString: '',
		// 	dateString: '',
		// 	timeString: '',
		// 	inspection_id: null,
		// 	type: null
		// }),
		terminateForm: {
			reason: null,
			terminated_on:new Date(),
		},
		inspectionForm: new Form({
			date:new Date(),
			time: new Date(),
			datetimeString: '',
			dateString: '',
			timeString: '',
			reason: null,
			remarks: null
		}),
		fineForm: new Form({
			amount: null,
			fined_on: new Date(),
			remarks: null,
			is_paid: false,
			paid_on: new Date(),
		}),
		fineForm2: new Form({
			id: null,
			amount: null,
			fined_on: new Date(),
			remarks: null,
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
		}),
		issueLicenseForm: {
			issued_date: new Date(),
			expiry_date: new Date(),
			license_no: null
		}
	},
	watch: {
	},
	mounted() {
		this.getInspection();
		this.getInspectionFines();
		this.datePickerInput();
		this.timePickerInput();
		this.datePickerInput2();
		this.timePickerInput2();
	},
	methods: {
		closeAll() {
			axios
			.patch('/api/inspections/'+this.inspection.id +'/close')
			.then(response => {
				this.getInspection();
			})
			.catch(errors => {
				alert('Error closing inspection: ' + errors.response.data.message);
			});	
		},
		backendAcceptedDate(date) {
			var date = (date) ? date: this.inspectionForm2.date;
			return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
		},
		issueLicense() {
			axios
			.post('/api/applications/'+this.inspection.application_id+'/licenses', {
				issued_date: this.backendAcceptedDate(this.issueLicenseForm.issued_date),
				expiry_date: this.backendAcceptedDate(this.issueLicenseForm.expiry_date),
				license_no: this.issueLicenseForm.license_no
			})
			.then(response => {
				this.getInspection();
			})
			.catch(errors => {
				alert('Error issueing license: ' + errors.response.data.message);
			});	
		},
		saveInspection() {
			this.submitSaveInspection('/api/inspections/' + this.inspection.id + '/followupinspections', {
				'inspection_at': this.buildDateTimeString(),
				'reason':this.inspectionForm.reason,
				'remarks':this.inspectionForm.remarks,
			});
		},
		submitSaveInspection(url, data) {
			axios
			.post(url, data)
			.then(response => {
				this.getInspection();
			})
			.catch(errors => {
				alert('Error creating new follow up inspection: ' + errors.response.data.message);
			});	
		},
		deleteFollowUpInspection() {
			axios
			.delete('/followupinspections/' + this.inspection.id)
			.then(response => {
				this.getInspection();
			})
			.catch(errors => {
				alert('Error deleting follow up inspection: ' + errors.response.data.message);
			});	
		},
		deleteFine(item) {
			axios
			.delete('/fines/' + item.id)
			.then(response => {
				this.getInspectionFines();
			})
			.catch(errors => {
				alert('Error deleting fine:' + errors.response.data.message);
			});	
		},
		datePickerInput(date) {
			var date = (date) ? date: this.inspectionForm.date;
			// YYYY-MM-DD HH:MI:SS
			this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
			console.log(this.inspectionForm.dateString);
		},
		timePickerInput() {
			if (this.inspectionForm.time) {
				var date = this.inspectionForm.time;
				this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
				console.log(this.inspectionForm.timeString);
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
			console.log(this.inspectionForm2.dateString);
		},
		timePickerInput2() {
			if (this.inspectionForm2.time) {
				var date = this.inspectionForm2.time;
				this.inspectionForm2.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
				console.log(this.inspectionForm2.timeString);
			}
		},
		buildDateTimeString2() {
			return this.inspectionForm2.datetimeString = this.inspectionForm2.dateString + ' ' + this.inspectionForm2.timeString;
		},
		gotToReport(item, lang) {
			// inspections/{inspection}/dhivehi/reports
  			switch(lang) {
			    case "dv":
							window.location.href= "/inspections/" + item.id + "/dhivehi/reports/edit"
			        break;
			    case "en":
							window.location.href= "/inspections/" + item.id + "/english/reports/edit"
			        break;
			    default:
							// window.location.href= "/inspections/" + item.id + "/reports"
			}
		},
		openTerminateForm() {
			this.isTerminateFormOpened = !this.isTerminateFormOpened;
		},
		openNewFineForm() {
			this.isNewFineFormOpened = !this.isNewFineFormOpened;
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
		updateFine() {
			axios
			.patch('/fines/' + this.fineForm2.id, {
				amount: this.fineForm2.amount,
				fined_on: this.formatDate(this.fineForm2.fined_on),
				remarks: this.fineForm2.remarks,
			})
			.then(response => {
				this.getInspectionFines();
				this.isUpdateFineFormOpened = false;
			})
			.catch(errors => console.log(errors));
		},
		openUpdateForm() {
			this.isUpdateFineFormOpened = !this.isUpdateFineFormOpened;
		},
		loadFineForm(item) {
				this.fineForm2.id = item.id;
				this.fineForm2.amount = item.amount;
				this.fineForm2.fined_on = new Date(item.fined_on);
				this.fineForm2.remarks = item.remarks;

				this.isUpdateFineFormOpened = true;
		},
		addFine() {
			axios
			.post('/inspections/' + this.inspectionId + '/fines', {
				amount: this.fineForm.amount,
				fined_on: this.formatDate(this.fineForm.fined_on),
				paid_on: this.paid(this.fineForm.paid_on),
				remarks: this.fineForm.remarks,
			})
			.then(response => {
				this.getInspectionFines();
			})
			.catch(errors => console.log(errors));
		},
		getInspectionFines() {
			axios
  		.get('/api/inspections/' + this.inspectionId + '/fines')
			.then(response => {
				this.fines = response.data;
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
		saveTermination() {
			if (!confirm('Are you sure you want to terminate this business?')) {
				return;
			}
			axios
			.post('/businesses/' + this.inspection.business_id + '/terminate', {
				reason: this.terminateForm.reason,
				terminated_on: this.formatDate(this.terminateForm.terminated_on),
			})
			.then(response => {
				console.log(response.data);
				alert('business terminated successfully.');
			})
			.catch(errors => console.log(errors));
		},
		// deleteFines() {
		// 	axios
  // 			.delete('/inspections/' + this.inspectionId + '/fines')
		// 	.then(response => {
		// 		this.getInspection();
		// 	})
		// 	.catch(errors => console.log(errors));
		// },
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
				console.log(response.data);
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
				console.log(response.data)
			})
			.catch(errors => console.log(errors));
		}
	}
});