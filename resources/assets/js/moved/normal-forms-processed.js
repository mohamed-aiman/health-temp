const app = new Vue({
	el: "#app",
	data: {
		isSuccess: 'is-success',
		isWarning: 'is-warning',
		isDanger: 'is-danger',
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
	  		.get('/api/normalforms/processed?'
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
		gotToReport(item, lang) {
			// inspections/{inspection}/dhivehi/reports
  			switch(lang) {
			    case "dv":
							window.location.href= "/inspections/" + item.id + "/dhivehi/reports/edit"
			        break;
			    case "en":
							window.location.href= "/inspections/" + item.id + "/english/reports/edit"
			        break;
			    default:
							// window.location.href= "/inspections/" + item.id + "/reports"
			}
		}
	}
});