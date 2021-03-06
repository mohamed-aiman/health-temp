const app = new Vue({
	el: "#app",
	data: {
		pagination: {
            total: 200,
            current: 1,
            perPage: 100,
            order: '',
            size: '',
            isSimple: false,
            isRounded: false,
		},
		applications: [],
		form: new Form({
			applicationId: '',
			tobaccoOrFood: 'all',
			registerOrRenew: 'all',
			registrationNo:'',
			placeNameDv:''
		})
	},
  	watch: {
  		'form.applicationId': function() {
  			this.getApplications();
  		},
  		'form.tobaccoOrFood': function() {
  			this.getApplications();
  		},
  		'form.registerOrRenew': function() {
  			this.getApplications();
  		},
  		'form.registrationNo': _.debounce(function() {
  			this.getApplications();
  		}, 500),
  		'form.placeNameDv': _.debounce(function() {
  			this.getApplications();
  		}, 500)
	},
	mounted() {
		this.getApplications();
	},
	methods: {
		getApplications(page = 1) {
			axios
	  		.get('/api/applications/pending?' 
	  			+ 'tobaccoOrFood=' + this.form.tobaccoOrFood 
	  			+ '&registerOrRenew=' + this.form.registerOrRenew
	  			+ '&applicationId=' + this.form.applicationId
	  			+ '&registrationNo=' + this.form.registrationNo
	  			+ '&placeNameDv=' + this.form.placeNameDv
	  			+ '&page=' + page
	  			)
				.then(response => {
					console.log(response.data);
					this.applications = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));	
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getApplications(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		},
		processItem(item) {
			window.location.href= "/applications/" + item.id + "/process"
		}
	}
});