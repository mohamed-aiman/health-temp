<template>
	<div>
		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        Edit the Grading Point
		      </h1>
			</div>
		</div>
		<div class="container">
			<div class="columns">
				<div class="column">
					<div class="field is-grouped">
					  <div class="control">
						<router-link class="button is-info is-medium" v-can="'api.grading-points.index'" :to="{ name: 'grading-points.manage' }">
						    <span class="icon is-small">
						      <i class="fa fa-chevron-left"></i>
						    </span>
						    <span>Back to Grading Points</span>
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
		          <th class=>ބޭނުންކުރޭ</th>
		          <th class="dhivehi" style="text-align: right;">ގްރޫޕް</th>
		          <th class="dhivehi" style="text-align: right;">ޕޮއިންޓް</th>
		          <th class="dhivehi" style="text-align: right;">ކޯޑް</th>
		          <th class="dhivehi" style="text-align: right;">ނަމްބަރު</th>
						</tr>
						<tr>
		          <td><b-switch
		          	v-model="gradingPoint.is_active"
		          	></b-switch></td>
		          <td class="dhivehi">
								<div class="select">
									<select v-model="gradingPoint.grading_category_id">
									  <option v-for="option in gradingCategories" v-bind:value="option.id">
									    {{ option.text }}
									  </option>
									</select>
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
					</table>
				</div>
			</div>
			<div class="columns">
				<div class="column"></div>
				<div class="column" style="text-align: center;">
					<div class="field is-grouped">
					  <div class="control" v-can="'api.grading-points.update'">
		 					  <button class="button is-large is-warning" @click="updateGradingPoint">
							    <!-- <span class="icon"> -->
							      <!-- <i class="fa fa-save"></i> -->
							      UPDATE
							    <!-- </span> -->
							  </button>
					  </div>
					  <div class="control" v-can="'api.grading-points.show'">
		 					  <button class="button is-large is-info" @click="getGradingPoint">
							    <!-- <span class="icon"> -->
							      <!-- <i class="fa fa-save"></i> -->
							      RESET
							    <!-- </span> -->
							  </button>
					  </div>
					  <div class="control" v-can="'api.grading-points.destroy'">
		 					  <button class="button is-large is-danger" @click="deleteGradingPoint">
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
    props:['gradingPointId'],
    data() {
        return {
        	isActive: false,
	        gradingPoint: {},
	        gradingCategories: {},
	        form: new Form({})
	    }
    },
    mounted() {
        this.getGradingPoint();
        this.getGradingCategories();
    },
    methods: {
        getGradingPoint() {
        	if (this.hasPermission('api.grading-points.show')) {
		        axios
              .get('/api/gradingpoints/' + this.gradingPointId)
                .then(response => {
                    this.gradingPoint = response.data;
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
        updateGradingPoint() {
            axios
              .patch('/api/gradingpoints/' + this.gradingPointId, this.gradingPoint)
                .then(response => {
                    this.gradingPoint = response.data;
                })
                .catch(errors => console.log(errors));
        },
        deleteGradingPoint() {
          if(!confirm("Are you sure you want to delete this?")) { return;}
            axios
              .delete('/api/gradingpoints/' + this.gradingPointId)
                .then(response => {
                    alert('deleted successfully');
                    this.gradingPoint = {};
                })
                .catch(errors => {
                    alert('unable to delete');
                    this.getGradingPoint();
                });
        }
    }
}
</script>