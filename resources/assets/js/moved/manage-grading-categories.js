const app = new Vue({
	el: "#app",
	data: {
		items: [],
		openForm: false,
		gradingCategory: {
			order: null, 
			text: null,
			is_active: false, 
		}
	},
	mounted() {
		this.getGradingCategories();
	},
	methods: {
		getGradingCategories() {
			axios
	  		.get('/api/gradingcategories')
				.then(response => {
					this.items = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		switchOpenCloseForm() {
			this.openForm = (this.openForm) ? false : true;
			this.gradingCategory = {order: null,  text: null, is_active: false};
		},
		saveGradingCategory() {
			axios
	  		.post('/api/gradingcategories', this.gradingCategory)
				.then(response => {
					this.switchOpenCloseForm();
					this.getGradingCategories();
				})
				.catch(errors => console.log(errors));	
		}
	}
});
