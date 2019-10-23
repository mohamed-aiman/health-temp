Vue.component('business-details', require('./components/business-details.vue'));
Vue.component('business-inspections', require('./components/business-inspections.vue'));
Vue.component('business-grading-inspections', require('./components/business-grading-inspections.vue'));
Vue.component('business-applications', require('./components/business-applications.vue'));
Vue.component('business-licenses', require('./components/business-licenses.vue'));
Vue.component('business-fines', require('./components/business-fines.vue'));
Vue.component('business-terminations', require('./components/business-terminations.vue'));

const app = new Vue({
	el: "#app",
	data: {
		businessId: document.getElementById('business_id').value,
		business: null,
		isComponentModalActive: false,
		isGradingModalActive: false,
		file: null,
		inspectionForm: new Form({
			date:new Date(),
			time: new Date(),
			datetimeString: '',
			dateString: '',
			timeString: '',
			reason: null,
			remarks: null
		})
	},
	mounted() {
		this.getBusiness();
		this.datePickerInput();
		this.timePickerInput();
	},
	methods: {
		datePickerInput(date) {
			var date = (date) ? date: this.inspectionForm.date;
			// YYYY-MM-DD HH:MI:SS
			this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
			console.log(this.inspectionForm.dateString);
		},
		buildDateTimeString() {
			return this.inspectionForm.datetimeString = this.inspectionForm.dateString + ' ' + this.inspectionForm.timeString;
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
		formatDate(date) {
			return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' 00:00:00';
		},
		saveGradingInspection() {
			this.submitSaveInspection('/api/businesses/' + this.businessId + '/gradinginspections', {
				'inspection_at': this.buildDateTimeString(),
				'reason':this.inspectionForm.reason,
			})
		},
		saveInspection() {
			this.submitSaveInspection('/api/businesses/' + this.businessId + '/inspections', {
				'inspection_at': this.buildDateTimeString(),
				'reason':this.inspectionForm.reason,
				'remarks':this.inspectionForm.remarks,
			});
		},
		submitSaveInspection(url, data) {
			axios
			.post(url, data)
			.then(response => {
				this.getBusiness();
			})
			.catch(errors => {
				console.log('errors', errors);
			});	
		},
		deleteInspection(inspection) {
			axios
			.delete('/inspections/' + inspection.id)
			.then(response => {
				this.getBusiness();
			})
			.catch(errors => {
				console.log('errors', errors);
			});	
		},
		getBusiness() {
			axios
  		.get('/api/businesses/' + this.businessId)
			.then(response => {
				this.business = response.data;
				console.log(response.data)
			})
			.catch(errors => console.log(errors));	
		}
	}
});