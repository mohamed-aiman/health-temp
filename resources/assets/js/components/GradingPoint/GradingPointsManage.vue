<template>
	<div>
		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        Manage Grading Points
		      </h1>
			</div>
		</div>

		<div>
			<div class="columns" v-can="'api.grading-points.store'">
				<div class="column">
					<div class="field is-grouped">
					  <div class="control">
		 					  <button  v-if="!openForm" @click="switchOpenCloseForm" class="button is-success is-medium" >
		 					  	<span>New Grading Point</span>
							    <span class="icon is-small">
							      <i class="fa fa-plus"></i>
							    </span>
		 					  </button>
		 					  <button  v-if="openForm" @click="switchOpenCloseForm" class="button is-warning is-medium" >
		 					  	<span>Close Grading Point Form</span>
							    <span class="icon is-small">
							      <i class="fa fa-close"></i>
							    </span>
		 					  </button>
					  </div>
				  </div>
				</div>
			</div>
		</div>

		<div v-can="'api.grading-points.store'" v-if="openForm">
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
		          <td><b-switch v-model="gradingPoint.is_active"></b-switch></td>
		          <td ><input class="input" type="number" v-model="gradingPoint.order"></td>
		          <td class="dhivehi">
					<div class="select">
						<div class="select">
							<select v-model="gradingPoint.grading_category_id">
							  <option v-for="option in gradingCategories" v-bind:value="option.id">
							    {{ option.text }}
							  </option>
							</select>
						</div>
					</div>
		          </td>
		          <td class="dhivehi"><input class="input" type="text" v-model="gradingPoint.text"></td>
		          <td style="text-align: right;">
								<div class="select">
									<select v-model="gradingPoint.code" style="min-width: 10px;max-width: 200px; ">
										<option value="CR">Critical (CR)</option>
										<option value="MJ">Major (MJ)</option>
										<option value="MN">Minor (MN)</option>
									</select>
								</div>
							</td>
		          <td class="dhivehi" style="min-width: 5px;max-width: 10px;"><input class="input" type="text" v-model="gradingPoint.no"></td>
						</tr>
						<tr>
		 					  <td colspan="6" style="text-align: center;"><button class="button is-medium is-warning" @click="saveGradingPoint">SAVE</button></td>
						</tr>	
					</table>
				</div>
			</div>
		</div>

		<div v-can="'api.grading-points.index'">
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
		            <th class="dhivehi right" v-can="'api.grading-points.update'">ބަދަލުގެނޭ</th>
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
		            <td class="dhivehi">{{item.grading_category.text}}</td>
		            <td class="dhivehi">{{item.text}}</td>
		            <td class="dhivehi">{{item.code}}</td>
		            <td class="dhivehi">{{item.no}}</td>
		            <td v-can="'api.grading-points.update'">
						<router-link class="button is-warning" :to="{ name: 'grading-points.edit', params: { 'gradingPointId': item.id }}">
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
			gradingPoint: {
				no: null, 
				code: null, 
				text: null, 
				grading_category_id: null, 
				order: null, 
				is_active: false, 
			},
			gradingCategories: []
		}
	},
	mounted() {
		this.getGradingPoints();
		this.getGradingCategories();
	},
	methods: {
		getGradingPoints() {
			if (this.hasPermission('api.grading-points.index')) {
				axios
		  		.get('/api/gradingpoints')
					.then(response => {
						this.items = response.data;
					})
					.catch(errors => console.log(errors));
			}
		},
		getGradingCategories() {
			if (this.hasPermission('api.grading-categories.select-options')) {
			axios
	  		.get('/api/gradingcategories/forselect')
				.then(response => {
					this.gradingCategories = response.data;
				})
				.catch(errors => console.log(errors));
			}
		},
		switchOpenCloseForm() {
			this.openForm = (this.openForm) ? false : true;
			this.gradingPoint = {no: null,  code: null,  text: null, grading_category_id: null, order: null, is_active: false};
		},
		saveGradingPoint() {
			if (this.hasPermission('api.grading-points.store')) {
				axios
		  		.post('/api/gradingpoints', this.gradingPoint)
					.then(response => {
						this.switchOpenCloseForm();
						this.getGradingPoints();
					})
					.catch(errors => console.log(errors));	
			}
		}
	}
}
</script>