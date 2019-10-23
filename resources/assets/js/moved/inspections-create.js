const app = new Vue({
    el: "#app",
    data: {
        businesses: [],
        form: new Form({
            businessesSearchTerm: ""
        })
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
                console.log(response.data);
            })
            .catch(error => console.log(error));
        },
        onSubmit() {
            this.form.post('/inspections')
                .then(data => {
                    console.log(data);
                    window.location.href= '/inspections/' + data.id;
                })
                .catch(errors => console.log(errors));
        }
    }
});