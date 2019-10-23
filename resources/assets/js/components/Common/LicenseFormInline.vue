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
                    <td colspan="6">
                        <div class="columns">
                            <div class="column">
                                <div class="field"><label class="label">Issued Date:</label> <date-picker @dateSelected="issuedDateSelected"></date-picker>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field"><label class="label">Expiry Date:</label> <date-picker @dateSelected="expiryDateSelected"></date-picker>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field"><label class="label">License No:</label>
                                    <div class="control">
                                        <input type="text" placeholder="license_no" class="input" v-model="form.license_no">
                                    </div>
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
            applicationId: {
                type: Number | String
            },
            heading: {
                type: String
            }
        },
        mixins: [inlineFormPost],
        data() {
            return {
                headingDisplay: 'Issue New License / Update Existing',
                form: {
                    issued_date: null,
                    expiry_date: null,
                    license_no: null
                },
                response: {}
            }
        },
        mounted() {
            this.setOptions();
        },
        methods: {
            setOptions() {
                if (this.heading) {
                    this.headingDisplay = this.heading;
                }
            },
            issuedDateSelected(formattedDate) {
                this.form.issued_date = formattedDate;
            },
            expiryDateSelected(formattedDate) {
                this.form.expiry_date = formattedDate;
            },
            save() {
                this.postForm('/api/applications/'+this.applicationId+'/licenses', this.form , 'Error issueing license: ')
            }
        }
    }
</script>
