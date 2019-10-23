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
                                <div class="field"><label class="label">Reason:</label> <input type="text" name="reason" v-model="form.reason" class="input">
                                </div>
                            </div>
                            <div class="column">
                                <div class="field"><label class="label">Terminated On:</label> <date-picker @dateSelected="terminatedOnDateSelected"></date-picker>
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
            businessId: {
                type: Number | String
            },
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
                headingDisplay: 'Termination',
                form: {
                    reason: null,
                    terminated_on: null,
                    inspection_id: null
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
            terminatedOnDateSelected(formatedDate) {
                this.form.terminated_on = formatedDate;
            },
            save() {
                this.form.inspection_id = (this.inspectionId) ? this.inspectionId : null;
                this.postForm('/api/businesses/' + this.businessId + '/terminate', this.form , 'Error creating new termination: ')
            }
        }
    }
</script>
