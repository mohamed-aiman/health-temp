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
		terminations: [],
		form: new Form({
			terminationId: '',
			inspectionId: '',
			registrationNo:'',
			placeNameDv:''
		})
	},
  	watch: {
  		'form.terminationId': _.debounce(function() {
  			this.getTerminations();
  		}, 500),
  		'form.inspectionId': _.debounce(function() {
  			this.getTerminations();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getTerminations();
  		}, 500),
  		'form.placeNameDv': _.debounce(function() {
  			this.getTerminations();
  		}, 500)
	},
	mounted() {
		this.getTerminations();
	},
	methods: {
		getTerminations(page = 1) {
			axios
	  		.get('/api/terminations?' 
	  			+ 'terminationId=' + this.form.terminationId
	  			+ '&inspectionId=' + this.form.inspectionId
	  			+ '&registrationNo=' + this.form.registrationNo
	  			+ '&placeNameDv=' + this.form.placeNameDv
	  			+ '&page=' + page
	  			)
				.then(response => {
					console.log(response.data);
					this.terminations = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));	
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getTerminations(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
});