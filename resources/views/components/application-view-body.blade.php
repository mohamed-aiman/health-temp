@verbatim
	<br>
	<div class="columns dhivehi">
		<div class="column">
			<h4 class="title is-4">ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް</h4>
		</div>
	</div>
	<br>
	<!-- 1 - ހުއްދައިގެ ބާވަތް -->
	<div class="columns dhivehi">
		<div class="column">
			<label class="label">1 - ހުއްދައިގެ ބާވަތް</label>
		</div>
	</div>
	<div class="columns dhivehi box">
		<div class="column">
			<p class="small-box" v-if="form._1tobaccoOrFood == '1'">ދުންފަތް</p>
			<p class="small-box" v-if="form._1tobaccoOrFood == '2'">ކާބޯތަކެތި</p>
		</div>
		<div class="column">
			<template v-if="form._1tobaccoOrFood === '2'">
			    <p class="small-box" v-if="form._1tobaccoOrFood == '1'">ތަން ރަޖިސްޓްރީ ކުރުމަށް</p>
			    <p class="small-box" v-if="form._1tobaccoOrFood == '2'">ހުއްދަ އާކުރުމަށް</p>
			</template>
		</div>
		<div class="column">
			<template v-if="form._1tobaccoOrFood === '2'">
			  <template v-if="form._1toRegisterPlace">
			    <p class="small-box" v-if="form._1registerPlace == '1'">އަލަށް ރަޖިސްޓްރީ ކުރުމަށް</p>
			    <p class="small-box" v-if="form._1registerPlace == '2'">ތަނުގެ ނަން ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</p>
			    <p class="small-box" v-if="form._1registerPlace == '3'">ތަން ހިންގާ ފަރާތް ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</p>
			    <p class="small-box" v-if="form._1registerPlace == '4'">ތަނުގެ އެޑްރެސް ބަދަލުވެގެން ރަޖިސްޓްރީ ކުރުމަށް</p>
			  </template>
			  <template v-if="form._1toRenewLicense">
			    <p class="small-box" v-if="form._1renewLicense == '1'">ހުއްދައިގެ މުއްދަތު ހަމަވެގެން</p>
			    <p class="small-box" v-if="form._1renewLicense == '2'">ހުއްދަ ގެއްލިގެން އާކުރުމަށް</p>
			    <p class="small-box" v-if="form._1renewLicense == '3'">ހުއްދަ ހަލާކުވެގެން އާކުރުމަށް</p>
			  </template>
			</template>
		</div>
	</div>
	<br>
	<div class="columns dhivehi box">
		<div class="column">
			<label class="label">ރަޖިސްޓްރޭސަން ނަމްބަރ</label>
			<p class="small-box">{{form._1registrationNumber}}</p>
		</div>
		<div class="column">
			<div class="field">
			  <label class="label">ހުއްދަ ބޭނުންވާ ބަސް</label>
			  <div class="control pull-right">
					<label class="checkbox">
					  <input type="checkbox" disabled v-model="form._1wantLicenseIndhivehi">
					  ދިވެހި
					</label>
					<label class="checkbox">
					  <input type="checkbox" disabled v-model="form._1wantLicenseInenglish">
					  އިނގިރޭސި
					</label>
			  </div>
			</div>
		</div>
		<div class="column">
		  <label class="label">ތާރީޚް</label>
		  <p class="small-box">{{form._1date}}</p>
		</div>
	</div>

	<!-- 2 - ވިޔަފާރި ރަޖިސްޓްރީ ކުރެވިފައިވާ ފަރާތުގެ މަޢުލޫމާތު: -->
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
					<p class="small-box">{{form._2name}}</p>
		    </div>
		    <div class="tile is-child">
  				<label class="label">އެޑްރެސް (އަތޮޅާއި ރަށް):</label>
					<p class="small-box">{{form._2address}}</p>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">އައިޑީކާޑު ނަމްބަރ</label>
					<p class="small-box">{{form._2idNo}}</p>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ފޯން ނަމްބަރ</label>
					<p class="small-box">{{form._2phone}}</p>
		    </div>
			</div>
		</div>
	</div>

	<!-- 3 - ތަން ހިންގާ ފަރާތުގެ މަޢުލޫމާތު: -->
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
					<p class="small-box">{{form._3name}}</p>
		    </div>
		    <div class="tile is-child">
  				<label class="label">އެޑްރެސް (އަތޮޅާއި ރަށް):</label>
					<p class="small-box">{{form._3address}}</p>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">އައިޑީކާޑު ނަމްބަރ</label>
					<p class="small-box">{{form._3idNo}}</p>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ފޯން ނަމްބަރ</label>
					<p class="small-box">{{form._3phone}}</p>
		    </div>
			</div>
		</div>
	</div>

	<!-- 4 - ތަނާ ބެހޭ މަޢުލޫމާތު: -->
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
					<p class="small-box">{{form._4placeName}}</p>
		    </div>
		    <div class="tile is-child">
  				<label class="label">މަގު:</label>
					<p class="small-box">{{form._4road}}</p>
		    </div>
		    <div class="tile is-child">
  			  <label class="label">ސާވިންގ އޭރިޔާގެ އަދަދު:</label>
					<p class="small-box">{{form._4numberOfServingAreas}}</p>
		    </div>
		  </div>
		  <div class="tile is-half is-vertical is-parent">
		    <div class="tile is-child">
  			  <label class="label">ތަނުގެ އެޑްރެސް:</label>
					<p class="small-box">{{form._4placeAddress}}</p>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ބްލޮކް ނަންބަރ:</label>
					<p class="small-box">{{form._4blockNumber}}</p>
		    </div>
		    <div class="tile is-child">
  				<label class="label">ގޮނޑީގެ އަދަދު:</label>
					<p class="small-box">{{form._4numberOfChairs}}</p>
		    </div>
			</div>
		</div>
	</div>

	<!-- 5 - ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ކެޓަގަރީތައް: -->
	<div class="columns dhivehi">
		<div class="column">
			<label class="label">5 - ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ކެޓަގަރީތައް:</label>
		</div>
	</div>

	<div class="columns dhivehi box">
		<div class="column">
			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px;">
					<label>ކެޓަގަރީ 1</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat11"></b-checkbox>
									ހޮޓާ
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat12"></b-checkbox>
									ކެފޭ
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat13"></b-checkbox>
									ރެސްޓޯރަންޓް
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat14"></b-checkbox>
									ކެންޓީން
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat15"></b-checkbox>
									ކޮފީ ޝޮޕް
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px;">
					<label>ކެޓަގަރީ 2</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat21"></b-checkbox>
									ކޭޓަރިންގ ސާރވިސަސް
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px;">
					<label>ކެޓަގަރީ 3</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat31"></b-checkbox>
									ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެއާއި އެކު)
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat32"></b-checkbox>
									ބޭކަރީ
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
							  <b-checkbox disabled type="is-warning" v-model="form._5cat33"></b-checkbox>
									ބަދިގެ
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px;">
					<label >ކެޓަގަރީ 4</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat41"></b-checkbox>
								ހެދިކާ ވިއްކާ ތަންތަން
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat42"></b-checkbox>
								ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެނުލާ)
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat43"></b-checkbox>
								ޖޫސް ފަދަ ލުއިބުއިންތައް އެކަނި ވިއްކާތަންތަން
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px">
					<label >ކެޓަގަރީ 5</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat51"></b-checkbox>
								ކާބޯތަކެތި ބަންދުކުރާ ކުދިވިޔަފާރި ކުރާ ތަންތަން
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px;">
					<label >ކެޓަގަރީ 6</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat61"></b-checkbox>
								ކާބޯތަކެތި ބަންދުކުރާ މެދުފަންތީގެވިޔަފާރި ކުރާ ތަންތަން
							</label>
						</div>
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat62"></b-checkbox>
								މަގުމަތީގައި ކާނާ ވިއްކާ ތަންތަނާއި ތަކެއްޗާއި އުޅަނދުތައް
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px">
					<label >ކެޓަގަރީ 7</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat71"></b-checkbox>
								ވަގުތީގޮތުން ހިންގާ ފެއާރތަކާއި ކެންޓީންފަދަ ތަންތަން
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px;">
					<label >ކެޓަގަރީ 8</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat81"></b-checkbox>
								ނައަމްސޫފި ކަތިލުމުގެ ޚިދުމަތްދޭ ތަންތަން
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px">
					<label >ކެޓަގަރީ 9</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat91"></b-checkbox>
								ދައުލަތުގެ ފަރާތުން ނުވަތަ އަމިއްލަ ޖަމާއަތަކުން ކުދިންނާއި މީހުން ބަލަހައްޓާ ތަންތަނާއި ހިލޭ ސާބަހައް ކާބޯތަކެތި ތައްޔާރުކޮށް ފޯރުކޮށްދޭ ތަންތަން
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns">
				<div class="column" style="width: 175px; max-width: 175px;">
					<label >ކެޓަގަރީ 10</label>
				</div>
				<div class="column">
					<div class="columns">
						<div class="column">
							<label class="checkbox">
						  <b-checkbox disabled type="is-warning" v-model="form._5cat101"></b-checkbox>
								އެހެނިހެން ތަންތަން/ތަފްޞީލް:
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="columns" v-if="form._5cat101 && form._5cat101text">
				<div class="column">
					<div class="columns">
						<div class="column">
							<template><p class="small-box">{{form._5cat101text}}</p></template>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<br/>
@endverbatim