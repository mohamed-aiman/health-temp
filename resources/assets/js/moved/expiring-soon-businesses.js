const app = new Vue({
    el: "#app",
    data: {
        businesses: [],
        pagination: {
            total: 200,
            current: 1,
            perPage: 100,
            order: '',
            size: '',
            isSimple: false,
            isRounded: false,
        },
    },
  watch: {
    },
    mounted() {
        this.getbusinesses();
    },
    methods: {
        getbusinesses(page = 1) {
            axios
              .get('/api/businesses/expiringsoon?'
                  + 'page=' + page
                  )
            .then(response => {
                this.businesses = response.data.data;
                this.setPagination(response.data);
            })
            .catch(errors => console.log(errors));
        },
        pageChange (page) {
            this.current = page
            // this.filter.offset = ((this.current - 1) * this.filter.limit)
            this.getbusinesses(page);
        },
        setPagination(data) {
            this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
        },
    }
});