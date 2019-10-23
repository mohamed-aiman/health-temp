const app = new Vue({
	el: "#app",
	data: {
		inspections: [],
        pagination: {
            total: 200,
            current: 1,
            perPage: 100,
            order: '',
            size: '',
            isSimple: false,
            isRounded: false,
		},
		form: new Form({
			inspectionId: '',
			applicationId: '',
			registrationNo:'',
			placeNameDv:''
		})
	},
  watch: {
  		'form.inspectionId': _.debounce(function() {
  			this.getInspections();
  		}, 500),
  		'form.applicationId': _.debounce(function() {
  			this.getInspections();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getInspections();
  		}, 500),
  		 'form.placeNameDv': _.debounce(function() {
  			this.getInspections();
  		}, 500),
	},
	mounted() {
		this.getInspections();
	},
	methods: {
		getInspections(page = 1) {
            axios
	  		.get('/api/inspections?'
	  			+ 'inspectionId=' + this.form.inspectionId
	  			+ '&applicationId=' + this.form.applicationId
	  			+ '&registrationNo=' + this.form.registrationNo
	  			+ '&placeNameDv=' + this.form.placeNameDv
	  			+ '&page=' + page
	  			)
			.then(response => {
				this.inspections = response.data.data;
				this.setPagination(response.data);
				console.log(response.data)
			})
			.catch(errors => console.log(errors));	
		},
	    pageChange(page) {
		    this.current = page;
		    this.getInspections(page);
        },
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
});