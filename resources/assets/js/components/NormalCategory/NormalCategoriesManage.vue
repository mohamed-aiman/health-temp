<template>
	<div>

		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        Manage Normal Categories
		      </h1>
			</div>
		</div>

		<div>
			<div class="columns">
				<div class="column">
					<div class="field is-grouped">
					  <div class="control">
		 					  <button v-can="'api.normal-categories.store'" v-if="!openForm" @click="switchOpenCloseForm" class="button is-success is-medium" >
		 					  	<span>New Normal Category</span>
							    <span class="icon is-small">
							      <i class="fa fa-plus"></i>
							    </span>
		 					  </button>
		 					  <button v-can="'api.normal-categories.store'" v-if="openForm" @click="switchOpenCloseForm" class="button is-warning is-medium" >
		 					  	<span>Close Normal Category Form</span>
							    <span class="icon is-small">
							      <i class="fa fa-close"></i>
							    </span>
		 					  </button>
					  </div>
				  </div>
				</div>
			</div>
		</div>

		<div v-can="'api.normal-categories.store'" v-if="openForm">
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
		          <td class="dhivehi"><input class="input" type="text" v-model="normalCategory.order"></td>
		          <td class="dhivehi"><input class="input" type="text" v-model="normalCategory.text"></td>
						</tr>
						<tr>
		 					  <td colspan="5" style="text-align: center;"><button class="button is-medium is-warning" @click="saveNormalCategory">SAVE</button></td>
						</tr>	
					</table>
				</div>
			</div>
		</div>

		<div v-can="'api.normal-categories.index'">
			<div class="columns">
				<div class="column">
					<table class="table is-bordered">
						<tr>
			          <th class="dhivehi right">ބޭނުންކުރޭ</th>
			          <th class="dhivehi right">ތަރުތީބު</th>
			          <th class="dhivehi right">ތަފްޞީލް</th>
		            <th class="dhivehi right" v-can="'api.normal-categories.update'">ބަދަލުގެނޭ</th>
						</tr>
						<tr v-for="item in items">
								<td>
							    <span class="icon has-text-success" v-if="item.is_active">
									  <i class="fas fa-check-square"></i>
									</span>
							    <span class="icon has-text-danger" v-if="!item.is_active">
									  <i class="fas fa-close"></i>
									</span>
		            </td>
		            <td class="dhivehi">{{item.order}}</td>
		            <td class="dhivehi">{{item.text}}</td>
		            <td v-can="'api.normal-categories.update'">
							<router-link class="button is-warning" v-can="'api.normal-categories.update'" :to="{ name: 'normal-categories.edit', params: { normalCategoryId: item.id }}">
							    <span class="icon is-small">
							      <i class="fa fa-edit"></i>
							    </span>
		                    </router-link>
		            </td>
						</tr>	
					</table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			items: [],
			openForm: false,
			normalCategory: {
				order: null, 
				text: null,
				is_active: false, 
			}
		}
	},
	mounted() {
		this.getNormalCategories();
	},
	methods: {
		getNormalCategories() {
			if (this.hasPermission('api.normal-categories.index')) {
				axios
		  		.get('/api/normalcategories')
					.then(response => {
						this.items = response.data;
					})
					.catch(errors => console.log(errors));
			}
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
}
</script>

<style scoped>
	table td:not([align]), table th:not([align]) {
	text-align: right;
	}
</style>