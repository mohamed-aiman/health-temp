<template>
    <input type="date" v-model="dateTime" :id="id"/>
</template>

<script>
    export default {
        props: {
            id: {
                type: String
            }
        },
        data() {
            return {
                dateTime: new Date(),
                dateFormat: 'MM/DD/YYYY',
                timeFormat: 'HH:mm',
                exportFormat: 'YYYY-MM-DD HH:mm:ss'
            }
        },
        computed: {
            dateTimeFormat() {
                return this.dateFormat + ' ' + this.timeFormat;
            }
        },
        mounted() {
            const element = document.querySelector('#' + this.id);

            bulmaCalendar.attach(element,  {
                startDate: this.dateTime,
                type: 'datetime',
                dateFormat: this.dateFormat,
                timeFormat: this.timeFormat,
                validateLabel: 'OK'
            });

            if (element) {
                element.bulmaCalendar.on('select', datepicker => {
                    const formatted = moment(datepicker.data.value(), this.dateTimeFormat).format(this.exportFormat);
                    this.$emit('dateTimeSelected', formatted);
                });
            }
        }
    }
</script>
