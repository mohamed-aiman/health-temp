<template>
    <div v-can="'api.dhivehi-reports.update'">
        <div class="columns">
          <div class="column is-fullwidth dhivehi">
              <h1 class="title">
                ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަން ތަން ބަލާ ފާސްކުރުމުގެ ރިޕޯޓް
              </h1>
          </div>
        </div>
        <div class="container">
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
                                <select v-model="dhivehiReportForm.purpose" class="dhivehi">
                                  <option value="1">ރަޖިސްޓްރީ ކުރުމަށް</option>
                                  <option value="2">ރޫޓީން އިންސްޕެކްޝަން</option>
                                  <option value="3">ހުއްދަ އާކުރުމަށް</option>
                                  <option value="4">ސޮފްޓް ޗެކް</option>
                                  <option value="5">ތަނުގެ އެޑްރެސް / މެނޭޖްމެން ބަދަލުވެގެން</option>
                                  <option value="6">ޝަކުވާއާއި ގުޅިގެން</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr>
                            <td>ތަނުގެ ނަމާއި އެޑްރެސް:</td>
                            <td colspan="3"><input type="text" class="input" v-model="dhivehiReportForm.place_name_address" name="place_name_address"></td>
                        </tr>
                        <tr>
                            <td>ތަނުގެ ހިންގާ ފަރާތުގެ ނަމާއި އެޑްރެސް:</td>
                            <td colspan="3"><input type="text" class="input" v-model="dhivehiReportForm.place_owner_name_address" name="place_owner_name_address"></td>
                        </tr>
                        <tr>
                            <td>ގުޅޭން ނަމްބަރ:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.phone" name="phone"></td>
                            <td>އިންސްޕެކްޓް ކުރެވުނު ތާރީޚާއި ގަޑި:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.time_of_inspection" name="time_of_inspection"></td>
                        </tr>
                        <tr>
                            <td>މަޢުލޫމާތު ދިން ފަރާތް:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.information_provider" name="information_provider"></td>
                            <td>ކުރެވުނު އިންސްޕެކްޝަންގެ އަދަދު:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.number_of_inspections" name="number_of_inspections"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>


            <div class="columns dhivehi">
                <div class="column">
                    <label class="label">ސެކްޝަން 1: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ ކްރިޓިކަލް (ވަގުތުން ރަނގަޅު ކުރަންޖެހޭ) މައްސަލަތައް:</label>
                </div>
            </div>
            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr>
                            <td>#</td>
                            <td>ރިފަރެންސް</td>
                            <td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
                            <td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
                            <td>
                                <button class="button is-success is-outlined" @click="showCriticalNewItemForm = !showCriticalNewItemForm">
                                <span>އާ އަިޓަމެއް</span>
                              </button></td>
                        </tr>
                        <tr v-if="showCriticalNewItemForm">
                            <td><input type="text" class="input" name="no" v-model="newItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="newItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="newItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="newItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click="storePoint('CR')">
                                <span>ރައްކާކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-if="criticalSelectedItem != null">
                            <td><input type="text" class="input" name="no" v-model="criticalSelectedItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="criticalSelectedItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="criticalSelectedItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="criticalSelectedItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click="updatePoint('CR', criticalSelectedItem)">
                                <span>އަދާހަމަ ކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-for="item, index in criticalPoints">
                            <td>{{item.no}}</td>
                            <td>{{item.point_no}}</td>
                            <td>{{item.violation}}</td>
                            <td>{{item.recommendation}}</td>
                            <td width="15%">
                                <button class="button is-danger is-outlined" @click="removePoint('CR', item)">
                                <span>ފުހެލާ</span>
                              </button>
                                <button class="button is-warning is-outlined" @click="criticalSelectedItem = item">
                                <span>ބަދަލުގެނޭ</span>
                              </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="columns dhivehi">
                <div class="column">
                    <label class="label">ސެކްޝަން 2: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ މޭޖަރ (ދެވިފައިވާ މުއްދަތުގައި ރަނގަޅުކުރަން ޖެހޭ) މައްސަލަތައް:</label>
                </div>
            </div>
            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr>
                            <td>#</td>
                            <td>ރިފަރެންސް</td>
                            <td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
                            <td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
                            <td>
                                <button class="button is-success is-outlined" @click="showMajorNewItemForm = !showMajorNewItemForm">
                                <span>އާ އަިޓަމެއް</span>
                              </button></td>
                        </tr>
                        <tr v-if="showMajorNewItemForm">
                            <td><input type="text" class="input" name="no" v-model="newItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="newItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="newItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="newItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click="storePoint('MJ')">
                                <span>ރައްކާކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-if="majorSelectedItem != null">
                            <td><input type="text" class="input" name="no" v-model="majorSelectedItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="majorSelectedItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="majorSelectedItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="majorSelectedItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click="updatePoint('MJ', majorSelectedItem)">
                                <span>އަދާހަމަ ކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-for="item, index in majorPoints">
                            <td>{{item.no}}</td>
                            <td>{{item.point_no}}</td>
                            <td>{{item.violation}}</td>
                            <td>{{item.recommendation}}</td>
                            <td width="15%">
                                <button class="button is-danger is-outlined" @click="removePoint('MJ', item)">
                                <span>ފުހެލާ</span>
                              </button>
                                <button class="button is-warning is-outlined" @click="majorSelectedItem = item">
                                <span>ބަދަލުގެނޭ</span>
                              </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="columns dhivehi">
                <div class="column">
                    <label class="label">ސެކްޝަން 3: އިންސްޕެކްޝަންގައި ފާހަގަ ކުރެވިފައިވާ އެހެނިހެން ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޗަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
                </div>
            </div>
            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr>
                            <td>#</td>
                            <td>ރިފަރެންސް</td>
                            <td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
                            <td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
                            <td>
                                <button class="button is-success is-outlined" @click="showMinorNewItemForm = !showMinorNewItemForm">
                                <span>އާ އަިޓަމެއް</span>
                              </button></td>
                        </tr>
                        <tr v-if="showMinorNewItemForm">
                            <td><input type="text" class="input" name="no" v-model="newItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="newItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="newItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="newItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click="storePoint('MN')">
                                <span>ރައްކާކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-if="minorSelectedItem != null">
                            <td><input type="text" class="input" name="no" v-model="minorSelectedItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="minorSelectedItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="minorSelectedItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="minorSelectedItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click="updatePoint('MN', minorSelectedItem)">
                                <span>އަދާހަމަ ކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-for="item, index in minorPoints">
                            <td>{{item.no}}</td>
                            <td>{{item.point_no}}</td>
                            <td>{{item.violation}}</td>
                            <td>{{item.recommendation}}</td>
                            <td width="15%">
                                <button class="button is-danger is-outlined" @click="removePoint('MN', item)">
                                <span>ފުހެލާ</span>
                              </button>
                                <button class="button is-warning is-outlined" @click="minorSelectedItem = item">
                                <span>ބަދަލުގެނޭ</span>
                              </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <br>
            <div class="columns dhivehi">
                <div class="column">
                    <label class="label">ސެކްޝަން 5: ދުންފަތް ކޮންޓްރޯލް ކުރުމާ ބެހޭ ޤާނޫން (15/2010) ދަށުން ކުރެވުނު އިންސްޕެކްޝަން ގައި ފާހަގަ ކުރެވިފައިވާ ކަންތައްތައް (ދެންކުރެވޭ އިންސްޕެކްޝަންގައި މިކަންކަން ރަނގަޅު ކުރެވިފައިވޭތޯ ބެލޭނެއެވެ.)</label>
                </div>
            </div>
            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr>
                            <td>#</td>
                            <td>ރިފަރެންސް</td>
                            <td>ޗެކްލިސްޓްގައިވާ ޕޮއިންޓް</td>
                            <td>އިންސްޕެކްޝަންގައި ފާހަގަކުރެވުނު ކަންތައް</td>
                            <td>
                                <button class="button is-success is-outlined" @click=tobaccoAddItem>
                                <span>އާ އަިޓަމެއް</span>
                              </button></td>
                        </tr>
                        <tr v-if="tobaccoNewItem != null">
                            <td><input type="text" class="input" name="no" v-model="tobaccoNewItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="tobaccoNewItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="tobaccoNewItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="tobaccoNewItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click=tobaccoStoreItem>
                                <span>ރައްކާކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-if="tobaccoSelectedItem != null">
                            <td><input type="text" class="input" name="no" v-model="tobaccoSelectedItem.no"></td>
                            <td><input type="text" class="input" name="point_no" v-model="tobaccoSelectedItem.point_no"></td>
                            <td><textarea class="textarea" name="violation" v-model="tobaccoSelectedItem.violation"></textarea></td>
                            <td><textarea class="textarea" name="recommendation" v-model="tobaccoSelectedItem.recommendation"></textarea></td>
                            <td width="15%">
                                <button class="button is-success is-outlined" @click=tobaccoUpdateItem>
                                <span>އަދާހަމަ ކުރޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr v-for="item, index in tobaccoItems">
                            <td>{{item.no}}</td>
                            <td>{{item.point_no}}</td>
                            <td>{{item.violation}}</td>
                            <td>{{item.recommendation}}</td>
                            <td width="15%">
                                <button class="button is-danger is-outlined" @click="tobaccoRemoveItem(index)">
                                <span>ފުހެލާ</span>
                              </button>
                                <button class="button is-warning is-outlined" @click="tobaccoEditItem(index)">
                                <span>ބަދަލުގެނޭ</span>
                              </button>
                            </td>
                        </tr>
                        <tr rowspan="2">
                            <td colspan="3">ޤަވާޢިދާއި ޚިލާފް ވުމުން ކުރެވުނު ޖޫރިމަނާ ކުރެވުނު (ޖޫރިމަނާ ސްލިޕްގެ/ސްލިޕްތަކުގެ ނަމްބަރު):</td>
                            <td colspan="2"><input type="text" class="input" name="fine_slip_numbers" v-model="dhivehiReportForm.fine_slip_numbers"></td>
                        </tr>
                    </table>
                </div>
            </div>


<!--             <br>
            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr>
                            <td>ކެޓަގަރީ</td>
                            <td>ރަނގަޅު ކޮށްފައިވާ އަދަދު</td>
                            <td>ރަނގަޅު ކުރަންޖެހޭ އަދަދު</td>
                            <td>އަދަދު NA</td>
                        </tr>
                        <tr>
                            <td >ކްރިޓިކަލް ގެ މުޅި ޖުމްލަ <span style="direction: ltr;">10</span></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.critical_totals.fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.critical_totals.to_be_fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.critical_totals.total"></td>
                        </tr>
                        <tr>
                            <td>މޭޖަރ ގެ މުޅި ޖުމްލަ <span style="direction: ltr;">43</span></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.major_totals.fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.major_totals.to_be_fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.major_totals.total"></td>
                        </tr>
                        <tr>
                            <td>މައިނަ ގެ މުޅި ޖުމްލަ</td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.minor_totals.fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.minor_totals.to_be_fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.minor_totals.total"></td>
                        </tr>
                        <tr>
                            <td>ދުންފަތުގެ އިސްޓިޢުމާލް ކުރުން <span style="direction: ltr;">14</span></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.tobacco_totals.fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.tobacco_totals.to_be_fixed"></td>
                            <td><input class="input" style="direction: ltr;" type="number" v-model="dhivehiReportForm.tobacco_totals.total"></td>
                        </tr>
                    </table>
                </div>
            </div> -->

            <br>
            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr ><th style="direction: rtl;text-align: right;">އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް</th></tr>
                        <tr><td style="text-decoration: underline;">(ހ) ކާބޯތަކެތީގެ ޙިދުމަތް ދިނުމުގައު ހުންނަންޖެހޭ ސާފުތާހިރުކަމުގެ މިންގަނޑުތައް ބަޔާން ކުރާ ގަވާޢިދު (ގަވާއިދު ނަންބަރު: <span style="direction: ltr;">2014/R-380</span>) އެއްގިތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
                        <tr><td>1. ސެކްސަން 1 ގައި ބަޔާން ކުރެވިފައިވާ ކަންތައްތައް ވަގުތުން ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_1"></td></tr>
                        <tr><td>2. ސެކްސަން 2 ގައި ބަޔާންކުރެވިފައިވާ ކަންތައް<input type="number" v-model="dhivehiReportForm.food_conclusion_2_days"> ދުވަހުގެ ތެރޭގައި ރަނގަޅުކުރަން އެންގުން &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_2"></td></tr>
                        <tr><td>3. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_3">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" v-model="dhivehiReportForm.food_conclusion_3_date"></td></tr>
                        <tr><td>4. ތަން ބަންދުކުރުމަށް ފެނޭ &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_4"></td></tr>
                        <tr><td>5. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_5"></td></tr>
                        <tr><td>6. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" v-model="dhivehiReportForm.food_conclusion_6_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" v-model="dhivehiReportForm.food_conclusion_6"></td></tr>
                        <tr><td style="text-decoration: underline;">(ށ)‫ދުންފަތ‬ ‫ކޮންޓްރޯލ‬ ‫ކުރުމ‬ާ ބެހޭ ޤާނޫން (<span style="direction: ltr;">15/2010</span>) އާއި އެއްގިތްވާ ގޮތުގެ މަތިން ކުރެވުނު އިންސްޕެކްޝަންގައި ނިންމުނު ގޮތް:</td></tr>
                        <tr><td>1. އިތުރު އިންސްޕެކްޝަނެއް ހެދުމަށް ފެނޭ &nbsp<input type="checkbox" v-model="dhivehiReportForm.tobacco_conclusion_1">އިނސްޕެކްޓް ކުރަން ހުޝަހަޅާ ތާރީޚް<input type="text" v-model="dhivehiReportForm.tobacco_conclusion_1_date"></td></tr>
                        <tr><td>2. އެޕްލިކޭޝަން ބާތިލްވެފައިވާތީ އަލުން ހުށަހެޅުމަށް &nbsp<input type="checkbox" v-model="dhivehiReportForm.tobacco_conclusion_2"></td></tr>
                        <tr><td>3. ހުއްދައިގެ / ޖުރުމަނާ ފައިސާ (އަދަދު:<input type="text" v-model="dhivehiReportForm.tobacco_conclusion_3_amount">) ދެއްކި ކަމުގެ ރަސީދު އެޓޭޗް ކުރެވިފައި &nbsp<input type="checkbox" v-model="dhivehiReportForm.tobacco_conclusion_3"></td></tr>
                    </table>
                </div>
            </div>
            <br>


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
                            <td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_1"></td>
                            <td colspan="2">1. ގަވާއިދަށް ފެތޭތީ ހުއްދަ ދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_1"></td>
                        </tr>
                        <tr>
                            <td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_2"></td>
                            <td colspan="2">2. ފުރިހަމަ ކުރަންޖެހޭ ކަންތައްތައް ފުރިހަމަ ނުވާތީ ހުއްދަ ނުދިނުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_2"></td>
                        </tr>
                        <tr>
                            <td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" v-model="dhivehiReportForm.phi_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_3"></td>
                            <td colspan="2">3. ފޮލޯއަޕް އިންސްޕެކްޝަނެއް <input type="text" v-model="dhivehiReportForm.tpcs_head_conclusion_3_date"> ގައި ހެދުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_3"></td>
                        </tr>
                        <tr>
                            <td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.phi_head_conclusion_4"></td>
                            <td colspan="2">4. ގަވާއިދާ ޚިލާފުވެފައިވާތީ ބަންދުކުރުމަށް&nbsp<input type="checkbox" v-model="dhivehiReportForm.tpcs_head_conclusion_4"></td>
                        </tr>
                        <tr>
                            <td>ނަން:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.phi_head_name"></td>
                            <td>ނަން:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.tpcs_head_name"></td>
                        </tr>
                        <tr>
                            <td>ސޮއި:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.phi_head_sign"></td>
                            <td>ސޮއި:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.tpcs_head_sign"></td>
                        </tr>
                        <tr>
                            <td>ތާރީޚް</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.phi_head_date"></td>
                            <td>ތާރީޚް</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.tpcs_head_date"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>

            <div class="columns dhivehi">
                <div class="column">
                    <table class="table is-bordered">
                        <tr>
                            <th colspan="2" style="direction: rtl;text-align: right;">‫‫‪ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަނުގެ ފަރާތުން</th>
                            <th colspan="2" style="direction: rtl;text-align: right;">ހެލްތު ޕްރޮޓެކްޝަން އެޖެންސީގެ ފަރާތުން</th>
                        </tr>
                        <tr>
                            <td>ނަން:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_business_name"></td>
                            <td>ނަން:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_name"></td>
                        </tr>
                        <tr>
                            <td>މަޤާމް:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_business_position"></td>
                            <td>މަޤާމް:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_position"></td>
                        </tr>
                        <tr>
                            <td>ސޮއި:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_business_sign"></td>
                            <td>ސޮއި:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_sign"></td>
                        </tr>
                        <tr>
                            <td>ތާރީޚް:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_business_date"></td>
                            <td>ތާރީޚް:</td>
                            <td><input type="text" class="input" v-model="dhivehiReportForm.from_hpa_date"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>

        </div>


        <br>
        <div class="columns" v-if="statusChangeStatus">
            <div class="column">
                <div class="notification" :class="statusChangeColor">{{statusChangeStatus}}</div>
            </div>
        </div>


        <div class="columns">
            <div class="column"></div>
            <div class="column center dhivehi">
                <button class="button is-success is-large" @click=sendForProcessing>
                    <span>ޕްރޮސެސިން އަށް ފޮނުވާ</span>
                </button>
                <button class="button is-warning is-large" @click=saveDhivehiReportForm>
                <span>ރައްކާކުރޭ</span>
              </button>
                <router-link class="button is-info is-large" v-can="'api.dhivehi-reports.show'" :to="{ name: 'dhivehi-reports.show', params: { reportId: reportId }}">
                    <span>ޕްރިންޓް</span>
                </router-link>
            </div>
            <div class="column"></div>
        </div>
    </div>
</template>

<script>

import Grid from '../../Grid';

export default {
    props: ['reportId'],
    data() {
        return {
            points: [],
            criticalPoints:[],
            majorPoints:[],
            minorPoints:[],
            showCriticalNewItemForm: false,
            showMajorNewItemForm: false,
            showMinorNewItemForm: false,
            newItem: {
                'type': null,
                'no': null,
                'code': null,
                'point_no': null,
                'violation': null,
                'recommendation': null,
            },
            statusChangeStatus: null,
            statusChangeColor: 'is-success',
            criticalItems: [],
            criticalSelectedItem: null,

            majorItems: [],
            majorSelectedItem: null,
            minorItems: [],
            minorSelectedItem: null,
            tobaccoGrid: new Grid(['no', 'reference', 'violation', 'recommendation']),
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
                food_conclusion_2_days: null,
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
        this.init()
    },
    methods: {
        /**general methods start**/
        init() {
            this.getReport();
        },
        sendForProcessing() {
            axios
              .patch('/api/dhivehi/reports/'+ this.reportId +'/status/pending')
            .then(response => {
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToReport();
            }).catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
                this.getReport();
            });
        },
        goToReport() {
            this.$router.push({ name: 'dhivehi-reports.show', params: { reportId: this.reportId } })
        },
        getReport() {
            axios.get('/api/dhivehi/reports/' + this.reportId)
            .then(response => {
                this.setDhivehiReportFormFromResponse(response.data);
            })
            .catch(errors => {
                console.log(errors);
            });
        },
        setDhivehiReportFormFromResponse(data) {
            this.dhivehiReportForm.purpose = data.purpose;

            this.dhivehiReportForm.place_name_address = data.place_name_address;
            this.dhivehiReportForm.place_owner_name_address = data.place_owner_name_address;
            this.dhivehiReportForm.phone = data.phone;
            this.dhivehiReportForm.information_provider = data.information_provider;
            this.dhivehiReportForm.time_of_inspection = data.time_of_inspection;
            this.dhivehiReportForm.number_of_inspections = data.number_of_inspections;

            this.points = data.points;
            this.setCriticalPoints();
            this.setMajorPoints();
            this.setMinorPoints();
            this.setTobaccoItems(data.tobacco);

            this.dhivehiReportForm.fine_slip_numbers = data.fine_slip_numbers;

            this.setCriticalTotals(data.critical_totals);
            this.setMajorTotals(data.major_totals);
            this.setMinorTotals(data.minor_totals);
            this.setTobaccoTotals(data.tobacco_totals);

            this.dhivehiReportForm.food_conclusion_1 = data.food_conclusion_1;
            this.dhivehiReportForm.food_conclusion_2 = data.food_conclusion_2;
            this.dhivehiReportForm.food_conclusion_2_days = data.food_conclusion_2_days;
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
            this.updateDhivehiFormTobacco();
        },

        saveDhivehiReportForm() {
            this.prepareDhivehiReportForm();
            // this.dhivehiReportForm.patch('/dhivehi/reports/' + this.reportId)
            axios.patch('/api/dhivehi/reports/' + this.reportId, this.dhivehiReportForm)
            .then(response => {
                this.setDhivehiReportFormFromResponse(response.data);
            })
            .catch(errors => {
                console.log('errors', errors);
            });
        },

        setCriticalPoints() {
            this.criticalPoints = this.points.filter(function(point) {
                if(point.code == 'CR') {
                    return point;
                }
            });
        },
        setMajorPoints() {
            this.majorPoints = this.points.filter(function(point) {
                if(point.code == 'MJ') {
                    return point;
                }
            });
        },
        setMinorPoints() {
            this.minorPoints = this.points.filter(function(point) {
                if(point.code == 'MN') {
                    return point;
                }
            });
        },

        handOverDhivehiReportForm() {

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
        resetNewItem() {
            this.newItem =  {
                'type': null,
                'no': null,
                'code': null,
                'point_no': null,
                'violation': null,
                'recommendation': null,
            };
        },

        resetSelectedItem(selectedItem) {
            selectedItem =  {
                'no': null,
                'point_no': null,
                'violation': null,
                'recommendation': null,
            };
        },

        storePoint(type) {
            this.newItem.code = type;
            axios.post('/api/dhivehi-reports/'+this.reportId+'/points', this.newItem)
                .then((response) => {
                    this.refreshPointsBlock(type);
                    this.resetNewItem();
                })
                .catch(errors => console.log(response));
        },
        updatePoint(type, point) {
            axios.patch('/api/dhivehi-reports/'+this.reportId+'/points/' + point.id, point)
                .then((response) => {
                    this.refreshPointsBlock(type);
                    this.refreshSelectedItem(type);
                })
                .catch(errors => console.log(response));
        },
        removePoint(type, point) {
            if (!confirm('are you sure you want to delete this?')) return;

            axios.delete('/api/dhivehi-reports/'+this.reportId+'/points/' + point.id)
                .then((response) => {
                    this.refreshPointsBlock(type);
                })
                .catch(errors => console.log(response));
        },
        refreshPointsBlock(type) {
            axios.get('/api/dhivehi-reports/'+this.reportId+'/points?type=' + type)
                .then((response) => {
                    switch(type) {
                      case 'CR':
                        this.criticalSelectedItem = response.data;
                        break;
                      case 'MJ':
                        this.majorSelectedItem = response.data;
                        break;
                      case 'MN':
                        this.minorSelectedItem = response.data;
                        break;
                      default:
                    }
                })
                .catch(errors => console.log(response));
        },
        refreshSelectedItem(type) {
            switch(type) {
              case 'CR':
                this.resetSelectedItem(this.criticalSelectedItem);
                break;
              case 'MJ':
                this.resetSelectedItem(this.majorSelectedItem);
                break;
              case 'MN':
                this.resetSelectedItem(this.minorSelectedItem);
                break;
            }
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
            this.tobaccoUpdateApi();
            this.tobaccoNewItem = null;
        },
        tobaccoRemoveItem(index) {
            this.tobaccoGrid.remove(index);
            this.tobaccoUpdateApi();
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
            this.tobaccoUpdateApi();
            this.setTobaccoItems();
        },
        updateDhivehiFormTobacco() {
            this.dhivehiReportForm.tobacco = this.tobaccoGrid.getItems();
        },
        tobaccoUpdateApi() {
            // this.updateDhivehiFormMajor();
            this.saveDhivehiReportForm();
        }
        /**
         * End of Critical, Major, Minor, Tobacco Store, Update and Delete
         * used general methods saveDhivehiReportForm and prepareDhivehiReportForm
         */
    }
}
</script>


<style scoped>
    table td:not([align]), table th:not([align]) {
    text-align: right;
    }
</style>