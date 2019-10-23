const app = new Vue({
	el: "#app",
	data: {
		items: [],
		openForm: false,
		normalPoint: {
			no: null, 
			code: null, 
			text: null, 
			normal_category_id: null, 
			order: null, 
			is_active: false, 
		},
		normalCategories: []
	},
	mounted() {
		this.getNormalPoints();
		this.getNormalCategories();
	},
	methods: {
		getNormalPoints() {
			axios
	  		.get('/api/normalpoints')
				.then(response => {
					this.items = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		getNormalCategories() {
			axios
	  		.get('/api/normalcategories/forselect')
				.then(response => {
					// console.log(response.data);
					this.normalCategories = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		switchOpenCloseForm() {
			this.openForm = (this.openForm) ? false : true;
			this.normalPoint = {no: null,  code: null,  text: null, normal_category_id: null, order: null, is_active: false};
		},
		saveNormalPoint() {
			axios
	  		.post('/api/normalpoints', this.normalPoint)
				.then(response => {
					this.switchOpenCloseForm();
					this.getNormalPoints();
				})
				.catch(errors => console.log(errors));	
		}
	}
});