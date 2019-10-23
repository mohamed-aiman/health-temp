const app = new Vue({
	el: "#app",
	data: {
		isActive: false,
		gradingCategoryId: document.getElementById('grading_category_id').value,
		gradingCategory: {},
		gradingCategories: {},
		form: new Form({})
	},
	mounted() {
		this.getGradingCategory();
		this.getGradingCategories();
	},
	methods: {
		getGradingCategory() {
			axios
	  		.get('/api/gradingcategories/' + this.gradingCategoryId)
				.then(response => {
					this.gradingCategory = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		updateGradingCategory() {
			axios
	  		.patch('/api/gradingcategories/' + this.gradingCategoryId, this.gradingCategory)
				.then(response => {
					this.gradingCategory = response.data;
				})
				.catch(errors => console.log(errors));	
		},
		deleteGradingCategory() {
		  if(!confirm("Are you sure you want to delete this?")) { return;}
			axios
	  		.delete('/api/gradingcategories/' + this.gradingCategoryId)
				.then(response => {
					alert('deleted successfully');
					this.gradingCategory = {};
					window.location.href = '/gradingcategories/manage';
				})
				.catch(errors => {
					alert('unable to delete. may be it is attached to a grading point.');
					this.getGradingCategory();
				});	
		}
	}
});