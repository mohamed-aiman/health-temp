<template>
<div class="container" v-can="'api.inspections.index'">
	<div class="columns box">
		<div class="column">
			<div class="field">
			  <label class="label">Select Business</label>
			  <div class="control">
			  </div>
			</div>
		</div>
	</div>
	<br>
	<div class="columns box">
		<div class="column">
			<div class="field">
			  <label class="label">Select Business</label>
			  <div class="control">
					<input class="input" type="text" v-model="form.businessesSearchTerm">
			  </div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
	
export default {
	data() {
        return {
        	businesses: [],
	        form: new Form({
	            businessesSearchTerm: ""
	        })
	    }
    },
	watch: {
          'form.businessesSearchTerm': _.debounce(function(){
              this.searchBusinesses();
          }, 700),
    },
    mounted() {
        this.searchBusinesses();
    },
    methods: {
        searchBusinesses() {
            axios
              .get('/api/businesses/search?term=' + this.businessesSearchTerm)
            .then(response => {
                this.businesses = response.data;
            })
            .catch(error => console.log(error));
        },
        onSubmit() {
            this.form.post('/inspections')
                .then(data => {
                    this.$router.push({ name: 'inspections.show', params: { inspectionId: data.id } })
                })
                .catch(errors => console.log(errors));
        }
    }
}
</script>