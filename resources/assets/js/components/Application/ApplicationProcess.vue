<template>
  <div v-can="'api.applications.process'">
    <english-heading>Process Pending Application</english-heading>
    <template id="attached-to-business" v-if="application.business_id">
      <div class="columns">
        <div class="column">
          <table class="table is-fullwidth is-narrow is-bordered">
            <tr>
              <td colspan="2"><b>Business Details</b></td>
            </tr>
            <tr>
              <td>English Name</td>
              <td>{{business.name}}</td>
            </tr>
            <tr>
              <td>Dhivehi Name</td>
              <td>
                <p class="dhivehi">{{business.name_dv}}</p>
              </td>
            </tr>
            <tr>
              <td>Registration No.</td>
              <td>{{business.registration_no}}</td>
            </tr>
            <tr>
              <td>Phone No.</td>
              <td>{{business.phone}}</td>
            </tr>
            <tr>
              <td colspan="2" class="center">
                <router-link v-can="'api.businesses.show'" class="button is-link" :to="{ name: 'businesses.show', params: { businessId: business.id }}">View Business</router-link>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <template id="inspection">
        <div class="columns">
          <div class="column">
            <template v-if="application.inspections.length<=0">
              <table v-can="'api.applications.inspections.store'" class="table is-fullwidth is-narrow is-bordered">
                <tr>
                  <td colspan="5"><b>Schedule an Inspection</b></td>
                </tr>
                <tr>
                  <td>
                    <template>
                      <b-field label="Time">
                        <datetime type="datetime" class="input" v-model="inspectionForm.inspection_at" format="yyyy-MM-dd HH:mm"></datetime>
                      </b-field>
                    </template>
                  </td>
                  <td>
                    <div class="field">
                      <label class="label">Inspector</label>
                      <div class="select">
                        <select v-model="inspectionForm.inspector_id">
                          <option v-for="option in inspectors" v-bind:value="option.id">
                          {{ option.name }}({{ option.id }})
                          </option>
                        </select>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="field">
                      <label class="label">Permit Type</label>
                      <div class="select">
                        <select disabled>
                          <option>{{application.permit_type}}</option>
                        </select>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="field">
                      <label class="label">Type</label>
                      <div class="select">
                        <select disabled v-model="form._1applicationType">
                          <option value="1">New Registration</option>
                          <option value="2">License Renewal</option>
                        </select>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="field">
                      <label class="label">&nbsp</label>
                      <div class="control">
                        <button class="button is-link" @click="submitSaveInspection">Save Inspection</button>
                      </div>
                    </div>
                  </td>
                  </tr>
                </table>
              </template>
              <template v-if="application.inspections.length>0">
                <table class="table is-fullwidth is-narrow is-bordered">
                  <tr>
                    <th colspan="6">Inspections</th>
                  </tr>
                  <tr>
                    <th>Id</th>
                    <th>Status</th>
                    <th>Inspection Time</th>
                    <th>Inspector</th>
                    <th>Applied For</th>
                    <th>Options</th>
                  </tr>
                  <tr v-for="inspection in application.inspections">
                    <td>{{inspection.id}}</td>
                    <td>{{inspection.status}}</td>
                    <td>{{inspection.inspection_at}}</td>
                    <td>{{inspection.inspector ? inspection.inspector.name + '(' + inspection.inspector.id + ')' : 'not assigned'}}</td>
                    <td>{{application.permit_type}} ({{application.register_or_renew}})</td>
                    <td>
                      <p class="buttons">
                        <a class="button is-danger" v-can="'api.inspections.destroy'" @click="deleteInspection(inspection)">
                          <span class="icon is-small">
                            <i class="fa fa-times"></i>
                          </span>
                        </a>
                        <router-link v-can="'api.inspections.show'" class="button is-info" :to="{ name: 'inspections.show', params: { inspectionId: inspection.id }}">
                          <span class="icon is-small">
                            <i class="fa fa-eye"></i>
                          </span>
                        </router-link>
                      </p>
                    </td>
                  </tr>
                </table>
              </template>
            </div>
          </div>
          <div class="columns" v-if="statusChangeStatus">
            <div class="column">
              <div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
            </div>
          </div>
          <div class="columns dhivehi no-print">
            <div class="column center">
              <button class="button is-info is-large" v-can="'api.applications.show'" @click="goToApplication()">ޕްރިންޓް ވިއު</button>
              <button class="button is-warning is-large" v-can="'api.applications.sendBackToEditing'" @click="sendForEditing()">އަލުން ބަދަލު ގެނައުމަށް ފޮނުވާ</button>
              <button class="button is-success is-large" v-if="application.inspections.length>0 && can('api.applications.process')" @click="processed()">ޕްރޮސެސްކޮށް ނިމުނީ</button>
            </div>
          </div>
        </template>
      </template>
      <div class="box">
        <br>
        <dhivehi-form-heading>ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް</dhivehi-form-heading>
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
                <label>ކެޓަގަރީ 4</label>
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
                <label>ކެޓަގަރީ 5</label>
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
                <label>ކެޓަގަރީ 6</label>
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
                <label>ކެޓަގަރީ 7</label>
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
                <label>ކެޓަގަރީ 8</label>
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
                <label>ކެޓަގަރީ 9</label>
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
                <label>ކެޓަގަރީ 10</label>
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
                    <template>
                      <p class="small-box">{{form._5cat101text}}</p>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br />
      </div>
    </div>
</template>

<script>
export default {
  props: ['applicationId'],
  data() {
    return {
      statusChangeStatus: null,
      statusChangeColor: 'is-success',
      application: {
        inspections: []
      },
      business: {},
      form: new Form({
        applicationId: null,
        _1tobaccoOrFood: "1",
        _1applicationType: "1",
        _1toRegisterPlace: true,
        _1toRenewLicense: true,
        _1registerPlace: "1",
        _1renewLicense: "1",
        _1registrationNumber: null,
        _1wantLicenseIndhivehi: true,
        _1wantLicenseInenglish: true,
        _1date: null,
        _2name: null,
        _2idNo: null,
        _2address: null,
        _2phone: null,
        _3name: null,
        _3idNo: null,
        _3address: null,
        _3phone: null,
        _4placeName: null,
        _4placeAddress: null,
        _4road: null,
        _4blockNumber: null,
        _4numberOfServingAreas: null,
        _4numberOfChairs: null,
        _5cat11: false,
        _5cat12: false,
        _5cat13: false,
        _5cat14: false,
        _5cat15: false,
        _5cat21: false,
        _5cat31: false,
        _5cat32: false,
        _5cat33: false,
        _5cat41: false,
        _5cat42: false,
        _5cat43: false,
        _5cat51: false,
        _5cat61: false,
        _5cat62: false,
        _5cat71: false,
        _5cat81: false,
        _5cat91: false,
        _5cat101: false,
        _5cat101text: null
      }),
      inspectionForm: new Form({
        inspection_at: "",
        inspector_id: null,
      }),
      inspectors: []
    }
  },
  watch: {
    'form._1applicationType': function() {
      switch (this.form._1applicationType) {
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
    this.getApplication();
    this.getInspectors();
  },
  methods: {
    getApplication() {
      if (this.hasPermission('api.applications.show')) {
        axios
        .get('/api/applications/' + this.applicationId)
        .then(response => {
          this.setFormFromModel(response.data);
        })
        .catch(errors => console.log(errors));
      }
    },
    getInspectors() {
      if (this.hasPermission('api.inspectors.index')) {
        axios
        .get('/api/inspectors')
        .then(response => {
          this.inspectors = response.data
        })
        .catch(errors => console.log(errors));
      }
    },
    submitSaveInspection() {
      axios
      .post('/api/applications/' + this.applicationId + '/inspections', {
        'inspection_at': moment(this.inspectionForm.inspection_at).format("Y-MM-DD HH:mm:ss"),
        'inspector_id':this.inspectionForm.inspector_id
      })
      .then(response => {
        this.getApplication();
      })
      .catch(error => {
        alert('error saving: ' + error.response.data.message);
      });
    },
    deleteInspection(inspection) {
      if (!confirm('are you sure you want to delete the inspection.')) { return; }
      axios
      .delete('/api/inspections/' + inspection.id)
      .then(response => {
        this.getApplication();
      })
      .catch(error => {
        alert('error deleting: ' + error.response.data.message);
      });
    },
    setFormFromModel(data) {
      this.application = data;
      this.business = data.business;
      this.business_id = data.business_id;

      this.form._1tobaccoOrFood = data._1tobaccoOrFood;
      this.form._1applicationType = data._1applicationType;
      this.form._1toRegisterPlace = data._1toRegisterPlace;
      this.form._1toRenewLicense = data._1toRenewLicense;
      this.form._1registerPlace = data._1registerPlace;
      this.form._1renewLicense = data._1renewLicense;
      this.form._1registrationNumber = data._1registrationNumber;
      this.form._1wantLicenseIndhivehi = data._1wantLicenseIndhivehi;
      this.form._1wantLicenseInenglish = data._1wantLicenseInenglish;
      this.form._1date = data._1date;
      this.form._2name = data._2name;
      this.form._2idNo = data._2idNo;
      this.form._2address = data._2address;
      this.form._2phone = data._2phone;
      this.form._3name = data._3name;
      this.form._3idNo = data._3idNo;
      this.form._3address = data._3address;
      this.form._3phone = data._3phone;
      this.form._4placeName = data._4placeName;
      this.form._4placeAddress = data._4placeAddress;
      this.form._4road = data._4road;
      this.form._4blockNumber = data._4blockNumber;
      this.form._4numberOfServingAreas = data._4numberOfServingAreas;
      this.form._4numberOfChairs = data._4numberOfChairs;
      this.form._5cat11 = data._5cat11;
      this.form._5cat12 = data._5cat12;
      this.form._5cat13 = data._5cat13;
      this.form._5cat14 = data._5cat14;
      this.form._5cat15 = data._5cat15;
      this.form._5cat21 = data._5cat21;
      this.form._5cat31 = data._5cat31;
      this.form._5cat32 = data._5cat32;
      this.form._5cat33 = data._5cat33;
      this.form._5cat41 = data._5cat41;
      this.form._5cat42 = data._5cat42;
      this.form._5cat43 = data._5cat43;
      this.form._5cat51 = data._5cat51;
      this.form._5cat61 = data._5cat61;
      this.form._5cat62 = data._5cat62;
      this.form._5cat71 = data._5cat71;
      this.form._5cat81 = data._5cat81;
      this.form._5cat91 = data._5cat91;
      this.form._5cat101 = data._5cat101;
      this.form._5cat101text = data._5cat101text;
    },
    sendForEditing() {
      axios
      .patch("/api/applications/" + this.applicationId + "/status/draft")
      .then(response => {
        this.statusChangeColor = 'is-success';
        this.statusChangeStatus = 'status changed successfully.'
        this.goToApplication();
      })
      .catch(error => {
        this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
        this.statusChangeColor = 'is-danger';
      });
    },
    processed() {
      axios
      .patch("/api/applications/" + this.applicationId + "/status/processed", {
        inspection_id: this.application.inspections[0].id
      })
      .then(response => {
        this.statusChangeColor = 'is-success';
        this.statusChangeStatus = 'status changed successfully.'
        this.goToApplication();
      })
      .catch(error => {
        this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
        this.statusChangeColor = 'is-danger';
      });
    },
    goToApplication() {
      this.$router.push({ name: 'applications.show', params: { applicationId: this.applicationId } })
    }
  }
};
</script>
