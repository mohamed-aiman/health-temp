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