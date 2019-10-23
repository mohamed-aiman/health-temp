<template>
<div v-can="'api.applications.store'">
	<dhivehi-form-heading>ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް</dhivehi-form-heading>
	
	<div class="columns dhivehi">
		<div class="column">
			<label class="label">1 - ހުއްދައިގެ ބާވަތް</label>
		</div>
	</div>
	<div class="columns dhivehi box">
		<div class="column">
			<div class="field">
			  <div class="control">
				<div class="select">
				  <select v-model="form._1tobaccoOrFood">
				    <option value="1">ދުންފަތް</option>
				    <option value="2">ކާބޯތަކެތި</option>
				  </select>
				</div>
			  </div>
			</div>
		</div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column">
			<div class="field" v-if="form._1tobaccoOrFood === '2'">
			  <div class="control">
					<div class="select">
					  <select v-model="form._1applicationType">
					    <option value="1">ތަން ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="2">ހުއްދަ އާކުރުމަށް</option>
					  </select>
					</div>
			  </div>
			</div>
		</div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column"></div>
		<div class="column">
			<div class="field" v-if="form._1tobaccoOrFood === '2'">
			  <div class="control" v-if="form._1toRegisterPlace">
					<div class="select">
					  <select v-model="form._1registerPlace">
					    <option value="1">އަލަށް ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="2">ތަނުގެ ނަން ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="3">ތަން ހިންގާ ފަރާތް ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</option>
					    <option value="4">ތަނުގެ އެޑްރެސް ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</option>
					  </select>
					</div>
			  </div>
			  <div class="control" v-if="form._1toRenewLicense">
					<div class="select">
					  <select v-model="form._1renewLicense">
					    <option value="1">ހުއްދައިގެ މުއްދަތު ހަމަވެގެން</option>
					    <option value="2">ހުއްދަ ގެއްލިގެން އާކުރުމަށް</option>
					    <option value="3">ހުއްދަ ހަލާކުވެގެން އާކުރުމަށް</option>
					  </select>
					</div>
			  </div>
			</div>
		</div>
	</div>
	<br>
	<div class="columns dhivehi box">
		<div class="column">
			<div class="field">
			  <label class="label">ރަޖިސްޓްރޭސަން ނަމްބަރ</label>
			  <div class="control">
					<input class="input dhivehi" type="text" v-model="form._1registrationNumber">
			  </div>
			</div>
		</div>
		<div class="column">
			<div class="field">
			  <label class="label">ހުއްދަ ބޭނުންވާ ބަސް</label>
			  <div class="control pull-right">
					<label class="checkbox">
					  <input type="checkbox" v-model="form._1wantLicenseIndhivehi">
					  ދިވެހި
					</label>
					<label class="checkbox">
					  <input type="checkbox" v-model="form._1wantLicenseInenglish">
					  އިނގިރޭސި
					</label>
			  </div>
			</div>
		</div>
		<div class="column">
			<div class="field">
			  <label class="label">ތާރީޚް</label>
			  <div class="control">
					<input class="input" type="text" v-model="form._1date">
			  </div>
			</div>
		</div>
	</div>


	<div class="columns dhivehi">
		<div class="column">
			<label class="label">2 - ވިޔަފާރި ރަޖިސްޓްރީ ކުރެވިފައިވާ ފަރާތުގެ މަޢުލޫމާތު:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <label class="label">ނަން</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._2name">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">އެޑްރެސް (އަތޮޅާއި ރަށް):</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._2address">
					  </div>
					</div>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">އައިޑީކާޑު ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input ltr" type="text" v-model="form._2idNo" placeholder="A123456">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ފޯން ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._2phone" placeholder="9876543">
					  </div>
					</div>
		    </div>
			</div>
		</div>
	</div>

	<div class="columns dhivehi">
		<div class="column">
			<label class="label">3 - ތަން ހިންގާ ފަރާތުގެ މަޢުލޫމާތު:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <label class="label">ނަން</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._3name">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">އެޑްރެސް (އަތޮޅާއި ރަށް):</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._3address">
					  </div>
					</div>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">އައިޑީކާޑު ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input ltr" type="text" v-model="form._3idNo" placeholder="A123456">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ފޯން ނަމްބަރ</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._3phone" placeholder="9876543">
					  </div>
					</div>
		    </div>
			</div>
		</div>
	</div>



	<div class="columns dhivehi">
		<div class="column">
			<label class="label">4 - ތަނާ ބެހޭ މަޢުލޫމާތު:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <label class="label">ތަނުގެ ނަން</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4placeName">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">މަގު:</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4road">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  			  <label class="label">ސާވިންގ އޭރިޔާގެ އަދަދު:</label>
					<div class="field">
					  <div class="control">
							<input class="input ltr" type="text" v-model="form._4numberOfServingAreas">
					  </div>
					</div>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">ތަނުގެ އެޑްރެސް:</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4placeAddress">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ބްލޮކް ނަންބަރ:</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4blockNumber">
					  </div>
					</div>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ގޮނޑީގެ އަދަދު:</label>
					<div class="field">
					  <div class="control">
							<input class="input" type="text" v-model="form._4numberOfChairs">
					  </div>
					</div>
		    </div>
			</div>
		</div>
	</div>


	<div class="columns dhivehi">
		<div class="column">
			<label class="label">5 - ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ކެޓަގަރީތައް:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="tile is-ancestor">
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
		      <div class="column">
						<div class="field">
						  <div class="control">
								<div>
									<div style="background-color:	#F8F8F8;padding:3px;margin-top:2px;">
										<label>ކެޓަގަރީ 1&nbsp&nbsp&nbsp</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat11">
												ހޮޓާ
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat12">
												ކެފޭ
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat13">
												ރެސްޓޯރަންޓް
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat14">
												ކެންޓީން
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat15">
												ކޮފީ ޝޮޕް
										</label>
									</div>

									<div style="padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 2&nbsp&nbsp&nbsp</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat21">
												ކޭޓަރިންގ ސރވިސަސް
										</label>
									</div>

									<div style="background-color:	#F8F8F8;padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 3&nbsp&nbsp&nbsp</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat31">
												ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެއާއި އެކު)
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat32">
												ބޭކަރީ
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat33">
												ބަދިގެ
										</label>
									</div>

									<div style="padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 4&nbsp&nbsp&nbsp</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat41">
												ހެދިކާ ވިއްކާ ތަންތަން
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat42">
												ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެނުލާ)
										</label>
										&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
										  <input type="checkbox" v-model="form._5cat43">
												ޖޫސް ފަދަ ލުއިބުއިންތައް އެކަނި ވިއްކާތަންތަން
										</label>
									</div>

									<div style="background-color:	#F8F8F8;padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 5&nbsp&nbsp&nbsp</label>
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
									  <input type="checkbox" v-model="form._5cat51">
											ކާބޯތަކެތި ބަންދުކުރާ ކުދިވިޔަފާރި ކުރާ ތަންތަން</label>
									</div>

									<div style="padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 6&nbsp&nbsp&nbsp</label>
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
									  <input type="checkbox" v-model="form._5cat61">
											ކާބޯތަކެތި ބަންދުކުރާ މެދުފަންތީގެވިޔަފާރި ކުރާ ތަންތަން
									</label>
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
									  <input type="checkbox" v-model="form._5cat62">
											މަގުމަތީގައި ކާނާ ވިއްކާ ތަންތަނާއި ތަކެއްޗާއި އުޅަނދުތައް
										</label>
									</div>

									<div style="background-color:	#F8F8F8;padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 7&nbsp&nbsp&nbsp</label>
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
									  <input type="checkbox" v-model="form._5cat71">
											ވަގުތީގޮތުން ހިންގާ ފެއާރތަކާއި ކެންޓީންފަދަ ތަންތަން
										</label>
									</div>

									<div style="padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 8&nbsp&nbsp&nbsp</label>
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
									  <input type="checkbox" v-model="form._5cat81">
											ނައަމްސޫފި ކަތިލުމުގެ ޚިދުމަތްދޭ ތަންތަން
										</label>
									</div>

									<div style="background-color:	#F8F8F8;padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 9&nbsp&nbsp&nbsp</label>
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
									  <input type="checkbox" v-model="form._5cat91">
											ދައުލަތުގެ ފަރާތުން ނުވަތަ އަމިއްލަ ޖަމާއަތަކުން ކުދިންނާއި މީހުން ބަލަހައްޓާ ތަންތަނާއި ހިލޭ ސާބަހައް ކާބޯތަކެތި ތައްޔާރުކޮށް ފޯރުކޮށްދޭ ތަންތަން
										</label>
									</div>

									<div style="padding:3px;margin-top:2px;">
										<label >ކެޓަގަރީ 10&nbsp</label>
									&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label class="checkbox">
									  <input type="checkbox" v-model="form._5cat101">
											އެހެނިހެން ތަންތަން/ތަފްޞީލް:
										</label>
										<div class="field">
										  <div class="control" v-if="form._5cat101">
												<input class="input" type="text" v-model="form._5cat101text" placeholder="ކެޓަގަރީ 10:  އެހެނިހެން ތަންތަން/ތަފްޞީލް:">
										  </div>
										</div>
									</div>

								</div>
						  </div>
						</div>
					</div>
		    </div>
		  </div>
		</div>
	</div>




	<div class="columns no-print">
		<div class="column center dhivehi">
		    <button class="button is-success is-large" @click="saveApplication">ރައްކާ ކުރޭ</button>
		</div>
	</div>
</div>
</template>

<script>

export default {
	props: ['businessId'],
	data() {
		return {
			business: {},
			form: new Form({
				business_id: null,
				_1tobaccoOrFood: "1",
				_1applicationType: "1",
				_1toRegisterPlace: true,
				_1toRenewLicense: false,
				_1registerPlace: "1",
				_1renewLicense: "1",
				_1registrationNumber: null,
				_1wantLicenseIndhivehi: true,
				_1wantLicenseInenglish: true,
				_1date:null,
				_2name:null,
				_2idNo:null,
				_2address:null,
				_2phone:null,
				_3name:null,
				_3idNo:null,
				_3address:null,
				_3phone:null,
				_4placeName:null,
				_4placeAddress:null,
				_4road:null,
				_4blockNumber:null,
				_4numberOfServingAreas:null,
				_4numberOfChairs:null,
				_5cat11:false,
				_5cat12:false,
				_5cat13:false,
				_5cat14:false,
				_5cat15:false,
				_5cat21:false,
				_5cat31:false,
				_5cat32:false,
				_5cat33:false,
				_5cat41:false,
				_5cat42:false,
				_5cat43:false,
				_5cat51:false,
				_5cat61:false,
				_5cat62:false,
				_5cat71:false,
				_5cat81:false,
				_5cat91:false,
				_5cat101:false,
				_5cat101text:null
			})
		}
	},
	watch: {
  	'form._1applicationType': function() {
  		switch(this.form._1applicationType) {
			    case "1":
			        this.form._1toRegisterPlace = true;
			        this.form._1toRenewLicense = false;
			        break;
			    case "2":
			        this.form._1toRegisterPlace = false;
			        this.form._1toRenewLicense = true;
			        break;
			    default:
			        this.form._1toRegisterPlace = true
			}
	  	}
	},
	mounted() {
		this.getBusiness();
	},
	methods: {
		getBusiness() {
			if (this.hasPermission('api.businesses.show')) {
				axios
	  			.get('/api/businesses/' + this.businessId)
				.then(response => {
					this.business = response.data;
					this.autoFillForm(this.business);
				})
				.catch(errors => console.log(errors));
	        }
		},
		autoFillForm(business) {
			this.form.business_id = this.businessId;
			this.form._1registrationNumber = business.registration_no;
			this.form._2name = business.name_dv;
			this.form._2phone = business.phone;
			this.tryFromlatestApplication(business);
		},
		tryFromlatestApplication(business) {
			if (business.applications.length>0) {
				this.form._1tobaccoOrFood = business.applications[0]._1tobaccoOrFood;
				this.form._1applicationType = business.applications[0]._1applicationType;
				this.form._1toRegisterPlace = business.applications[0]._1toRegisterPlace;
				this.form._1toRenewLicense = business.applications[0]._1toRenewLicense;
				this.form._1registerPlace = business.applications[0]._1registerPlace;
				this.form._1renewLicense = business.applications[0]._1renewLicense;
				this.form._1registrationNumber = business.applications[0]._1registrationNumber;
				this.form._1wantLicenseIndhivehi = business.applications[0]._1wantLicenseIndhivehi;
				this.form._1wantLicenseInenglish = business.applications[0]._1wantLicenseInenglish;
				this.form._1date = business.applications[0]._1date;
				this.form._2name = business.applications[0]._2name;
				this.form._2idNo = business.applications[0]._2idNo;
				this.form._2address = business.applications[0]._2address;
				this.form._2phone = business.applications[0]._2phone;
				this.form._3name = business.applications[0]._3name;
				this.form._3idNo = business.applications[0]._3idNo;
				this.form._3address = business.applications[0]._3address;
				this.form._3phone = business.applications[0]._3phone;
				this.form._4placeName = business.applications[0]._4placeName;
				this.form._4placeAddress = business.applications[0]._4placeAddress;
				this.form._4road = business.applications[0]._4road;
				this.form._4blockNumber = business.applications[0]._4blockNumber;
				this.form._4numberOfServingAreas = business.applications[0]._4numberOfServingAreas;
				this.form._4numberOfChairs = business.applications[0]._4numberOfChairs;
				this.form._5cat11 = business.applications[0]._5cat11;
				this.form._5cat12 = business.applications[0]._5cat12;
				this.form._5cat13 = business.applications[0]._5cat13;
				this.form._5cat14 = business.applications[0]._5cat14;
				this.form._5cat15 = business.applications[0]._5cat15;
				this.form._5cat21 = business.applications[0]._5cat21;
				this.form._5cat31 = business.applications[0]._5cat31;
				this.form._5cat32 = business.applications[0]._5cat32;
				this.form._5cat33 = business.applications[0]._5cat33;
				this.form._5cat41 = business.applications[0]._5cat41;
				this.form._5cat42 = business.applications[0]._5cat42;
				this.form._5cat43 = business.applications[0]._5cat43;
				this.form._5cat51 = business.applications[0]._5cat51;
				this.form._5cat61 = business.applications[0]._5cat61;
				this.form._5cat62 = business.applications[0]._5cat62;
				this.form._5cat71 = business.applications[0]._5cat71;
				this.form._5cat81 = business.applications[0]._5cat81;
				this.form._5cat91 = business.applications[0]._5cat91;
				this.form._5cat101 = business.applications[0]._5cat101;
				this.form._5cat101text = business.applications[0]._5cat101text;
			}
		},
		saveApplication() {
			this.form.post('/api/applications')
				.then(data => {
			      this.$router.push({ name: 'applications.show', params: { applicationId: data.id } })
				})
				.catch(errors => console.log(errors));
		}
	}
}

</script>
