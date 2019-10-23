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
			status: 'all',
			tobaccoOrFood: 'all',
			registerOrRenew: 'all',
		})
	},
  	watch: {
  		'form.applicationId': function() {
  			this.getApplications();
  		},
  		'form.status': function() {
  			this.getApplications();
  		},
  		'form.tobaccoOrFood': function() {
  			this.getApplications();
  		},
  		'form.registerOrRenew': function() {
  			this.getApplications();
  		}
	},
	mounted() {
		this.getApplications();
	},
	methods: {
		getApplications(page = 1) {
			axios
	  		.get('/api/applications?' 
	  			+ 'status=' + this.form.status
	  			+ '&tobaccoOrFood=' + this.form.tobaccoOrFood 
	  			+ '&registerOrRenew=' + this.form.registerOrRenew
	  			+ '&applicationId=' + this.form.applicationId
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
		},
		updateStatus(item) {
			axios
			.patch("/api/applications/" + item.id  + "/updateStatus", {
				'status': item.status
			})
			.then(response => {
				item = response.data;
			})
			.catch(error => {
				console.log(error);
			});

		}
	}
});