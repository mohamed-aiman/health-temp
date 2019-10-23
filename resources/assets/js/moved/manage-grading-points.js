const app = new Vue({
	el: "#app",
	data: {
		items: [],
		openForm: false,
		gradingPoint: {
			no: null, 
			code: null, 
			text: null, 
			grading_category_id: null, 
			order: null, 
			is_active: false, 
		},
		gradingCategories: []
	},
	mounted() {
		this.getGradingPoints();
		this.getGradingCategories();
	},
	methods: {
		getGradingPoints() {
			axios
	  		.get('/api/gradingpoints')
				.then(response => {
					this.items = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		getGradingCategories() {
			axios
	  		.get('/api/gradingcategories/forselect')
				.then(response => {
					// console.log(response.data);
					this.gradingCategories = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		switchOpenCloseForm() {
			this.openForm = (this.openForm) ? false : true;
			this.gradingPoint = {no: null,  code: null,  text: null, grading_category_id: null, order: null, is_active: false};
		},
		saveGradingPoint() {
			axios
	  		.post('/api/gradingpoints', this.gradingPoint)
				.then(response => {
					this.switchOpenCloseForm();
					this.getGradingPoints();
				})
				.catch(errors => console.log(errors));	
		}
	}
});