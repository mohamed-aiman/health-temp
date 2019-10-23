<template>
    <b-datepicker @input="dateChanged" placeholder="Click to select..." icon="calendar-today" editable v-model="date"></b-datepicker>
</template>

<script>
    export default {
        data() {
            return {
                date: new Date(),
                exportFormat: 'YYYY-MM-DD HH:mm:ss'
            }
        },
        mounted() {
            this.dateChanged(this.date);
        },
        methods: {
            dateChanged(date) {
                const formatted = moment(date).format(this.exportFormat);
                this.$emit('dateSelected', formatted);
            }
        }
    }
</script>
