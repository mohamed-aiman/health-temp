<template>
  <div v-can="'api.applications.index'">
    <english-heading>All Applications</english-heading>
    <div>
      <table class="table">
        <thead>
          <tr>
            <th>Id</th>
            <th>Permit Type</th>
            <th>New/Renew</th>
            <th>Status</th>
            <th>Added On</th>
            <th>Updated On</th>
            <th>Options</th>
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
            <th>
              <div class="control select is-primary">
              <select v-model="form.status">
                <option value="all" selected>all</option>
                <option value="draft">draft</option>
                <option value="pending">pending</option>
                <option value="processed">processed</option>
                <option value="cancelled">cancelled</option>
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
            <td>{{item.id}}</td>
            <td>{{item.permit_type}}</td>
            <td>{{item.register_or_renew}}</td>
            <td>{{item.status}}</td>
<!--             <td>
              <p class="buttons">
                <span class="control select">
                    <select v-model="item.status" @change="updateStatus(item)">
                    <option value="draft" >draft</option>
                    <option value="pending" >pending</option>
                    <option value="processed" >processed</option>
                    <option value="cancelled" >cancelled</option>
                  </select>
                </span>
              </p>
            </td> -->
            <td>{{item.created_at}}</td>
            <td>{{item.updated_at}}</td>
            <td>
              <p class="buttons">
                <a   v-can="'api.applications.show'" class="button is-primary" @click="goToApplication(item)">
                  <span class="icon is-small">
                    <i class="fa fa-eye"></i>
                  </span>
                </a>
                <a v-if="item.status == 'draft'" v-can="'api.applications.update'" class="button is-warning" @click="goToApplicationEdit(item)">
                  <span class="icon is-small">
                    <i class="fa fa-edit"></i>
                  </span>
                </a>
                <a v-if="item.status == 'pending'" v-can="'api.applications.process'" class="button is-warning" @click="processItem(item)">
                  <span class="icon is-small">
                    <i class="fa fa-gear"></i>
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
    }
  },
  mounted() {
    this.getApplications();
  },
  methods: {
    getApplications(page = 1) {
      if (this.hasPermission('api.applications.index')) {
        axios
          .get('/api/applications?'
            + 'status=' + this.form.status
            + '&tobaccoOrFood=' + this.form.tobaccoOrFood
            + '&registerOrRenew=' + this.form.registerOrRenew
            + '&applicationId=' + this.form.applicationId
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
      if (this.hasPermission('api.applications.process')) {
        this.$router.push({ name: 'applications.process', params: { applicationId: item.id } })
      }
    },
    goToApplication(item) {
      if (this.hasPermission('api.applications.show')) {
        this.$router.push({ name: 'applications.show', params: { applicationId: item.id } })
      }
    },
    goToApplicationEdit(item) {
      if (this.hasPermission('api.applications.update')) {
        this.$router.push({ name: 'applications.edit', params: { applicationId: item.id } })
      }
    },
    // ,
    // updateStatus(item) {
    //   if (this.hasPermission('api.applications.updateStatus')) {
    //     axios
    //     .patch("/api/applications/" + item.id  + "/updateStatus", {
    //       'status': item.status
    //     })
    //     .then(response => {
    //       item = response.data;
    //     })
    //     .catch(error => {
    //       console.log(error);
    //     });
    //   }
    // }
  }
};
</script>