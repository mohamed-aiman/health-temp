	const app = new Vue({
		el: "#app",
		data: {
			businessesSearchTerm: null,
			businesses: [],
			business: {},
			business_id: null,
            expiringBusinesses: [],
            expiredBusinesses: [],
            upcomingGradingInspections: [],
            upcomingInspections: [],
	        pagination1: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
			},
			pagination2: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
			},
			pagination3: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
			},
			pagination4: {
	            total: 200,
	            current: 1,
	            perPage: 100,
	            order: '',
	            size: '',
	            isSimple: false,
	            isRounded: false,
			}
		},
		watch: {
		  	businessesSearchTerm: _.debounce(function(){
		  		// if (this.businessesSearchTerm) {
		  			this.businesses = [];
			  		this.searchBusinesses();
		  		// }
		  	}, 700),
		},
		mounted() {
			// this.searchBusinesses();
			this.getExpiringBusinesses();
			this.getExpiredBusinesses();
			this.getUpcomingGradingInspections();
			this.getUpcomingInspections();
		},
		methods: {
			searchBusinesses() {
				axios
			  .get('/api/businesses/search?term=' + this.businessesSearchTerm + '&found=true')
				.then(response => {
					this.businesses = response.data;
					console.log(response.data);
				})
				.catch(error => console.log(error));
			},
			getExpiringBusinesses(page = 1) {
                axios
		  		.get('/api/businesses/expiringsoon'
		  			+ '?months=1'
		  			+ '&page=' + page
		  			)
					.then(response => {
						console.log(response.data);
						this.expiringBusinesses = response.data.data;
						this.setPagination1(response.data);
					})
					.catch(errors => console.log(errors));	
            },
            getExpiredBusinesses(page = 1) {
                axios
		  		.get('/api/businesses/expired' 
		  			+ '?page=' + page
		  			)
					.then(response => {
						console.log(response.data);
						this.expiredBusinesses = response.data.data;
						this.setPagination2(response.data);
					})
					.catch(errors => console.log(errors));	
            },
            goToBusiness(id) {
            	window.location.href="/businesses/" + id;
            },
            pageChange1(page) {
			    this.current = page
			    // this.filter.offset = ((this.current - 1) * this.filter.limit)
			    this.getExpiringBusinesses(page);
            },
            pageChange2(page) {
			    this.current = page
			    // this.filter.offset = ((this.current - 1) * this.filter.limit)
			    this.getExpiredBusinesses(page);
            },
			setPagination1(data) {
				this.pagination1.total = data.total
	            this.pagination1.current = data.current_page
	            this.pagination1.perPage = data.per_page
			},
			setPagination2(data) {
				this.pagination2.total = data.total
	            this.pagination2.current = data.current_page
	            this.pagination2.perPage = data.per_page
			},
			getUpcomingGradingInspections(page = 1) {
                axios
		  		.get('/api/gradinginspections/upcoming'
		  			+ '?months=1'
		  			+ '&page=' + page
		  			)
					.then(response => {
						console.log(response.data);
						this.upcomingGradingInspections = response.data.data;
						this.setPagination3(response.data);
					})
					.catch(errors => console.log(errors));	
            },
            goToGradingInspection(id) {
            	window.location.href="/gradinginspections/" + id + "/gradingforms";
            },
            pageChange3(page) {
			    this.current = page;
			    this.getUpcomingGradingInspections(page);
            },
			setPagination3(data) {
				this.pagination3.total = data.total
	            this.pagination3.current = data.current_page
	            this.pagination3.perPage = data.per_page
			},
			getUpcomingInspections(page = 1) {
                axios
		  		.get('/api/inspections/upcoming'
		  			+ '?page=' + page
		  			)
					.then(response => {
						console.log(response.data);
						this.upcomingInspections = response.data.data;
						this.setPagination4(response.data);
					})
					.catch(errors => console.log(errors));	
			},
            pageChange4(page) {
			    this.current = page;
			    this.getUpcomingInspections(page);
            },
			setPagination4(data) {
				this.pagination4.total = data.total
	            this.pagination4.current = data.current_page
	            this.pagination4.perPage = data.per_page
			}
		}
	});