<template>
  <div v-can="'api.inspections.upcoming'">
    <div class="columns">
      <div class="column is-fullwidth">
          <h1 class="title">
            Scheduled Inspections
          </h1>
      </div>
    </div>
    <template v-if="inspections">

      <div class="columns">
        <div class="column">
          <table class="table is-fullwidth is-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Business Name</th>
                <th>Type</th>
                <th>Assigned To</th>
                <th>Inspection At</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in inspections">
                <td>{{item.id}}</td>
                <td v-can="'api.businesses.show'"><router-link  :to="{ name: 'businesses.show', params: { businessId: item.business_id }}">{{item.business.name}}</router-link></td>
                <td v-cannot="'api.businesses.show'">{{item.business.name}}</td>
                <td v-if="!item.register_or_renew">{{item.reason}}{{item.is_graded ? ' (graded)' : null}}</td>
                <td v-if="item.register_or_renew">{{item.register_or_renew}}{{item.is_graded ? ' (graded)' : null}}
                  <!-- <router-link v-can="'api.applications.show'" class="button is-success" :to="{ name: 'applications.show', params: { applicationId: item.application_id }}"> -->
                  <router-link v-can="'api.applications.process'" :to="{ name: 'applications.process', params: { applicationId: item.application_id }}">
                    ({{item.application_id}})
                  </router-link>
                </td>
                <td>{{item.inspector ? item.inspector.name + '(' + item.inspector.id + ')' : 'not assigned'}}</td>
                <td>{{item.inspection_at}}</td>
                <td>
                  <p class="buttons">
                    <a   v-can="'api.inspections.show'" class="button is-primary" @click="goToInspection(item)">
                      <span class="icon is-small">
                        <i class="fa fa-eye"></i>
                      </span>
                    </a>
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
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
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      states: ['scheduled', 'finished', 'cancelled'],
      inspections: [],
        pagination: {
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
  mounted() {
    this.getInspections();
  },
  methods: {
    goToInspection(inspection) {
      this.$router.push({ name: 'inspections.show', params: { inspectionId: inspection.id } })
    },
    getInspections(page = 1) {
      if (this.hasPermission('api.inspections.upcoming')) {
        axios
        .get('/api/inspections/upcoming'
          + '?page=' + page
          )
        .then(response => {
          this.inspections = response.data.data;
          this.setPagination(response.data);
        })
        .catch(errors => console.log(errors));  
      }
    },
    pageChange(page) {
      this.pagination.current = page;
      this.getInspections(page);
    },
    setPagination(data) {
      this.pagination.total = data.total
      this.pagination.current = data.current_page
      this.pagination.perPage = data.per_page
    }
  }
};
</script>