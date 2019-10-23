<template>
  <div v-if="can('api.applications.update')">
    <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    <related-documents 
      :title="'Application Documents'"
      :model="application"
      :resource="'applications'"
      :editable="true"
      @refresh="getApplication"
      >
    </related-documents>

    <template id="attached-to-business" v-if="application.business_id && business && can('api.businesses.show')">
      <div class="columns">
        <div class="column box">
          <table class="table is-fullwidth is-narrow is-bordered">
            <tr><td colspan="2" class="is-info"><b>Application Business Details</b></td></tr>
            <tr><td>English Name</td><td>{{business.name}}</td></tr>
            <tr><td>Dhivehi Name</td><td><p class="dhivehi">{{business.name_dv}}</p></td></tr>
            <tr><td>Registration No.</td><td>{{business.registration_no}}</td></tr>
            <tr><td>Phone No.</td><td>{{business.phone}}</td></tr>
            <tr>
              <td colspan="2" class="center">
                <router-link v-can="'api.businesses.show'"   class="button is-link"    :to="{ name: 'businesses.show', params: { businessId: business.id }}">View Business</router-link>
                <button class="button is-danger"  v-can="'api.applications.businesses.detach'"  @click="submitRemoveBusinessFromApplication">Remove Business From Application</button>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </template>

    <template id="not-attached-to-business" v-if="!application.business_id">
      <div class="columns">
        <div class="column">
          Not Attached To A Business Yet
        </div>
      </div>

      <template v-if="showAttachToExistingBusiness">
        <div class="columns">
          <div class="column">
            <template id="business-selected" v-if="selectedBusiness">
              <label class="label">Selected Business</label>
              <table class="table is-bordered is-hoverable is-fullwidth">
                <tr>
                  <td>{{selectedBusiness.name}}</td>
                  <td>{{selectedBusiness.registration_no}}</td>
                  <td>{{selectedBusiness.phone}}</td>
                  <td class="right">
                    <router-link v-can="'api.businesses.show'"   class="button is-link"    :to="{ name: 'businesses.show', params: { businessId: selectedBusiness.id }}">View Business</router-link>
                    <button class="button is-link"  v-can="'api.applications.businesses.attach'" @click="submitAttachToSelectedBusiness">Attach to the selected Business</button>
                    <button class="button is-link"  v-can="'api.businesses.store'" @click="toggleShowNewBusinessRegistration">Create New</button>
                    <button class="button is-link"  v-can="'api.businesses.search'" @click="togglelSearchForAnother">Search for Another Business</button>
                  </td>
                </tr>
              </table>
            </template>
            <template id="no-business-selected" v-if="!selectedBusiness">
              <label class="label">No business is selected</label>
              <table class="table is-bordered is-hoverable is-fullwidth">
                <tr>
                  <td>
                    <button class="button is-link" v-can="'api.applications.businesses.attach'" @click="toggleShowNewBusinessRegistration">Create New</button>
                    <button class="button is-link" v-can="'api.businesses.search'" @click="togglelSearchForAnother">Search Existing Business</button>
                  </td>
                </tr>
              </table>
            </template>
            <template id="search" v-if="searchForAnother">
                <table  class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                  <tr v-can="'api.businesses.search'">
                    <td colspan="3">
                      <div class="label is-normal">
                        <label class="label">Search for a business to attach to</label>
                      </div>
                    </td>
                  </tr>
                  <tr v-can="'api.businesses.search'">
                    <td colspan="3">
                      <input class="input" name="businessesSearchTerm" type="text" v-model="businessesSearchTerm" placeholder="Business name or registration no or phone">
                    </td>
                  </tr>
                  <tr v-if="businesses.length > 0">
                    <td>Name</td>
                    <td>Registration No.</td>
                    <td>Phone No.</td>
                  </tr>
                  <template v-for="item in businesses">
                    <tr @click="selectBusiness(item)">
                      <td>{{item.name}}</td>
                      <td>{{item.registration_no}}</td>
                      <td>{{item.phone}}</td>
                    </tr>
                  </template>
                </table>
            </template>
          </div>
        </div>
      </template>

      <template id="business-registration-form" v-if="showNewBusinessRegistration">
        <div class="columns">
          <div class="column">
            <table class="table is-narrow is-fullwidth is-bordered">
              <tr>
                <td colspan="2">
                  <div class="label is-normal">
                    <label class="label" v-show="application._1applicationType == '1'">Add new business entity (Register New Business)</label>
                    <label class="label" v-show="application._1applicationType == '2'">Add new business entity (Licence Renewal Application)</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <response-messages :response.sync="saveNewBusinessResponse"></response-messages>
                </td>
              </tr>
              <tr><td>English Name</td><td><input class="input" name="name" type="text" v-model="businessRegForm.name" placeholder="Business name"></td></tr>
              <tr><td>Dhivehi Name</td><td><input class="input dhivehi" name="name_dv" type="text" v-model="businessRegForm.name_dv" placeholder="ދިވެހި ނަން"></td></tr>
              <tr><td>Registration Number</td><td><input class="input" name="registration_no" type="text" v-model="businessRegForm.registration_no" placeholder="registration no"></td></tr>
              <tr><td>Phone</td><td><input class="input" name="phone" type="text" v-model="businessRegForm.phone" placeholder="phone"></td></tr>
              <tr><td class="center" colspan="2"><button class="button is-link" @click="submitNewBusinessForm">Save and Attach to New Business</button></td></tr>
            </table>
          </div>
        </div>
      </template>
    </template>

    <dhivehi-form-heading>ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް</dhivehi-form-heading>

    <div>
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
                      <div style="background-color: #F8F8F8;padding:3px;margin-top:2px;">
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

                      <div style="background-color: #F8F8F8;padding:3px;margin-top:2px;">
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

                      <div style="background-color: #F8F8F8;padding:3px;margin-top:2px;">
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

                      <div style="background-color: #F8F8F8;padding:3px;margin-top:2px;">
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

                      <div style="background-color: #F8F8F8;padding:3px;margin-top:2px;">
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



      <div class="columns no-print" v-if="statusChangeStatus">
        <div class="column">
          <div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
        </div>
      </div>

      <div class="columns dhivehi no-print">
        <div class="column center dhivehi">
            <button v-if="application.status == 'draft' && can('api.applications.destroy')" class="button is-danger is-large" @click="deleteApplication()">ފުހެލާ</button>
            <button v-if="application.status == 'draft' && can('api.applications.update')" class="button is-warning is-large" @click="updateApplication()">އަދާހަމަ ކުރޭ</button>
            <button v-if="application.status == 'draft' && can('api.applications.show')"class="button is-primary is-large" @click="getApplication()">ކެންސަލް</button>
            <button v-can="'api.applications.show'" class="button is-info is-large" @click="goToApplication()">ޕްރިންޓް ވިއު</button>
            <button v-if="application.status == 'draft' && application.business_id && can('api.applications.sendForProcessing')" class="button is-success is-large" @click="sendForProcessing()">އިންސްޕެކްޝަނަށް ފޮނުވާ</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import RelatedDocuments from '../Common/RelatedDocuments';

  export default {
    props: ['applicationId'],
    components: {
      'related-documents': RelatedDocuments
    },
    data() {
      return {
        isLoading: true,
        isFullPage: true,
        showNewBusinessRegistration: false,
        showAttachToExistingBusiness: true,
        searchForAnother: false,
        businessesSearchTerm: null,
        businesses: [],
        selectedBusiness: null,
        statusChangeStatus: null,
        statusChangeColor: 'is-success',
        application: {},
        license: {},
        businessStoreMessage: null,
        businessStoreColor: 'is-success',
        business: {},
        business_id: null,
        businessRegForm: {
            name: null,
            name_dv: null,
            phone: null,
            registration_no: null,
        },
        saveNewBusinessResponse: {},
        form: {
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
        }
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
      },
      businessesSearchTerm: _.debounce(function(){
          if (this.businessesSearchTerm) {
              this.businesses = [];
              this.searchBusinesses();
          }
      }, 700)
    },
    mounted() {
        this.openLoading();
        this.getApplication();
    },
    methods: {
        openLoading() {
            this.isLoading = true
            setTimeout(() => {
                this.isLoading = false
            }, 1000)
        },
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
        deleteApplication() {
          if (this.hasPermission('api.applications.destroy')) {
            if (!confirm('Are you sure you want to delete this application?. You cannot undo this process.')) 
                return;

            axios
              .delete('/api/applications/' + this.applicationId)
                .then(response => {
                    this.$router.push({ name: 'applications.draft' })
                })
                .catch(errors => console.log(errors));
          }
        },
        searchBusinesses() {
          if (this.hasPermission('api.businesses.search')) {
            axios
            .get('/api/businesses/search?found=true&term=' + this.businessesSearchTerm)
              .then(response => {
                  this.businesses = response.data;
                if (this.businesses.length == 1) {
                    this.selectedBusiness = this.businesses[0];
                }
              })
              .catch(error => console.log(error));
          }

        },
        selectBusiness(item) {
            this.selectedBusiness = item;
            this.businesses = [];
        },
        toggleShowNewBusinessRegistration() {
            this.showNewBusinessRegistration = !this.showNewBusinessRegistration;
            this.searchForAnother = false;
        },
        togglelSearchForAnother() {
            this.searchForAnother = !this.searchForAnother;
            this.showNewBusinessRegistration = false;
        },
        setBusinessRegistrationRelated() {
            if(this.business == null) {
                this.businessRegForm.name = null;
                this.businessRegForm.name_dv = this.form._2name;
                this.businessRegForm.phone = this.form._2phone;
                this.businessRegForm.registration_no = this.form._1registrationNumber;
                this.businessesSearchTerm = this.form._1registrationNumber;
                this.openLoading();
            } else {
                this.businessRegForm.name = this.business.name;
                this.businessRegForm.name_dv = this.business.name_dv;
                this.businessRegForm.phone = this.business._2phone;
                this.businessRegForm.registration_no = this.business.registration_no;
            }
        },
        submitNewBusinessForm() {
          if (this.hasPermission('api.applications.businesses.store')) {
            axios.post('/api/applications/' + this.applicationId + '/businesses', this.businessRegForm)
                .then(response => {
                    this.setFormFromModel(response.data);
                    this.saveNewBusinessResponse = response;
    
                    setTimeout(function() {
                        this.$emit('update:saveNewBusinessResponse', {});
                    }.bind(this), 1000);
                })
                .catch(error => {
                    this.saveNewBusinessResponse = error.response;
                });    
          }
        },
        businessStoreFail() {
            this.businessStoreColor = 'is-danger';
            this.businessStoreMessage = 'error while creating new business entity or attaching it to the business.'
        },
        updateApplication() {
          if (this.hasPermission('api.applications.update')) {
                axios.patch('/api/applications/' + this.applicationId, this.form)
                .then(response => {
                    this.setFormFromModel(response.data);
                })
                .catch(error => {
                    this.statusChangeStatus = 'unable to save: ' + error.response.data.message;
                    this.statusChangeColor = 'is-danger';
                });
          }
        },
        setFormFromModel(data) {
            this.application = data;
            this.license = this.application.license;
            this.business = data.business;
            this.business_id = data.business_id;

            // if(this.license) {
            //     this.licenseForm.issued_at = new Date(this.license.issued_at);
            //     this.licenseForm.expire_at = new Date(this.license.expire_at);
            //     this.licenseForm.license_no = this.license.license_no;
            // }

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
            this.setBusinessRegistrationRelated();
        },
        sendForProcessing() {
          if (this.hasPermission('api.applications.sendForProcessing')) {
            axios
            .patch("/api/applications/" + this.applicationId  + "/status/pending")
            .then(response => {
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToApplication();
            })
            .catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
            });
          }
        },
        goToApplication() {
          if (this.hasPermission('api.applications.show')) {
            this.$router.push({ name: 'applications.show', params: { applicationId: this.applicationId } })
          }
        },
        submitAttachToSelectedBusiness() {
          if (this.hasPermission('api.applications.businesses.attach')) {
            axios
            .patch('/api/applications/' + this.applicationId + '/businesses/' + this.selectedBusiness.id + '/attach')
            .then(response => {
                this.setFormFromModel(response.data);
            })
            .catch(errors => {
            });
          }
        },
        submitRemoveBusinessFromApplication() {
          if (this.hasPermission('api.applications.businesses.detach')) {
            if (confirm('Are you sure you want to detach this application from the attached business?')) {
                axios
                .patch('/api/applications/' + this.applicationId + '/businesses/detach')
                .then(response => {
                    this.setFormFromModel(response.data);
                })
                .catch(errors => {
                });
            } else {}
          }
        },
      }
    };
</script>
