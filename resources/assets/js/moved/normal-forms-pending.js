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
		normalforms: [],
	},
	mounted() {
		this.getNormalForms();
	},
	methods: {
		getNormalForms(page = 1) {
			axios
	  		.get('/api/normalforms/pending?'
	  			+ 'page=' + page
	  			)
				.then(response => {
					console.log(response.data);
					this.normalforms = response.data.data;
					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));	
		},
		pageChange (page) {
		    this.current = page;
		    this.getNormalForms(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		},
		processItem(item) {
			window.location.href= "/normalforms/" + item.id + "/process"
		}
	}
});