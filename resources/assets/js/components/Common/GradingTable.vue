<template>
	<table class="table is-bordered dhivehi">
    <tr>
      <td colspan="5"><b>ދަރަޖަކުރުން</b></td>
    </tr>
    <tr>
        <td>ކެޓަގަރީ</td>
        <td>ޖުމްލަ އަދަދު</td>
        <td>ރަނގަޅު ކޮށްފައިވާ އަދަދު</td>
        <td>ރަނގަޅު ކުރަންޖެހޭ އަދަދު</td>
        <td>އަދަދު NA</td>
    </tr>
    <tr>
        <td >ކްރިޓިކަލް ގެ މުޅި ޖުމްލަ </td>
        <td>{{(gradingCalculated.counts.total.CR) ? gradingCalculated.counts.total.CR : 0 }}</td>
        <td>{{(gradingCalculated.counts.satisfied.CR) ? gradingCalculated.counts.satisfied.CR : 0 }}</td>
        <td>{{(gradingCalculated.counts.not_satisfied.CR) ? gradingCalculated.counts.not_satisfied.CR : 0 }}</td>
        <td>{{(gradingCalculated.counts.not_applicable.CR) ? gradingCalculated.counts.not_applicable.CR : 0 }}</td>
    </tr>
    <tr>
        <td>މޭޖަރ ގެ މުޅި ޖުމްލަ </td>
        <td>{{(gradingCalculated.counts.total.MJ) ? gradingCalculated.counts.total.MJ : 0 }}</td>
        <td>{{(gradingCalculated.counts.satisfied.MJ) ? gradingCalculated.counts.satisfied.MJ : 0 }}</td>
        <td>{{(gradingCalculated.counts.not_satisfied.MJ) ? gradingCalculated.counts.not_satisfied.MJ : 0 }}</td>
        <td>{{(gradingCalculated.counts.not_applicable.MJ) ? gradingCalculated.counts.not_applicable.MJ : 0 }}</td>
    </tr>
    <tr>
        <td>މައިނަރ ގެ މުޅި ޖުމްލަ</td>
        <td>{{(gradingCalculated.counts.total.MN) ? gradingCalculated.counts.total.MN : 0 }}</td>
        <td>{{(gradingCalculated.counts.satisfied.MN) ? gradingCalculated.counts.satisfied.MN : 0 }}</td>
        <td>{{(gradingCalculated.counts.not_satisfied.MN) ? gradingCalculated.counts.not_satisfied.MN : 0 }}</td>
        <td>{{(gradingCalculated.counts.not_applicable.MN) ? gradingCalculated.counts.not_applicable.MN : 0 }}</td>
    </tr>
    <tr>
        <td>ދަރަޖަ</td>
        <td colspan="5" v-bind:class="[getGradngColor(gradingCalculated.grade)]">
          {{(gradingCalculated.grade == 'FAIL') ? 'ގްރޭޑަށް ނުފެތޭ' : gradingCalculated.grade}}
        </td>
    </tr>
  </table>
</template>

<script>
	  export default {
		  props: ['gradingCalculated'],
		  data() {
		  	return {
		  	}
		  },
		  methods: {
  	    getGradngColor(grade) {
		      switch(grade) {
		        case 'A':
		          return 'has-background-success has-text-dark';
		        case 'B':
		          return 'is-purple has-text-dark';
		        case 'C':
		          return 'is-warning has-text-dark';
		        case 'FAIL':
		          return 'is-orange has-text-dark';
		        default:
		          return 'is-orange has-text-dark';
		      }
		    }
			}
    }
</script>

<style scoped>
  table.dhivehi td:not([align]), table.dhivehi th:not([align]) {
	  text-align: right;
  }
</style>