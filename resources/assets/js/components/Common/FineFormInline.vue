<template>
    <div class="columns">
        <div class="column">
            <response-messages :response="response"></response-messages>
            <table class="table">
                <tr>
                    <td colspan="4">
                        <div class="label is-normal">
                            <label class="label">{{headingDisplay}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="columns">
                            <div class="column">
                                <div class="field"><label class="label">Fine Type: </label>
                                    <div class="select dhivehi">
                                        <select v-model="form.fine_type_id">
                                            <option v-for="option in fineTypes" v-bind:value="option.id">
                                            {{ option.description }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <div class="field"><label class="label">Amount(MVR): </label><input type="number" name="amount" v-model="form.amount" class="input">
                                </div>
                            </div>
                            <div class="column">
                                <div class="field"><label class="label">Fined On: </label><date-picker @dateSelected="finedOnDateSelected"></date-picker>
                                </div>
                            </div>
                            <div class="column">
                              <b-field label="Upload File">
                              </b-field>
                              <b-field class="file">
                                    <template>
                                        <b-field class="file">
                                            <b-upload  v-model="form.file">
                                                <a class="button is-primary is-small">
                                                    <b-icon icon="upload"></b-icon>
                                                </a>
                                            </b-upload>
                                            <span class="file-name is-small" v-if="form.file" style="color:grey;border: none;">
                                                {{ form.file.name }}
                                            </span>
                                        </b-field>    
                                    </template>
                              </b-field>
                            </div>
                            <div class="column">
                                <div class="field"><label class="label">Fine Slip No: </label><input type="text" name="fine_slip_no" v-model="form.fine_slip_no" class="input">
                                </div>
                            </div>
                            <div class="column">
                                <div class="field"><label class="label">Remarks: </label><input type="text" name="remarks" v-model="form.remarks" class="input">
                                </div>
                            </div>
                            <div class="column">
                                <br>
                                <div class="control is-pulled-right">
                                    <button class="button is-link is-vcentered" @click="save()">Save</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import { inlineFormPost } from '../../mixins/inlineFormPost';
    
    export default {
        props: {
            inspectionId: {
                type: Number | String
            },
            heading: {
                type: String
            }
        },
        mixins: [ inlineFormPost ],
        data() {
            return {
                headingDisplay: 'Add New Fine',
                fineTypes: [],
                form: {
                    amount: null,
                    fined_on: null,
                    fine_slip_no: null,
                    remarks: null,
                    fine_type_id: null,
                    file: null,
                },
                response: {}
            }
        },
        mounted() {
            this.setOptions();
            this.getFineTypes();
        },
        watch: {
            'form.fine_type_id': function() {
                this.autoFillUsingFineType()
            }
        },
        methods: {
            setOptions() {
                if (this.heading) {
                    this.headingDisplay = this.heading;
                }
            },
            getFineTypes() {
              if (this.hasPermission('api.fine-types.index')) {
                  axios
                  .get('/api/fine-types')
                  .then(response => {
                      this.fineTypes = response.data;
                  })
                  .catch(errors => console.log(errors));
              }
            },
            autoFillUsingFineType() {
                let selectedFineType = this.fineTypes.find(function(fineType) {
                    return fineType.id == this.form.fine_type_id;
                }, this)

                this.form.amount = selectedFineType.amount;
            },
            finedOnDateSelected(formatedDate) {
                this.form.fined_on = formatedDate;
            },
            save() {
                const fd = new FormData();
                fd.set('amount', this.form.amount);
                fd.set('fined_on', this.form.fined_on);
                fd.set('fine_slip_no', this.form.fine_slip_no);
                fd.set('remarks', this.form.remarks);
                fd.set('fine_type_id', this.form.fine_type_id);
                fd.append('image', this.form.file, this.form.file.name);
                this.postForm('/api/inspections/' + this.inspectionId + '/fines', fd , 'Error creating new fine: ')
            }
        }
    }
</script>
