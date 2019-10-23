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
		fines: [],
		form: new Form({
			fineId: '',
			inspectionId: '',
			registrationNo:'',
			placeNameDv:''
		})
	},
  	watch: {
  		'form.fineId': _.debounce(function() {
  			this.getFines();
  		}, 500),
  		'form.inspectionId': _.debounce(function() {
  			this.getFines();
  		}, 500),
  		'form.registrationNo': _.debounce(function() {
  			this.getFines();
  		}, 500),
  		'form.placeNameDv': _.debounce(function() {
  			this.getFines();
  		}, 500)
	},
	mounted() {
		this.getFines();
	},
	methods: {
		getFines(page = 1) {
			axios
	  		.get('/api/fines?' 
	  			+ 'fineId=' + this.form.fineId
	  			+ '&inspectionId=' + this.form.inspectionId
	  			+ '&registrationNo=' + this.form.registrationNo
	  			+ '&placeNameDv=' + this.form.placeNameDv
	  			+ '&page=' + page
	  			)
				.then(response => {
					console.log(response.data);
					this.fines = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));	
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getFines(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
});