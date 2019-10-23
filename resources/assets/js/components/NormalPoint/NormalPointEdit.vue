<template>
	<div>
		<div class="columns">
			<div class="column is-fullwidth">
		      <h1 class="title">
		        Edit the Normal Point
		      </h1>
			</div>
		</div>
		<div class="container">
			<div class="columns">
				<div class="column">
					<div class="field is-grouped">
					  <div class="control">
                        <router-link class="button is-info is-medium" v-can="'api.normal-points.index'" :to="{ name: 'normal-points.manage' }">
						    <span class="icon is-small">
						      <i class="fa fa-chevron-left"></i>
						    </span>
						    <span>Back to Normal Points</span>
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
		          	v-model="normalPoint.is_active"
		          	></b-switch></td>
		          <td class="dhivehi">
								<div class="select">
									<select v-model="normalPoint.normal_category_id">
									  <option v-for="option in normalCategories" v-bind:value="option.id">
									    {{ option.text }}
									  </option>
									</select>
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
					</table>
				</div>
			</div>
			<div class="columns">
				<div class="column"></div>
				<div class="column" style="text-align: center;">
					<div class="field is-grouped">
					  <div class="control" v-can="'api.normal-points.update'">
		 					  <button class="button is-large is-warning" @click="updateNormalPoint">
							    <!-- <span class="icon"> -->
							      <!-- <i class="fa fa-save"></i> -->
							      UPDATE
							    <!-- </span> -->
							  </button>
					  </div>
					  <div class="control" v-can="'api.normal-points.show'">
		 					  <button class="button is-large is-info" @click="getNormalPoint">
							    <!-- <span class="icon"> -->
							      <!-- <i class="fa fa-save"></i> -->
							      RESET
							    <!-- </span> -->
							  </button>
					  </div>
					  <div class="control" v-can="'api.normal-points.destroy'">
		 					  <button class="button is-large is-danger" @click="deleteNormalPoint">
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
	props: ['normalPointId'],
    data() {
        return {
        	isActive: false,
	        normalPoint: {},
	        normalCategories: {},
	        form: new Form({})
	    }
    },
    mounted() {
        this.getNormalPoint();
        this.getNormalCategories();
    },
    methods: {
        getNormalPoint() {
        	if (this.hasPermission('api.normal-points.show')) {
	            axios
	              .get('/api/normalpoints/' + this.normalPointId)
	                .then(response => {
	                    this.normalPoint = response.data;
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
        updateNormalPoint() {
            axios
              .patch('/api/normalpoints/' + this.normalPointId, this.normalPoint)
                .then(response => {
                    this.normalPoint = response.data;
                })
                .catch(errors => console.log(errors));
        },
        deleteNormalPoint() {
          if(!confirm("Are you sure you want to delete this?")) { return;}
            axios
              .delete('/api/normalpoints/' + this.normalPointId)
                .then(response => {
                    alert('deleted successfully');
                    this.normalPoint = {};
                })
                .catch(errors => {
                    alert('unable to delete');
                    this.getNormalPoint();
                });
        }
    }
}
</script>