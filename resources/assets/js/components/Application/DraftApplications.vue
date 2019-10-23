<template>
  <div v-can="'api.applications.draft'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Draft Applications
          </h1>
      </div>
    </div>
    <div>
      <table class="table">
        <thead>
          <tr>
            <th>Id</th>
            <th>Registration No.</th>
            <th class="dhivehi right">ތަނުގެ ނަން.</th>
            <th>Permit Type</th>
            <th>New/Renew</th>
            <th>Added On</th>
            <th>Updated On</th>
            <th>Process</th>
          </tr>
        </thead>
        <thead>
          <tr>
            <th>
              <div class="control input is-primary">
                <input type="text"  class="control" size="4" name="applicationId" v-model="form.applicationId">
              </div>
            </th>
            <th>
              <div class="control input is-primary">
                <input type="text"  class="control" size="4" name="registrationNo" v-model="form.registrationNo">
              </div>
            </th>
            <th>
              <div class="control input is-primary">
                <input type="text"  class="control" size="4" name="placeNameDv" v-model="form.placeNameDv">
              </div>
            </th>
            <th>
              <div class="control select is-primary">
                <select v-model="form.tobaccoOrFood">
                  <option value="all" selected>all</option>
                  <option value="1">tobacco</option>
                  <option value="2">food</option>
                </select>
              </div>
            </th>
            <th>
              <div class="control select is-primary">
                <select v-model="form.registerOrRenew">
                  <option value="all" selected>all</option>
                  <option value="1">register</option>
                  <option value="2">renew</option>
                </select>
              </div>
            </th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item,key in applications">
            <td v-can="'api.applications.show'"><router-link :to="{ name: 'applications.show', params: { applicationId: item.id }}">{{item.id}}</router-link></td>
            <td v-cannot="'api.applications.show'">{{item.id}}</td>
            <td v-if="!item.business_id">{{item._1registrationNumber}}</td>
            <td v-if="item.business_id"><router-link v-can="'api.businesses.show'" :to="{ name: 'businesses.show', params: { businessId: item.business_id }}">{{item._1registrationNumber}}</router-link></td>
            <td class="dhivehi">{{item._4placeName}}</td>
            <td>{{item.permit_type}}</td>
            <td>{{item.register_or_renew}}</td>
            <td>{{item.created_at}}</td>
            <td>{{item.updated_at}}</td>
            <td>
              <p class="buttons">
                <a class="button is-warning" v-can="'api.applications.update'" @click="processItem(item)">
                  <span class="icon is-small">
                    <i class="fa fa-edit"></i>
                  </span>
                </a>
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="container">
        <b-pagination
            :total="pagination.total"
            :current.sync="pagination.current"
            :order="pagination.order"
            :size="pagination.size"
            :simple="pagination.isSimple"
            :rounded="pagination.isRounded"
            :per-page="pagination.perPage"
            @change="pageChange">
        </b-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pagination: {
        total: 200,
        current: 1,
        perPage: 100,
        order: '',
        size: '',
        isSimple: false,
        isRounded: false,
      },
      applications: [],
      form: new Form({
        applicationId: '',
        status: 'all',
        tobaccoOrFood: 'all',
        registerOrRenew: 'all',
        registrationNo:'',
        placeNameDv:''
      })
    }
  },
  watch: {
      'form.applicationId': function() {
        this.getApplications();
      },
      'form.status': function() {
        this.getApplications();
      },
      'form.tobaccoOrFood': function() {
        this.getApplications();
      },
      'form.registerOrRenew': function() {
        this.getApplications();
      },
      'form.registrationNo': _.debounce(function() {
        this.getApplications();
      }, 500),
      'form.placeNameDv': _.debounce(function() {
        this.getApplications();
      }, 500)
  },
  mounted() {
    this.getApplications();
  },
  methods: {
    getApplications(page = 1) {
      if (this.hasPermission('api.applications.draft')) {      
        axios
          .get('/api/applications/draft?'
            + 'tobaccoOrFood=' + this.form.tobaccoOrFood
            + '&registerOrRenew=' + this.form.registerOrRenew
            + '&applicationId=' + this.form.applicationId
            + '&registrationNo=' + this.form.registrationNo
            + '&placeNameDv=' + this.form.placeNameDv
            + '&page=' + page
            )
          .then(response => {
            this.applications = response.data.data;
            this.setPagination(response.data);
          })
          .catch(errors => console.log(errors));
      }
    },
    pageChange (page) {
        this.current = page
        // this.filter.offset = ((this.current - 1) * this.filter.limit)
        this.getApplications(page);
    },
    setPagination(data) {
      this.pagination.total = data.total
            this.pagination.current = data.current_page
            this.pagination.perPage = data.per_page
    },
    processItem(item) {
      if (this.hasPermission('api.applications.update')) {    
        this.$router.push({ name: 'applications.edit', params: { applicationId: item.id } })
      }
    }
  }
};
</script>