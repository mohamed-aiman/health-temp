<template>
<div v-can="'api.normal-categories.update'">
	<div class="columns">
		<div class="column is-fullwidth">
	      <h1 class="title">
	        Edit the Normal Category
	      </h1>
		</div>
	</div>
	<div class="container">
		<div class="columns">
			<div class="column">
				<div class="field is-grouped">
				  <div class="control">
				    <router-link class="button is-info is-medium" v-can="'api.normal-categories.index'" :to="{ name: 'normal-categories.manage' }">
					    <span class="icon is-small">
					      <i class="fa fa-chevron-left"></i>
					    </span>
					    <span>Back to Normal Categories</span>
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
	          <td><b-switch v-model="normalCategory.is_active"></b-switch></td>
	          <td class="dhivehi"><input class="input" type="number" v-model="normalCategory.order"></td>
	          <td class="dhivehi"><input class="input" type="text" v-model="normalCategory.text"></td>
					</tr>	
				</table>
			</div>
		</div>
		<div class="columns">
			<div class="column"></div>
			<div class="column" style="text-align: center;">
				<div class="field is-grouped">
				  <div class="control" v-can="'api.normal-categories.update'">
	 					  <button   class="button is-large is-warning" @click="updateNormalCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      UPDATE
						    <!-- </span> -->
						  </button>
				  </div>
				  <div class="control" v-can="'api.normal-categories.show'">
	 					  <button   class="button is-large is-info" @click="getNormalCategory">
						    <!-- <span class="icon"> -->
						      <!-- <i class="fa fa-save"></i> -->
						      RESET
						    <!-- </span> -->
						  </button>
				  </div>
				  <div class="control" v-can="'api.normal-categories.destroy'">
	 					  <button   class="button is-large is-danger" @click="deleteNormalCategory">
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
	props:['normalCategoryId'],
	data() {
		return {
			isActive: false,
			normalCategory: {},
			form: new Form({})
		}
	},
	mounted() {
		this.getNormalCategory();
	},
	methods: {
		getNormalCategory() {
			if (this.hasPermission('api.normal-categories.show')) {
				axios
		  		.get('/api/normalcategories/' + this.normalCategoryId)
					.then(response => {
						this.normalCategory = response.data;
					})
					.catch(errors => console.log(errors));
			}
		},
		updateNormalCategory() {
			if (this.hasPermission('api.normal-categories.update')) {
			axios
	  		.patch('/api/normalcategories/' + this.normalCategoryId, this.normalCategory)
				.then(response => {
					this.normalCategory = response.data;
				})
				.catch(errors => console.log(errors));	
			}
		},
		deleteNormalCategory() {
			if (this.hasPermission('api.normal-categories.destroy')) {
			  if(!confirm("Are you sure you want to delete this?")) { return;}
				axios
		  		.delete('/api/normalcategories/' + this.normalCategoryId)
					.then(response => {
						alert('deleted successfully');
						this.normalCategory = {};
						this.$router.push({ name: 'normal-categories.manage'})

					})
					.catch(errors => {
						alert('unable to delete. may be it is attached to a normal point.');
						this.getNormalCategory();
					});	
			}
		}
	}
}


</script>