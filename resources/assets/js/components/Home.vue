<template>
	<div>
		<template id="search">
			<div class="columns" v-can="'api.businesses.search'">
				<div class="column is-fullwidth">
					<div class="field">
					  <label class="label">Search for a business</label>
					  <div class="control">
					    <input class="input" name="businessesSearchTerm" type="text" v-model="businessesSearchTerm" placeholder="Business name or registration no or phone">
					  </div>
					</div>
					<template id="search-results" v-if="businesses.length > 0">
					<table  class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
						<tr>
							<td>Name</td>
							<td>Registration No.</td>
						</tr>
						<template v-for="item in businesses">
							<tr @click="goToBusiness(item.id)">
								<td>{{item.name}}</td>
								<td>{{item.registration_no}}</td>
							</tr>
						</template>
					</table>
					</template>
				</div>
			</div>
		</template>
		<template id="license-lists">
			<section class="hero is-warning" v-can="'api.businesses.expiringsoon'" v-if="expiringBusinesses.length>0">
			  <div class="hero-body">
				<h2 class="subtitle">Expiring Soon Businesses</h2>
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr>
							<th>Name</th>
							<th>Name (dhivehi)</th>
							<th>Phone</th>
							<th>Registration No</th>
							<th>Expires On</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="item,key in expiringBusinesses">
							<tr @click="goToBusiness(item.id)">
								<td>{{item.name}}</td>
								<td>{{item.name_dv}}</td>
								<td>{{item.phone}}</td>
								<td>{{item.registration_no}}</td>
								<td>{{item.expire_at}}</td>
							</tr>
						</template>
					</tbody>
				</table>
			    <b-pagination
			        :total="pagination1.total"
			        :current.sync="pagination1.current"
			        :order="pagination1.order"
			        :size="pagination1.size"
			        :simple="pagination1.isSimple"
			        :rounded="pagination1.isRounded"
			        :per-page="pagination1.perPage"
			        @change="pageChange1">
			    </b-pagination>
			  </div>
			</section>
			<br>
			<section class="hero is-danger" v-can="'api.businesses.expired'" v-if="expiredBusinesses.length>0">
			  <div class="hero-body">
				<h2 class="subtitle">Expired Businesses</h2>
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr>
							<th>Name</th>
							<th>Name (dhivehi)</th>
							<th>Phone</th>
							<th>Registration No</th>
							<th>Expired On</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="item,key in expiredBusinesses">
							<tr>
								<td>{{item.name}}</td>
								<td>{{item.name_dv}}</td>
								<td>{{item.phone}}</td>
								<td>{{item.registration_no}}</td>
								<td>{{item.expire_at}}</td>
								<td>
									<div class="is-pulled-right">
										<a class="button is-small" v-can="'api.businesses.show'" @click="goToBusiness(item.id)">
							        <b-icon type="is-success" size="is-small" pack="fas" icon="eye"></b-icon>
							 	    </a>
										<close-establishment-modal :business="item" @refresh="getExpiredBusinesses"></close-establishment-modal>
										<new-fine-modal v-can="'api.businesses.fines.store'" :business="item"></new-fine-modal>
									</div>
								</td>
							</tr>
						</template>
					</tbody>
				</table>
			    <b-pagination
			        :total="pagination2.total"
			        :current.sync="pagination2.current"
			        :order="pagination2.order"
			        :size="pagination2.size"
			        :simple="pagination2.isSimple"
			        :rounded="pagination2.isRounded"
			        :per-page="pagination2.perPage"
			        @change="pageChange2">
			    </b-pagination>
			  </div>
			</section>
		</template>

		<template id="inspection-lists">
			<br>
			<section class="hero is-warning" v-can="'api.inspections.upcoming'" v-if="upcomingInspections.length>0">
			  <div class="hero-body">
				<h2 class="subtitle">Upcoming Inspections</h2>
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr>
							<th>Name</th>
							<th>Name (dhivehi)</th>
							<th>Phone</th>
							<th>Registration No</th>
							<th>Expires On</th>
							<th>Inspection At</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="item,key in upcomingInspections">
							<tr @click="goToBusiness(item.business.id)">
								<td>{{item.business.name}}</td>
								<td>{{item.business.name_dv}}</td>
								<td>{{item.business.phone}}</td>
								<td>{{item.business.registration_no}}</td>
								<td>{{item.business.expire_at}}</td>
								<td>{{item.inspection_at}}</td>
							</tr>
						</template>
					</tbody>
				</table>
			    <b-pagination
			        :total="pagination4.total"
			        :current.sync="pagination4.current"
			        :order="pagination4.order"
			        :size="pagination4.size"
			        :simple="pagination4.isSimple"
			        :rounded="pagination4.isRounded"
			        :per-page="pagination4.perPage"
			        @change="pageChange4">
			    </b-pagination>
			  </div>
			</section>
			<br>
		</template>

		<template id="grading-lists">
			<br>
			<section class="hero is-warning" v-can="'api.grading-inspections.upcoming'"v-if="upcomingGradingInspections.length>0">
			  <div class="hero-body">
				<h2 class="subtitle">Upcoming Grading Inspections</h2>
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr>
							<th>Name</th>
							<th>Name (dhivehi)</th>
							<th>Phone</th>
							<th>Registration No</th>
							<th>Expires On</th>
							<th>Inspection At</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="item,key in upcomingGradingInspections">
							<tr @click="goToGradingInspection(item.id)">
								<td>{{item.business.name}}</td>
								<td>{{item.business.name_dv}}</td>
								<td>{{item.business.phone}}</td>
								<td>{{item.business.registration_no}}</td>
								<td>{{item.business.expire_at}}</td>
								<td>{{item.inspection_at}}</td>
							</tr>
						</template>
					</tbody>
				</table>
			    <b-pagination
			        :total="pagination3.total"
			        :current.sync="pagination3.current"
			        :order="pagination3.order"
			        :size="pagination3.size"
			        :simple="pagination3.isSimple"
			        :rounded="pagination3.isRounded"
			        :per-page="pagination3.perPage"
			        @change="pageChange3">
			    </b-pagination>
			  </div>
			</section>
			<br>
		</template>
	</div>
</template>

<script>
import _ from 'lodash';
import CloseEstablishmentModal from './Common/CloseEstablishmentModal';
import NewFineModal from './Common/NewFineModal';

export default {
	components: {
		'close-establishment-modal' : CloseEstablishmentModal,
		'new-fine-modal' : NewFineModal,
	},
	data() {
		return {
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
		}
	},
	watch: {
	  	businessesSearchTerm: _.debounce(function(){
	  			this.businesses = [];
		  		this.searchBusinesses();
	  	}, 700),
	},
	mounted() {
		this.getExpiringBusinesses();
		this.getExpiredBusinesses();
		this.getUpcomingGradingInspections();
		this.getUpcomingInspections();
	},
	methods: {
		searchBusinesses() {
			axios
		  .get('/api/businesses/search?term=' + this.businessesSearchTerm + '&found=false')
			.then(response => {
				this.businesses = response.data;
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
					this.expiredBusinesses = response.data.data;
					this.setPagination2(response.data);
				})
				.catch(errors => console.log(errors));	
        },
        goToBusiness(id) {
        	this.$router.push({ name: 'businesses.show', params: { businessId: id } })
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
					this.upcomingGradingInspections = response.data.data;
					this.setPagination3(response.data);
				})
				.catch(errors => console.log(errors));	
        },
        goToGradingInspection(id) {
        	this.$router.push({ name: 'grading-inspections.gradingforms.show', params: { gradingFormId: id } })
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
};
</script>