<template>
<div v-can="'api.grading-forms.show'">
	<div class="columns no-print">
		<div class="column">
			<table class="table">
				<tr>
					<td class="right" v-can="'api.grading-forms.update'">
  						<router-link class="button is-success" :to="{ name: 'grading-inspections.gradingforms.edit', params: { inspectionId: inspectionId }}">
							Edit Form
						</router-link>
			    	</td>
		  		</tr>
			</table>
		</div>
	</div>

	<div>
		<div class="columns">
	      <div class="column is-fullwidth dhivehi">
	          <h1 class="title">
	            ކާބޯތަކެތީގެ ޚިދުމަތްދޭތަންތަން ބަލާ ފާސްކުރާ ފޯމް
	          </h1>
	      </div>
	    </div>
		<div class="columns">
			<div class="column dhivehi">
				<table class="table">
					<tr><td colspan="4"><b>ތަނާއި ބެހޭ މަޢުލޫމާތު:</b></td></tr>
					<tr>
						<td>ތަނުގެ ނަން</td>
						<td>{{gradingForm.place_name}}</td>
						<td>ކާބޯތަކެތީގެ ރެޖިސްޓްރޭޝަން ނަމްބަރު:</td>
						<td>{{gradingForm.food_registration_no}}</td>
					</tr>
					<tr>
						<td>ތަން ހިންގާ ފަރާތް:</td>
						<td>{{gradingForm.owner}}</td>
						<td>ހުއްދައިގެ މުއްދަތު</td>
						<td>{{gradingForm.permit_limit}}</td>
					</tr>
					<tr>
						<td>ގުޅޭނެ ނަމްބަރ:</td>
						<td>{{gradingForm.phone}}</td>
						<td>ތާރީޚް:</td>
						<td>{{gradingForm.inspection_date}}</td>
					</tr>
					<tr>
						<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
						<td colspan="4">{{gradingForm.information_provider}}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns">
			<div class="column dhivehi">
				<table class="table">
					<tr><td colspan="8"><b>ބަލާ ފާސް ކުރާ ސަބަބު:</b></td></tr>
					<tr>
						<td>ގްރޭޑް ކުރުމާއި ގުޅިގެން</td>
						<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.grading"></td>
						<td>ހުއްދަ އާކުރުމާ ގުޅިގެން</td>
						<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.license_renewal"></td>
						<td>ޝަކުވާއާއި ގުޅިގެން</td>
						<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.complaint"></td>
						<td>ކޮމްޕްލިއެންސީ އޯޑިޓް</td>
						<td><input type="checkbox" onclick="this.checked=!this.checked;" class="checkbox" v-model="reasons.compliance_audit"></td>
					</tr>
					<tr>
						<td><b>ކޯޑް:</b></td>
						<td>މައިނަރ [MN]</td>
						<td>މޭޖަރ [MJ]</td>
						<td>ކްރިޓިކަލް [CR]</td>
						<td><b>ބަލަން ނުޖެހޭ: </b>[NA]</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns">
			<div class="column dhivehi">
				<table class="table">
							<tr>
								<td><b>#</b></td>
								<td><b>ފުރިހަމަވެފައި</b></td>
								<td><b>(NA) ބަލަން ނުޖެހޭ</b></td>
								<td><b>ކޯޑް</b></td>
								<td><b>މިންގަނޑު</b></td>
							</tr>
					<template v-for="category in categorizedFormPoints">
							<tr>
								<td colspan="5"><b>{{category[0].category}}</b></td>
							</tr>
							<template v-for="item in category" >
							<tr  v-bind:style="{ backgroundColor: rowColor(item) }">
								<td>{{item.no}}</td>
								<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.value"></td>
								<td><input type="checkbox" onclick="this.checked=!this.checked;" v-model="item.not_applicable"></td>
								<td>{{item.code}}</td>
								<td>{{item.text}}</td>
							</tr>
							</template>
					</template>
				</table>
			</div>
		</div>

        <div class="columns dhivehi">
            <div class="column">
                <table class="table is-bordered">
					<tr>
						<td colspan="5"><b>ދަރަޖަކުރުން</b></td>
					</tr>
                    <tr>
                        <td>ކެޓަގަރީ</td>
                        <td>ޖުމްލަ އަދަދު</td>
                        <td>ރަނގަޅު ކޮށްފައިވާ އަދަދު</td>
                        <td>ރަނގަޅު ކުރަންޖެހޭ އަދަދު</td>
                        <td>އަދަދު NA</td>
                    </tr>
                    <tr>
                        <td >ކްރިޓިކަލް ގެ މުޅި ޖުމްލަ </td>
                        <td>{{(gradingCalculated.counts.total.CR) ? gradingCalculated.counts.total.CR : 0 }}</td>
                        <td>{{(gradingCalculated.counts.satisfied.CR) ? gradingCalculated.counts.satisfied.CR : 0 }}</td>
                        <td>{{(gradingCalculated.counts.not_satisfied.CR) ? gradingCalculated.counts.not_satisfied.CR : 0 }}</td>
                        <td>{{(gradingCalculated.counts.not_applicable.CR) ? gradingCalculated.counts.not_applicable.CR : 0 }}</td>
                    </tr>
                    <tr>
                        <td>މޭޖަރ ގެ މުޅި ޖުމްލަ </td>
                        <td>{{(gradingCalculated.counts.total.MJ) ? gradingCalculated.counts.total.MJ : 0 }}</td>
                        <td>{{(gradingCalculated.counts.satisfied.MJ) ? gradingCalculated.counts.satisfied.MJ : 0 }}</td>
                        <td>{{(gradingCalculated.counts.not_satisfied.MJ) ? gradingCalculated.counts.not_satisfied.MJ : 0 }}</td>
                        <td>{{(gradingCalculated.counts.not_applicable.MJ) ? gradingCalculated.counts.not_applicable.MJ : 0 }}</td>
                    </tr>
                    <tr>
                        <td>މައިނަރ ގެ މުޅި ޖުމްލަ</td>
                        <td>{{(gradingCalculated.counts.total.MN) ? gradingCalculated.counts.total.MN : 0 }}</td>
                        <td>{{(gradingCalculated.counts.satisfied.MN) ? gradingCalculated.counts.satisfied.MN : 0 }}</td>
                        <td>{{(gradingCalculated.counts.not_satisfied.MN) ? gradingCalculated.counts.not_satisfied.MN : 0 }}</td>
                        <td>{{(gradingCalculated.counts.not_applicable.MN) ? gradingCalculated.counts.not_applicable.MN : 0 }}</td>
                    </tr>
                    <tr>
                        <td>ދަރަޖަ</td>
                        <td colspan="5" v-if="gradingCalculated.grade == 'A'" style="background-color: green;">A</td>
                        <td colspan="5" v-if="gradingCalculated.grade == 'B'" style="background-color: purple;">B</td>
                        <td colspan="5" v-if="gradingCalculated.grade == 'C'" style="background-color: yellow;">C</td>
                        <td colspan="5" v-if="gradingCalculated.grade == 'FAIL'" style="background-color: orange;">ގްރޭޑަށް ނުފެތޭ</td>
                    </tr>
                </table>
            </div>
        </div>


		<div class="columns dhivehi no-print">
			<div class="column" style="text-align: center;"><button class="is-info button is-large" @click="launchPrint()">ޕްރިންޓް</button></div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	props: ['inspectionId'],
	data() {
        return {
        	gradingFormId: null,
        	reasons: {
				'grading': false,
				'license_renewal': false,
				'complaint': false,
				'compliance_audit': false
        	},
	        gradingForm: {},
	        categorizedFormPoints: [],
	        gradingCalculated: {
	        	counts: {
	        		total: {},
	        		not_satisfied:{},
	        		satisfied: {},
	        		not_applicable: {}
	        	},
	        	grade: {}
	        }
	    }
    },
    mounted() {
        this.getGradingForm();
    },
    watch: {
    	'gradingForm.reason': function() {
			Object.keys(this.reasons).forEach(key => {
				this.reasons[key] = this.isReason(key);
			});
    	},
    	gradingFormId: function() {
    		this.getGradingFormPoints();
    		this.getGradingsCalculated();
    	}
    },
    methods: {
        isReason(reason) {
            return (this.gradingForm.reason == reason) ? true : false;
        },
        getGradingForm() {
        	if (this.hasPermission('api.grading-inspections.gradingforms.show')) {
            	axios
            	.get('/api/gradinginspections/' + this.inspectionId + '/gradingforms')
                .then(response => {
                    this.gradingForm = response.data;
                	this.gradingFormId = this.gradingForm.id;
                })
                .catch(errors => console.log(errors));
            }
        },
        getGradingFormPoints() {
        	if (this.hasPermission('api.grading-forms.points')) {
	            axios
	              .get('/api/gradingforms/' + this.gradingFormId + '/points')
	                .then(response => {
	                    this.categorizedFormPoints = response.data;
	                })
	                .catch(errors => console.log(errors));
	        }
        },
        getGradingsCalculated() {
        	if (this.hasPermission('api.grading-forms.gradings')) {
        	axios
              .get('/api/gradingforms/' + this.gradingFormId + '/gradings')
                .then(response => {
                    this.gradingCalculated = response.data;
                })
                .catch(errors => console.log(errors));
            }
        },
        rowColor(point) {
            switch(point.code) {
              case 'CR':
                    return '#f29696';
                break;
              case 'MJ':
                    return '#f2c196';
                break;
              case 'MN':
                    return '#95f1ca';
                break;
              default:
                    return '#95d0f0';
            }
        },
        launchPrint() {
            window.print();
        }
    }
}
</script>