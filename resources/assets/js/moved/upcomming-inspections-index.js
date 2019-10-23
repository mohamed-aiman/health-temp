const app = new Vue({
	el: "#app",
	data: {
		isSuccess: 'is-success',
		isWarning: 'is-warning',
		isDanger: 'is-danger',
		states: ['scheduled', 'finished', 'cancelled'],
		inspections: [],
		editMode: false,
		inspectionForm: new Form({
			date:new Date(),
			time: new Date(),
			datetimeString: '',
			dateString: '',
			timeString: '',
			inspection_id: null,
			type: null,
			reason: null,
			remarks: null
		}),
        pagination: {
            total: 200,
            current: 1,
            perPage: 100,
            order: '',
            size: '',
            isSimple: false,
            isRounded: false,
		},
	},
  watch: {
	},
	mounted() {
		this.getInspections();
		this.datePickerInput();
		this.timePickerInput();
	},
	methods: {
		getInspections(page = 1) {
            axios
	  		.get('/api/inspections/upcoming'
	  			+ '?page=' + page
	  			)
			.then(response => {
				this.inspections = response.data.data;
				this.setPagination(response.data);
				console.log(response.data)
			})
			.catch(errors => console.log(errors));	
		},
	    pageChange(page) {
		    this.pagination.current = page;
		    this.getInspections(page);
        },
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		},
		updateInspection() {
			axios.patch('/inspections/' + this.inspectionForm.inspection_id, {
				'inspection_at': this.buildDateTimeString(),
				'status': this.inspectionForm.status,
				'reason': this.inspectionForm.reason,
				'remarks': this.inspectionForm.remarks
				// 'is_followup': this.inspectionForm.is_followup,
			}).then(response => {
				this.getInspections();
				console.log(response.data)
			})
			.catch(errors => console.log(errors));
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
				console.log('timesb4',this.inspectionForm.time);
				this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
				console.log('timestring',this.inspectionForm.timeString);
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
		toggleEditItemMode(item) {
			this.editMode = !this.editMode;
			if (item.id != this.inspectionForm.inspection_id) {
				this.editMode = true;
			}
			if (this.editMode) {
				var date = new Date(item.inspection_at);
				this.inspectionForm.date = date;
				this.inspectionForm.time =  date;
				this.inspectionForm.type =  item.type;
				this.inspectionForm.reason =  item.reason;
				this.inspectionForm.remarks =  item.remarks;
				this.inspectionForm.status =  item.status;
				this.inspectionForm.inspection_id = item.id;
			}
		},
		isFormAttached(inspection) {
			return (inspection.normal_form_id != null) ? 'is-success' : 'is-warning';
		}
	}
});