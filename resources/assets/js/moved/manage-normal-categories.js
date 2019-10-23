const app = new Vue({
	el: "#app",
	data: {
		items: [],
		openForm: false,
		normalCategory: {
			order: null, 
			text: null,
			is_active: false, 
		}
	},
	mounted() {
		this.getNormalCategories();
	},
	methods: {
		getNormalCategories() {
			axios
	  		.get('/api/normalcategories')
				.then(response => {
					this.items = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		switchOpenCloseForm() {
			this.openForm = (this.openForm) ? false : true;
			this.normalCategory = {order: null,  text: null, is_active: false};
		},
		saveNormalCategory() {
			axios
	  		.post('/api/normalcategories', this.normalCategory)
				.then(response => {
					this.switchOpenCloseForm();
					this.getNormalCategories();
				})
				.catch(errors => console.log(errors));	
		}
	}
});