import Vue from 'vue';
import VueRouter from 'vue-router';
import Buefy from 'buefy';
import routes from './routes';
import 'buefy/dist/buefy.css';
import moment from 'moment'
import bulmaCalendar from 'bulma-calendar/dist/js/bulma-calendar.min'
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'

window.Buefy = Buefy;
window.moment = moment;
window.bulmaCalendar = bulmaCalendar;

import Form from './Form';
window._ = require('lodash');
window.Popper = require('popper.js').default;

import AclPlugin from './plugins/AclPlugin';
import FormPlugin from './plugins/FormPlugin';
import Helpers from './plugins/Helpers';


/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
    if (401 === error.response.status) {
          window.location = '/login';
      } else {
          return Promise.reject(error);
      }
});

window.Form = Form;

Vue.use(AclPlugin, { 
  permissions: AppVars.permissions,
  user_id: AppVars.user_id,
  isPermissionDisabled: (process.env.MIX_PERMISSION_DISABLED === undefined) ? false : JSON.parse(process.env.MIX_PERMISSION_DISABLED)
});
Vue.use(VueRouter);
Vue.use(Buefy);
Vue.use(Helpers);
// Vue.use(FormPlugin);

Vue.component('datetime', Datetime);

Vue.component('english-heading', require('./components/Common/EnglishHeading.vue')); //Process Pending Application
Vue.component('dhivehi-form-heading', require('./components/Common/DhivehiFormHeading.vue')); //ކާބޯތަކެތީގެ ޚިދުމަތްދޭ ތަންތަން ރަޖިސްޓްރީ ކުރުމާއި ހުއްދަ އާކުރަން އަދި ދުންފަތުގެ އިސްތިޢުމާލު ކުރުމަށް ޚާއްޞަ ކުރެވިފައިވާ ތަނުގެ/އޭރިޔާގެ ހުއްދައަށް އެދޭ ފޯމް

Vue.component('columns-dhivehi', require('./components/Common/ColumnsDhivehi.vue'));
Vue.component('column', require('./components/Common/Column.vue'));


Vue.component('date-time-picker', require('./components/date-time-picker.vue'));
Vue.component('date-picker', require('./components/date-picker.vue'));
Vue.component('response-messages', require('./components/response-messages.vue'));
Vue.component('error-messages', require('./components/error-messages.vue'));

Vue.component('business-details', require('./components/business-details.vue'));
Vue.component('business-inspections', require('./components/business-inspections.vue'));
Vue.component('business-complaints', require('./components/business-complaints.vue'));
Vue.component('business-grading-inspections', require('./components/business-grading-inspections.vue'));
Vue.component('business-applications', require('./components/business-applications.vue'));
Vue.component('business-licenses', require('./components/business-licenses.vue'));
Vue.component('business-fines', require('./components/business-fines.vue'));
Vue.component('business-terminations', require('./components/business-terminations.vue'));

Vue.component('dhivehi-report-handover', require('./components/dhivehi-report-handover.vue'));

Vue.component('english-report-handover', require('./components/english-report-handover.vue'));
let app = new Vue({
    el: '#app',

    router: new VueRouter(routes),
    
    created() {
    	console.log('created called...');
    }
})
