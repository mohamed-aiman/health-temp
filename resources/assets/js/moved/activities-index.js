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
		activities: []
	},
	mounted() {
		this.getActivities();
	},
	methods: {
		getActivities(page = 1) {
			axios
	  		.get('/api/user/activities?'
	  			+ 'page=' + page
	  			)
				.then(response => {
					this.activities = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));
		},
		pageChange (page) {
		    this.current = page
		    // this.filter.offset = ((this.current - 1) * this.filter.limit)
		    this.getActivities(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		}
	}
});