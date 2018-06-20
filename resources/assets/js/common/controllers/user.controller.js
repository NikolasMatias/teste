import moment from 'moment';
import TWEEN from 'tween';
import Toasted from 'vue-toasted';

Vue.use(Toasted);

Vue.toasted.register('errorsUser', 'Ocorreu um erro', {
    type : 'error',
    icon : 'error_outline',
    duration: 1500
});

const User = {
    install(Vue, options) {
        Vue.mixin({
            data: function() {
                return {
                    //Carregadores da tela
                    loadingUser: false,
                    //Parametros Padrões
                    allUsersBoolean: 0, //Se vai ou não pegar com páginação.
                    ROLE: ROLE,
                    paginationUsers: {
                        current: 1,
                        last: 1
                    },
                    filterUser: '',
                    currentVehicleId: 0,
                    //Conteúdo
                    users: [],
                    usersNames: [], //Servirá para acessar selecionar um usuário.
                    currentUser: {
                        id: 0,
                        name: '',
                        email: '',
                        phone: '',
                        role: 0,
                        cpf: '',
                        vehicles: []
                    }
                };
            },
            methods: {
                getUsers: function () {
                    this.loadingUser = true;
                    let self = this;
                    let userData = {
                        params: {
                            all: 1,
                            filter: self.filterUser
                        },
                    };

                    axios.get('/api/users', userData).then(function (result) {
                        self.users = result.data.data;

                        self.usersNames = [];

                        for (let i=0; i < self.users.length; i++) {
                            self.usersNames.push({label: self.users[i].name, value: self.users[i].id});
                        }

                        self.loadingUsers = false;
                    }).catch(function(errors) {
                        Vue.toasted.show('Problema ao carregar os usuários', {
                            type: 'error',
                            icon: 'error_outline',
                            duration: 1500
                        });

                        console.log(errors.response.status);

                        self.loadingUsers = false;
                    });
                },
                //Voltado para a Paginação
                previowsPageUser: function () {
                    let target = this.paginationUsers.current-1;
                    if(target >= 1) {
                        this.paginationUsers.current = target;
                        this.getUsers();
                    }
                },
                nextPageUser: function () {
                    let target = this.paginationUsers.current+1;
                    if(target <= this.paginationUsers.last) {
                        this.paginationUsers.current = target;
                        this.getUsers();
                    }
                },
                changePageUser: function (page) {
                    if(page >= 1 && page <= this.paginationUsers.last) {
                        this.paginationUsers.current = page;
                        this.getUsers();
                    }
                }
                },
        });
    }
};

export default User;