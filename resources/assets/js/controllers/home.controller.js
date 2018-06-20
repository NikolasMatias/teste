import Vue from 'vue';
import Axios from 'axios';
import Toasted from 'vue-toasted';
import VueMask from 'v-mask';
import VueSelect from 'vue-select';
import VeeValidate from 'vee-validate';
import VeeValidateBR from 'vee-validate/dist/locale/pt_BR';
import Cookies from 'js-cookie';
import moment from 'moment';
import User from '../common/controllers/user.controller';
import Vehicle from '../common/controllers/vehicle.controller';

VeeValidate.Validator.addLocale(VeeValidateBR);
VeeValidate.Validator.installDateTimeValidators(moment);
Vue.use(VeeValidate, {
    locale: 'pt_BR'
});

Vue.use(VueMask);
Vue.use(VueSelect);
Vue.use(Toasted);
Vue.use(User);
Vue.use(Vehicle);

new Vue({
    el: '#home',
    components: {
        'v-select': VueSelect
    },
    mixins: {
        User, Vehicle
    },
    data: {
        ID: USER_ID
    },
    mounted: function () {
        let self = this;
        this.currentOwnerId = {
            label: 'Você',
            value: this.ID
        };

        if (ROLE === 2) {
            self.getUsers();
        }

        self.getVehicles();
    },
    methods: {
        openVehicleFilter: function () {
            this.collapseVehicleFilter = !this.collapseVehicleFilter;
        },
        deleteOneVehicle: function (id) {
            this.deleteVehicle(id);

            $('#vehicle-modal').modal('hide');
        }
    }
});
