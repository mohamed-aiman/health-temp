const app = new Vue({
	el: "#app",
	data: {
		isSuccess: 'is-success',
		isWarning: 'is-grey',
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
		inspections: [],
	},
	mounted() {
		this.getInspections();
	},
	methods: {
		getInspections(page = 1) {
			axios
	  		.get('/api/inspections/reports/pending?'
	  			+ 'page=' + page
	  			)
				.then(response => {
					this.inspections = response.data;

					this.setPagination(response.data);
				})
				.catch(errors => console.log(errors));	
		},
		pageChange (page) {
		    this.current = page;
		    this.getInspections(page);
		},
		setPagination(data) {
			this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
		},
		gotToReport(item, lang) {
  			switch(lang) {
			    case "dv":
			    	this.goToDhivehiReport(item);
			        break;
			    case "en":
				    this.goToEnglishReport(item);
			        break;
			    default:
							// window.location.href= "/inspections/" + item.id + "/reports"
			}
		},
		goToDhivehiReport(item) {
			if (item.dhivehi_report.status != 'pending') {
				alert('the report does not exist or is not ready to be processed.');
				return;
			} else {
				window.location.href= "/dhivehi/reports/" + item.dhivehi_report.id + "/process";
			}
		},
		goToEnglishReport(item) {
		    if (item.english_report.status != 'pending') {
				alert('the report does not exist or is not ready to be processed.');
				return;
			} else {
				window.location.href= "/english/reports/" + item.english_report.id + "/process";
			}
		}
	}
});