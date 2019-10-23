<template>
<div v-can="'api.dhivehi-reports.changedStatusToProcessed'">
	<div class="columns no-print" v-if="statusChangeStatus">
        <div class="column">
            <div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
        </div>
    </div>
    <div class="columns no-print">
        <div class="column dhivehi">
            <table class="table">
                <tr>
                    <td class="right">
                        <a class="button is-warning" v-can="'api.dhivehi-reports.changedStatusToProcessed'" @click="processed()">ޕްރޮސެސް ކޮށް ނިމުނީ</a>
                        <a class="button is-warning" v-can="'api.dhivehi-reports.sendBackToEditing'" @click="sendForEditing()">އަލުން ބަދަލު ގެނައުމަށް ފޮނުވާ</a>
	    			    <a class="button is-info" @click="launchPrint()">ޕްރިންޓް</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

	<div>
		<div class="columns dhivehi">
			<div class="column">
				<h3 class="title">ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަން ތަން ބަލާ ފާސްކުރުމުގެ ރިޕޯޓް</h3>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">އިންސްޕެކްޓް ކުރި ބޭނުން:</label>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<div class="columns">
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="purposes[1]">
							  ރަޖިސްޓްރީ ކުރުމަށް
							</label>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="purposes[2]">
							  ރޫޓީން އިންސްޕެކްޝަން
							</label>
						</div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="purposes[3]">
							  ހުއްދަ އާކުރުމަށް
							</label>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="purposes[4]">
							  ސޮފްޓް ޗެކް
							</label>
						</div>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="purposes[5]">
							  ތަނުގެ އެޑްރެސް / މެނޭޖްމެން ބަދަލުވެގެން
							</label>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<label class="checkbox">
							  <input type="checkbox" disabled v-model="purposes[6]">
							  ޝަކުވާއާއި ގުޅިގެން
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>ތަނުގެ ނަމާއި އެޑްރެސް:</td>
						<td colspan="3">{{dhivehiReportForm.place_name_address}}</td>
					</tr>
					<tr>
						<td>ތަނުގެ ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
						<td colspan="3">{{dhivehiReportForm.place_owner_name_address}}</td>
					</tr>
					<tr>
						<td>ގުޅޭން ނަމްބަރ:</td>
						<td>{{dhivehiReportForm.phone}}</td>
						<td>އިންސްޕެކްޓް ކުރެވުނު ތާރީޚާއި ގަޑި:</td>
						<td>{{dhivehiReportForm.time_of_inspection}}</td>
					</tr>
					<tr>
						<td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
						<td>{{dhivehiReportForm.information_provider}}</td>
						<td>ކުރެވުނު އިންސްޕެކްޝަންގެ އަދަދު:</td>
						<td>{{dhivehiReportForm.number_of_inspections}}</td>
					</tr>
				</table>
			</div>
		</div>


		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 1: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ ކްރިޓިކަލް (ވަގުތުން ރަނގަޅު ކުރަންޖެހޭ) މައްސަލަތައް:</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in criticalItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 2: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ މޭޖަރ (ދެވިފައިވާ މުއްދަތުގައި ރަނގަޅުކުރަން ޖެހޭ) މައްސަލަތައް:</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in majorItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 3: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ އެހެނިހެން ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޗަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in minorItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<label class="label">ސެކްޝަން 5: ދުންފަތް ކޮންޓްރޯލް ކުރުމާ ބެހޭ ޤާނޫން (15/2010) ދަށުން ކުރެވުނު އިންސްޕެކްޝަން ގައި ފާހަގަ ކުރެވިފައިވާ ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޝަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
			</div>
		</div>
		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th class="right">#</th>
						<th class="right">ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</th>
						<th class="right">އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</th>
					</tr>
					<tr v-for="item in tobaccoItems">
						<td>{{item.no}}</td>
						<td>{{item.violation}}</td>
						<td>{{item.recommendation}}</td>
					</tr>
					<tr rowspan="2">
						<td colspan="3">ޤަވާޢިދާއި ޚިލާފް ވުމުން ކުރެވުނު ޖޫރިމަނާ ކުރެވުނު (ޖޫރިމަނާ ސްލިޕްގެ/ސްލޮޕްތަކުގެ ނަމްބަރު):</td>
					</tr>
				</table>
			</div>
		</div>


<!-- 		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<td>ކެޓަގަރީ</td>
						<td>ރަނގަޅު ކޮށްފައިވާ އަދަދު</td>
						<td>ރަނގަޅު ކުރަންޖެހޭ އަދަދު</td>
						<td>އަދަދު NA</td>
					</tr>
					<tr>
						<td>ކްރިޓިކަލް ގެ މުޅި ޖުމްލަ 10</td>
						<td>{{dhivehiReportForm.critical_totals.fixed}}</td>
						<td>{{dhivehiReportForm.critical_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.critical_totals.total}}</td>
					</tr>
					<tr>
						<td>މޭޖަރ ގެ މުޅި ޖުމްލަ 43</td>
						<td>{{dhivehiReportForm.major_totals.fixed}}</td>
						<td>{{dhivehiReportForm.major_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.major_totals.total}}</td>
					</tr>
					<tr>
						<td>މައިނަ ގެ މުޅި ޖުމްލަ</td>
						<td>{{dhivehiReportForm.minor_totals.fixed}}</td>
						<td>{{dhivehiReportForm.minor_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.minor_totals.total}}</td>
					</tr>
					<tr>
						<td>ދުންފަތުގެ އިސްޓިޢުމާލް ކުރުން 14</td>
						<td>{{dhivehiReportForm.tobacco_totals.fixed}}</td>
						<td>{{dhivehiReportForm.tobacco_totals.to_be_fixed}}</td>
						<td>{{dhivehiReportForm.tobacco_totals.total}}</td>
					</tr>
				</table>
			</div>
		</div> -->

		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr ><th style="direction: rtl;text-align: right;">އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް</th></tr>
					<tr><td style="text-decoration: underline;">(ހ) ކާބޯތަކެތީގެ ޙިދުމަތް ދިނުމުގައު ހުންނަންޖެހޭ ސާފުތާހިރުކަމުގެ މިންގަނޑުތައް ބަޔާން ކުރާ ގަވާޢިދު (ގަވާއިދު ނަންބަރު: <span style="direction: ltr;">2014/R-380</span>) އެއްގިތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
					<tr><td>1. ސެކްސަން 1 ގައި ބަޔާން ކުރެވިފައިވާ ކަންތައްތައް ވަގުތުން ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_1"></td></tr>
					<tr><td>2. ސެކްސަން 2 ގައި ބަޔާންކުރެވިފައިވާ ކަންތައް<input type="number" disabled v-model="dhivehiReportForm.food_conclusion_2_days"> ދުވަހުގެ ތެރޭގައި ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_2"></td></tr>
					<tr><td>3. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_3">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" disabled v-model="dhivehiReportForm.food_conclusion_3_date"></td></tr>
					<tr><td>4. ތަން ބަންދުކުރުމަށް ފެނޭ &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_4"></td></tr>
					<tr><td>5. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_5"></td></tr>
					<tr><td>6. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" disabled v-model="dhivehiReportForm.food_conclusion_6_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.food_conclusion_6"></td></tr>
					<tr><td style="text-decoration: underline;">(ށ)‫ދުންފަތ‬ ‫ކޮންޓްރޯލ‬ ‫ކުރުމ‬ާ ބެހޭ ޤާނޫން (<span style="direction: ltr;">15/2010</span>) އާއި އެއްގިތްވާ ގޮތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
					<tr><td>1. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tobacco_conclusion_1">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" disabled v-model="dhivehiReportForm.tobacco_conclusion_3_date"></td></tr>
					<tr><td>2. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tobacco_conclusion_2"></td></tr>
					<tr><td>3. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" disabled v-model="dhivehiReportForm.tobacco_conclusion_3_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tobacco_conclusion_3"></td></tr>
				</table>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th colspan="4" style="direction: rtl;text-align: right;">‫ސެކްޝަން ހިންގުމާއި ހަވާލުވެ ހުރިފަރާތުގެ ނިންމުން</th>
					</tr>
					<tr>
						<td  colspan="2" style="text-decoration: underline;">‫ޕަބްލިކް‬ ‫‫ހެލްތު‬ އިންސްޕެކްޓޮރޭޓ‬ް</td>
						<td  colspan="2" style="text-decoration: underline;">‫‫‫ޓޮބޭކޯ‬ ‫ޕްރިވެންޝަން‬ ‫އެންޑް‬ ‫ކޮންޓްރޯލް‬ ސެކްޝަން‬</td>
					</tr>
					<tr>
						<td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_1"></td>
						<td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_1"></td>
					</tr>
					<tr>
						<td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_2"></td>
						<td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_2"></td>
					</tr>
					<tr>
						<td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" disabled v-model="dhivehiReportForm.phi_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_3"></td>
						<td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_3"></td>
					</tr>
					<tr>
						<td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.phi_head_conclusion_4"></td>
						<td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" disabled v-model="dhivehiReportForm.tpcs_head_conclusion_4"></td>
					</tr>
					<tr>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.phi_head_name}}</td>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.tpcs_head_name}}</td>
					</tr>
					<tr>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.phi_head_sign}}</td>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.tpcs_head_sign}}</td>
					</tr>
					<tr>
						<td>ތާރީޚް</td>
						<td>{{dhivehiReportForm.phi_head_date}}</td>
						<td>ތާރީޚް</td>
						<td>{{dhivehiReportForm.tpcs_head_date}}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="columns dhivehi">
			<div class="column">
				<table class="table is-bordered">
					<tr>
						<th colspan="2" style="direction: rtl;text-align: right;">‫‫‪ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަނުގެ ފަރާތުން</th>
						<th colspan="2" style="direction: rtl;text-align: right;">ހެލްތު ޕްރޮޓެކްޝަން އެޖެންސީގެ ފަރާތުން</th>
					</tr>
					<tr>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.from_business_name}}</td>
						<td>ނަން:</td>
						<td>{{dhivehiReportForm.from_hpa_name}}</td>
					</tr>
					<tr>
						<td>މަޤާމް:</td>
						<td>{{dhivehiReportForm.from_business_position}}</td>
						<td>މަޤާމް:</td>
						<td>{{dhivehiReportForm.from_hpa_position}}</td>
					</tr>
					<tr>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.from_business_sign}}</td>
						<td>ސޮއި:</td>
						<td>{{dhivehiReportForm.from_hpa_sign}}</td>
					</tr>
					<tr>
						<td>ތާރީޚް:</td>
						<td>{{dhivehiReportForm.from_business_date}}</td>
						<td>ތާރީޚް:</td>
						<td>{{dhivehiReportForm.from_hpa_date}}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</template>

<script>
import Grid from '../../Grid';
export default {
	props: ['reportId'],
    data() {
        return {
        	purposes:[],
        	statusChangeStatus: null,
	        statusChangeColor: 'is-success',
	        criticalGrid: new Grid(['no', 'violation', 'recommendation']),
	        criticalItems: [],
	        criticalSelectedItem: null,
	        criticalNewItem: null,
	        majorGrid: new Grid(['no', 'violation', 'recommendation']),
	        majorItems: [],
	        majorSelectedItem: null,
	        majorNewItem: null,
	        minorGrid: new Grid(['no', 'violation', 'recommendation']),
	        minorItems: [],
	        minorSelectedItem: null,
	        minorNewItem: null,
	        tobaccoGrid: new Grid(['no', 'violation', 'recommendation']),
	        tobaccoItems: [],
	        tobaccoSelectedItem: null,
	        tobaccoNewItem: null,
	        // dhivehiReportForm: new Form({
	        // }),
	        dhivehiReportForm: {
	            purpose: null,

	            place_name_address: null,
	            place_owner_name_address: null,
	            phone: null,
	            information_provider: null,
	            number_of_inspections: null,
	            time_of_inspection: null,
	            
	            critical: null,
	            major: null,
	            minor: null,
	            tobacco: null,
	            fine_slip_numbers: null,

	            critical_totals: {
	                fixed: null,
	                to_be_fixed: null,
	                total: null
	            },
	            major_totals: {
	                fixed: null,
	                to_be_fixed: null,
	                total: null
	            },
	            minor_totals: {
	                fixed: null,
	                to_be_fixed: null,
	                total: null
	            },
	            tobacco_totals: {
	                fixed: null,
	                to_be_fixed: null,
	                total: null
	            },

	            food_conclusion_1: false,
	            food_conclusion_2: false,
	            food_conclusion_3: false,
	            food_conclusion_3_date: null,
	            food_conclusion_4: false,
	            food_conclusion_5: false,
	            food_conclusion_6: false,
	            food_conclusion_6_amount: null,

	            tobacco_conclusion_1: false,
	            tobacco_conclusion_1_date: null,
	            tobacco_conclusion_2: false,
	            tobacco_conclusion_3: false,
	            tobacco_conclusion_3_amount: null,

	            phi_head_conclusion_1: false,
	            phi_head_conclusion_2: false,
	            phi_head_conclusion_3: false,
	            phi_head_conclusion_3_date: null,
	            phi_head_conclusion_4: false,
	            phi_head_name: null,
	            phi_head_sign: null,
	            phi_head_date: null,

	            tpcs_head_conclusion_1: false,
	            tpcs_head_conclusion_2: false,
	            tpcs_head_conclusion_3: false,
	            tpcs_head_conclusion_3_date: null,
	            tpcs_head_conclusion_4: false,
	            tpcs_head_name: null,
	            tpcs_head_sign: null,
	            tpcs_head_date: null,

	            from_business_name: null,
	            from_business_position: null,
	            from_business_sign: null,
	            from_business_date: null,

	            from_hpa_name: null,
	            from_hpa_position: null,
	            from_hpa_sign: null,
	            from_hpa_date: null,

	            // areas: null,
	            // comments: null,
	            // inspectionMember1Name: null,
	            // inspectionMember1Designation: null,
	            // inspectionMember1Date: null,
	            // inspectionMember2Name: null,
	            // inspectionMember2Designation: null,
	            // inspectionMember2Date: null,
	            // verifiedByName: null,
	            // verifiedByDesignation: null,
	            // verifiedByDate: null,
	        }
	    }
    },
    mounted() {
        this.init();
    },
    watch: {
    	'dhivehiReportForm.purpose': function() {
    		for(var i = 1; i<=6; i++) {
    			this.purposes[i] = this.isPurpose(i);
    		}
    	}
    },
    methods: {
        /**general methods start**/
        init() {
            this.getReport();
        },
        getReport() {
        	if (this.hasPermission('api.dhivehi-reports.show')) {
	            axios.get('/api/dhivehi/reports/' + this.reportId)
	            .then(response => {
	                this.setDhivehiReportFormFromResponse(response.data);
	            })
	            .catch(errors => {
	                console.log('errors', errors);
	            }); 
	       	}
        },
		isPurpose(value) {
			return (parseInt(this.dhivehiReportForm.purpose) == value);
		},
        setDhivehiReportFormFromResponse(data) {
            this.dhivehiReportForm.purpose = data.purpose;

            this.dhivehiReportForm.place_name_address = data.place_name_address;
            this.dhivehiReportForm.place_owner_name_address = data.place_owner_name_address;
            this.dhivehiReportForm.phone = data.phone;
            this.dhivehiReportForm.information_provider = data.information_provider;
            this.dhivehiReportForm.time_of_inspection = data.time_of_inspection;
            this.dhivehiReportForm.number_of_inspections = data.number_of_inspections;

            this.setCriticalItems(data.critical);
            this.setMajorItems(data.major);
            this.setMinorItems(data.minor);
            this.setTobaccoItems(data.tobacco);
            
            this.dhivehiReportForm.fine_slip_numbers = data.fine_slip_numbers;

            this.setCriticalTotals(data.critical_totals);
            this.setMajorTotals(data.major_totals);
            this.setMinorTotals(data.minor_totals);
            this.setTobaccoTotals(data.tobacco_totals);

            this.dhivehiReportForm.food_conclusion_1 = data.food_conclusion_1;
            this.dhivehiReportForm.food_conclusion_2 = data.food_conclusion_2;
            this.dhivehiReportForm.food_conclusion_3 = data.food_conclusion_3;
            this.dhivehiReportForm.food_conclusion_3_date = data.food_conclusion_3_date;
            this.dhivehiReportForm.food_conclusion_4 = data.food_conclusion_4;
            this.dhivehiReportForm.food_conclusion_5 = data.food_conclusion_5;
            this.dhivehiReportForm.food_conclusion_6 = data.food_conclusion_6;
            this.dhivehiReportForm.food_conclusion_6_amount = data.food_conclusion_6_amount;
            this.dhivehiReportForm.tobacco_conclusion_1 = data.tobacco_conclusion_1;
            this.dhivehiReportForm.tobacco_conclusion_1_date = data.tobacco_conclusion_1_date;
            this.dhivehiReportForm.tobacco_conclusion_2 = data.tobacco_conclusion_2;
            this.dhivehiReportForm.tobacco_conclusion_3 = data.tobacco_conclusion_3;
            this.dhivehiReportForm.tobacco_conclusion_3_amount = data.tobacco_conclusion_3_amount;
            this.dhivehiReportForm.phi_head_conclusion_1 = data.phi_head_conclusion_1;
            this.dhivehiReportForm.phi_head_conclusion_2 = data.phi_head_conclusion_2;
            this.dhivehiReportForm.phi_head_conclusion_3 = data.phi_head_conclusion_3;
            this.dhivehiReportForm.phi_head_conclusion_3_date = data.phi_head_conclusion_3_date;
            this.dhivehiReportForm.phi_head_conclusion_4 = data.phi_head_conclusion_4;
            this.dhivehiReportForm.phi_head_name = data.phi_head_name;
            this.dhivehiReportForm.phi_head_sign = data.phi_head_sign;
            this.dhivehiReportForm.phi_head_date = data.phi_head_date;
            this.dhivehiReportForm.tpcs_head_conclusion_1 = data.tpcs_head_conclusion_1;
            this.dhivehiReportForm.tpcs_head_conclusion_2 = data.tpcs_head_conclusion_2;
            this.dhivehiReportForm.tpcs_head_conclusion_3 = data.tpcs_head_conclusion_3;
            this.dhivehiReportForm.tpcs_head_conclusion_3_date = data.tpcs_head_conclusion_3_date;
            this.dhivehiReportForm.tpcs_head_conclusion_4 = data.tpcs_head_conclusion_4;
            this.dhivehiReportForm.tpcs_head_name = data.tpcs_head_name;
            this.dhivehiReportForm.tpcs_head_sign = data.tpcs_head_sign;
            this.dhivehiReportForm.tpcs_head_date = data.tpcs_head_date;
            this.dhivehiReportForm.from_business_name = data.from_business_name;
            this.dhivehiReportForm.from_business_position = data.from_business_position;
            this.dhivehiReportForm.from_business_sign = data.from_business_sign;
            this.dhivehiReportForm.from_business_date = data.from_business_date;
            this.dhivehiReportForm.from_hpa_name = data.from_hpa_name;
            this.dhivehiReportForm.from_hpa_position = data.from_hpa_position;
            this.dhivehiReportForm.from_hpa_sign = data.from_hpa_sign;
            this.dhivehiReportForm.from_hpa_date = data.from_hpa_date;

            // this.dhivehiReportForm.areas = data.areas;
            // this.dhivehiReportForm.comments = data.comments;
            // this.dhivehiReportForm.inspectionMember1Name = data.inspectionMember1Name;
            // this.dhivehiReportForm.inspectionMember1Designation = data.inspectionMember1Designation;
            // this.dhivehiReportForm.inspectionMember1Date = data.inspectionMember1Date;
            // this.dhivehiReportForm.inspectionMember2Name = data.inspectionMember2Name;
            // this.dhivehiReportForm.inspectionMember2Designation = data.inspectionMember2Designation;
            // this.dhivehiReportForm.inspectionMember2Date = data.inspectionMember2Date;
            // this.dhivehiReportForm.verifiedByName = data.verifiedByName;
            // this.dhivehiReportForm.verifiedByDesignation = data.verifiedByDesignation;
            // this.dhivehiReportForm.verifiedByDate = data.verifiedByDate;
        },

        prepareDhivehiReportForm() {
            this.updateDhivehiFormCritical();
            this.updateDhivehiFormMajor();
            this.updateDhivehiFormMinor();
            this.updateDhivehiFormTobacco();
        },
        launchPrint() {
            window.print(); 
        },
        sendForEditing() {
        	if (this.hasPermission('api.dhivehi-reports.sendBackToEditing')) {
	            axios
	            .patch("/api/dhivehi/reports/" + this.reportId  + "/status/draft")
	            .then(response => {
	                this.statusChangeColor = 'is-success';
	                this.statusChangeStatus = 'status changed successfully.'
	            })
	            .catch(error => {
	                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
	                this.statusChangeColor = 'is-danger';
	            });
	       	}
        },
        processed() {
        	if (this.hasPermission('api.dhivehi-reports.changedStatusToProcessed')) {
	            axios
	            .patch("/api/dhivehi/reports/" + this.reportId  + "/status/processed")
	            .then(response => {
	                this.statusChangeColor = 'is-success';
	                this.statusChangeStatus = 'status changed successfully.'
	            })
	            .catch(error => {
	                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
	                this.statusChangeColor = 'is-danger';
	            });
	       	}
        },

        /**
         * start of saving other fields
         */
        /**
         * set totals
         */
        setCriticalTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.critical_totals, data);
        },

        setMajorTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.major_totals, data);
        },

        setMinorTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.minor_totals, data);
        },

        setTobaccoTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.tobacco_totals, data);
        },

        setTotals(object, data) {
            object.fixed = data.fixed;
            object.to_be_fixed = data.to_be_fixed;
            object.total = data.total;
        },

        
        /**
         * Start of Critical, Major, Minor, Tobacco Store, Update and Delete
         * 
         * critical start
         */
        setCriticalItems(data = null) {
            if (data) {
                this.criticalGrid.setItems(data);
            }

            this.criticalItems =  this.criticalGrid.getItems();
            this.criticalSelectedItem = null;
        },
        criticalAddItem() {
            this.criticalSelectedItem = this.deselectCriticalSelectedItem();
            this.criticalNewItem = this.criticalGrid.newItem();
        },
        criticalStoreItem() {
            this.criticalGrid.add(this.criticalNewItem);
            this.criticalNewItem = null;
        },
        criticalRemoveItem(index) {
            this.criticalGrid.remove(index);
        },
        criticalEditItem(index) {
            this.criticalNewItem = null;
            this.criticalSelectItem(index);
        },
        criticalSelectItem(index) {
            this.criticalSelectedItem = {...this.criticalGrid.select(index)};
        },
        deselectCriticalSelectedItem() {
            this.criticalSelectedItem = this.criticalGrid.deSelect();
        },
        criticalUpdateItem() {
            this.criticalGrid.update(this.criticalSelectedItem);
            this.setCriticalItems();
        },
        updateDhivehiFormCritical() {
            this.dhivehiReportForm.critical = this.criticalGrid.getItems();
        },
        /**
         * major start
         */
        setMajorItems(data = null) {
            if (data) {
                this.majorGrid.setItems(data);
            }

            this.majorItems =  this.majorGrid.getItems();
            this.majorSelectedItem = null;
        },
        majorAddItem() {
            this.majorSelectedItem = this.deselectMajorSelectedItem();
            this.majorNewItem = this.majorGrid.newItem();
        },
        majorStoreItem() {
            this.majorGrid.add(this.majorNewItem);
            this.majorNewItem = null;
        },
        majorRemoveItem(index) {
            this.majorGrid.remove(index);
        },
        majorEditItem(index) {
            this.majorNewItem = null;
            this.majorSelectItem(index);
        },
        majorSelectItem(index) {
            this.majorSelectedItem = {...this.majorGrid.select(index)};
        },
        deselectMajorSelectedItem() {
            this.majorSelectedItem = this.majorGrid.deSelect();
        },
        majorUpdateItem() {
            this.majorGrid.update(this.majorSelectedItem);
            this.setMajorItems();
        },
        updateDhivehiFormMajor() {
            this.dhivehiReportForm.major = this.majorGrid.getItems();
        },
        /**
         * minor start
         */
        setMinorItems(data = null) {
            if (data) {
                this.minorGrid.setItems(data);
            }

            this.minorItems =  this.minorGrid.getItems();
            this.minorSelectedItem = null;
        },
        minorAddItem() {
            this.minorSelectedItem = this.deselectMinorSelectedItem();
            this.minorNewItem = this.minorGrid.newItem();
        },
        minorStoreItem() {
            this.minorGrid.add(this.minorNewItem);
            this.minorNewItem = null;
        },
        minorRemoveItem(index) {
            this.minorGrid.remove(index);
        },
        minorEditItem(index) {
            this.minorNewItem = null;
            this.minorSelectItem(index);
        },
        minorSelectItem(index) {
            this.minorSelectedItem = {...this.minorGrid.select(index)};
        },
        deselectMinorSelectedItem() {
            this.minorSelectedItem = this.minorGrid.deSelect();
        },
        minorUpdateItem() {
            this.minorGrid.update(this.minorSelectedItem);
            this.setMinorItems();
        },
        updateDhivehiFormMinor() {
            this.dhivehiReportForm.minor = this.minorGrid.getItems();
        },
        /**
         * tobacco start
         */
        setTobaccoItems(data = null) {
            if (data) {
                this.tobaccoGrid.setItems(data);
            }

            this.tobaccoItems =  this.tobaccoGrid.getItems();
            this.tobaccoSelectedItem = null;
        },
        tobaccoAddItem() {
            this.tobaccoSelectedItem = this.deselectTobaccoSelectedItem();
            this.tobaccoNewItem = this.tobaccoGrid.newItem();
        },
        tobaccoStoreItem() {
            this.tobaccoGrid.add(this.tobaccoNewItem);
            this.tobaccoNewItem = null;
        },
        tobaccoRemoveItem(index) {
            this.tobaccoGrid.remove(index);
        },
        tobaccoEditItem(index) {
            this.tobaccoNewItem = null;
            this.tobaccoSelectItem(index);
        },
        tobaccoSelectItem(index) {
            this.tobaccoSelectedItem = {...this.tobaccoGrid.select(index)};
        },
        deselectTobaccoSelectedItem() {
            this.tobaccoSelectedItem = this.tobaccoGrid.deSelect();
        },
        tobaccoUpdateItem() {
            this.tobaccoGrid.update(this.tobaccoSelectedItem);
            this.setTobaccoItems();
        },
        updateDhivehiFormTobacco() {
            this.dhivehiReportForm.tobacco = this.tobaccoGrid.getItems();
        }
        /**
         * End of Critical, Major, Minor, Tobacco Store, Update and Delete
         * used general methods saveDhivehiReportForm and prepareDhivehiReportForm 
         */
        

    }
}
</script>