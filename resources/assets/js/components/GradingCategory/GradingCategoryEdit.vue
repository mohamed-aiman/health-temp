<template>
<div v-can="'api.grading-categories.update'">
	<div class="columns">
		<div class="column is-fullwidth">
	      <h1 class="title">
	        Edit the Grading Category
	      </h1>
		</div>
	</div>
	<div class="container">
		<div class="columns">
			<div class="column">
				<div class="field is-grouped">
				  <div class="control">
				    <router-link class="button is-info is-medium" v-can="'api.grading-categories.index'" :to="{ name: 'grading-categories.manage' }">
					    <span class="icon is-small">
					      <i class="fa fa-chevron-left"></i>
					    </span>
					    <span>Back to Grading Categories</span>
					</router-link>
				  </div>
			  </div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="columns">
			<div class="column">
				<table class="table is-bordered">
					<tr>
	          <th class="dhivehi right">ބޭނުންކުރޭ</th>
	          <th class="dhivehi right">ތަރުތީބު</th>
	          <th class="dhivehi right">ތަފްޞީލް</th>
					</tr>
					<tr>
	          <td><b-switch v-model="gradingCategory.is_active"></b-switch></td>
	          <td class="dhivehi"><input class="input" type="number" v-model="gradingCategory.order"></td>
	          <td class="dhivehi"><input class="input" type="text" v-model="gradingCategory.text"></td>
					</tr>	
				</table>
			</div>
		</div>
		<div class="columns">
			<div class="column"></div>
			<div class="column" style="text-align: center;">
				<div class="field is-grouped">
				  <div class="control" v-can="'api.grading-categories.update'">
	 					  <button   class="button is-large is-warning" @click="updateGradingCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      UPDATE
						    <!-- </span> -->
						  </button>
				  </div>
				  <div class="control" v-can="'api.grading-categories.show'">
	 					  <button   class="button is-large is-info" @click="getGradingCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      RESET
						    <!-- </span> -->
						  </button>
				  </div>
				  <div class="control" v-can="'api.grading-categories.destroy'">
	 					  <button   class="button is-large is-danger" @click="deleteGradingCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      DELETE
						    <!-- </span> -->
						  </button>
				  </div>
				</div>
			</div>
			<div class="column"></div>
		</div>
	</div>
</div>
</template>

<script>
	
export default {
	props:['gradingCategoryId'],
	data() {
		return {
			isActive: false,
			gradingCategory: {},
			form: new Form({})
		}
	},
	mounted() {
		this.getGradingCategory();
	},
	methods: {
		getGradingCategory() {
			if (this.hasPermission('api.grading-categories.show')) {
				axios
		  		.get('/api/gradingcategories/' + this.gradingCategoryId)
					.then(response => {
						this.gradingCategory = response.data;
					})
					.catch(errors => console.log(errors));
			}
		},
		updateGradingCategory() {
			if (this.hasPermission('api.grading-categories.update')) {
			axios
	  		.patch('/api/gradingcategories/' + this.gradingCategoryId, this.gradingCategory)
				.then(response => {
					this.gradingCategory = response.data;
				})
				.catch(errors => console.log(errors));	
			}
		},
		deleteGradingCategory() {
			if (this.hasPermission('api.grading-categories.destroy')) {
			  if(!confirm("Are you sure you want to delete this?")) { return;}
				axios
		  		.delete('/api/gradingcategories/' + this.gradingCategoryId)
					.then(response => {
						alert('deleted successfully');
						this.gradingCategory = {};
						this.$router.push({ name: 'grading-categories.manage'})

					})
					.catch(errors => {
						alert('unable to delete. may be it is attached to a grading point.');
						this.getGradingCategory();
					});	
			}
		}
	}
}


</script>