<template>
	<div>
		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        Manage Normal Points
		      </h1>
			</div>
		</div>
		
		<div>
			<div class="columns">
				<div class="column">
					<div class="field is-grouped">
					  <div class="control">
		 					  <button v-if="!openForm && can('api.normal-points.store')" @click="switchOpenCloseForm" class="button is-success is-medium" >
		 					  	<span>New Normal Point</span>
							    <span class="icon is-small">
							      <i class="fa fa-plus"></i>
							    </span>
		 					  </button>
		 					  <button v-if="openForm && can('api.normal-points.store')" @click="switchOpenCloseForm" class="button is-warning is-medium" >
		 					  	<span>Close Normal Point Form</span>
							    <span class="icon is-small">
							      <i class="fa fa-close"></i>
							    </span>
		 					  </button>
					  </div>
				  </div>
				</div>
			</div>
		</div>

		<div v-if="openForm && can('api.normal-points.store')">
			<div class="columns">
				<div class="column">
					<table class="table is-bordered">
						<tr>
		          <th >ބޭނުންކުރޭ</th>
		          <th class="dhivehi right">ތަރުތީބު</th>
		          <th class="dhivehi right">ގްރޫޕް</th>
		          <th class="dhivehi right">ޕޮއިންޓް</th>
		          <th class="dhivehi right">ކޯޑް</th>
		          <th class="dhivehi right">ނަމްބަރު</th>
						</tr>
						<tr>
		          <td><b-switch v-model="normalPoint.is_active"></b-switch></td>
		          <td ><input class="input" type="number" v-model="normalPoint.order"></td>
		          <td class="dhivehi">
					<div class="select">
						<div class="select">
							<select v-model="normalPoint.normal_category_id">
							  <option v-for="option in normalCategories" v-bind:value="option.id">
							    {{ option.text }}
							  </option>
							</select>
						</div>
					</div>
		          </td>
		          <td class="dhivehi"><input class="input" type="text" v-model="normalPoint.text"></td>
		          <td style="text-align: right;">
								<div class="select">
									<select v-model="normalPoint.code" style="min-width: 10px;max-width: 200px; ">
										<option value="CR">Critical (CR)</option>
										<option value="MJ">Major (MJ)</option>
										<option value="MN">Minor (MN)</option>
									</select>
								</div>
							</td>
		          <td class="dhivehi" style="min-width: 5px;max-width: 10px;"><input class="input" type="text" v-model="normalPoint.no"></td>
						</tr>
						<tr>
		 					  <td colspan="6" style="text-align: center;"><button class="button is-medium is-warning" @click="saveNormalPoint">SAVE</button></td>
						</tr>	
					</table>
				</div>
			</div>
		</div>

		<div v-can="'api.normal-points.index'">
			<div class="columns">
				<div class="column">
					<table class="table is-bordered">
						<tr>
		            <th class="dhivehi right">ބޭނުންކުރޭ</th>
		            <th class="dhivehi right">ތަރުތީބު</th>
		            <th class="dhivehi right">ގްރޫޕް</th>
		            <th class="dhivehi right">ޕޮއިންޓް</th>
		            <th class="dhivehi right">ކޯޑް</th>
		            <th class="dhivehi right">ނަމްބަރު</th>
		            <th class="dhivehi right" v-can="'normal-points.edit'">ބަދަލުގެނޭ</th>
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
		            <td class="dhivehi">{{item.normal_category.text}}</td>
		            <td class="dhivehi">{{item.text}}</td>
		            <td class="dhivehi">{{item.code}}</td>
		            <td class="dhivehi">{{item.no}}</td>
		            <td v-can="'normal-points.edit'">
	   					  <a class="button is-warning" :href="'/normalpoints/' + item.id + '/edit'">
						    <span class="icon is-small">
						      <i class="fa fa-edit"></i>
						    </span>
						  </a>
	<!-- 							<router-link class="button is-warning" v-can="'api.normal-forms.update'" :to="{ name: 'normal-forms.edit', params: { normalFormId: item.id }}">
							    <span class="icon is-small">
							      <i class="fa fa-edit"></i>
							    </span>
	                    </router-link> -->
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
			normalPoint: {
				no: null, 
				code: null, 
				text: null, 
				normal_category_id: null, 
				order: null, 
				is_active: false, 
			},
			normalCategories: []
		}
	},
	mounted() {
		this.getNormalPoints();
		this.getNormalCategories();
	},
	methods: {
		getNormalPoints() {
			if (this.hasPermission('api.normal-points.index')) {
				axios
		  		.get('/api/normalpoints')
					.then(response => {
						this.items = response.data;
					})
					.catch(errors => console.log(errors));
			}
		},
		getNormalCategories() {
			if (this.hasPermission('api.normal-categories.select-options')) {
				axios
		  		.get('/api/normalcategories/forselect')
					.then(response => {
						this.normalCategories = response.data;
					})
					.catch(errors => console.log(errors));
			}
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
}
</script>

<style scoped>
	table td:not([align]), table th:not([align]) {
	text-align: right;
	}
</style>