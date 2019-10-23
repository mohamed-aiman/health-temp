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
		licenses: [],
		form: new Form({
			licenseId: '',
			applicationId: '',
			registrationNo:'',
			placeNameDv:'',
			licenseNo:''
		})
	},
  	watch: {
  		'form.licenseId': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
  		'form.applicationId': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
  		'form.placeNameDv': _.debounce(function() {
  			this.getLicenses();
  		}, 500),
		'form.licenseNo': _.debounce(function() {
  			this.getLicenses();
  		}, 500)
	},
	mounted() {
		this.getLicenses();
	},
	methods: {
		getLicenses(page = 1) {
			axios
	  		.get('/api/licenses?' 
	  			+ 'licenseId=' + this.form.licenseId
	  			+ '&applicationId=' + this.form.applicationId
	  			+ '&registrationNo=' + this.form.registrationNo
	  			+ '&placeNameDv=' + this.form.placeNameDv
	  			+ '&licenseNo=' + this.form.licenseNo
	  			+ '&page=' + page
	  			)
				.then(response => {
					console.log(response.data);
					this.licenses = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));	
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getLicenses(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
});