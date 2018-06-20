import moment from 'moment';
import TWEEN from 'tween';
import Toasted from 'vue-toasted';

Vue.use(Toasted);

Vue.toasted.register('errorsUser', 'Ocorreu um erro', {
    type : 'error',
    icon : 'error_outline',
    duration: 1500
});

const Vehicle = {
    install(Vue, options) {
        Vue.mixin({
            data: function () {
                return {
                    //Carregadores da tela
                    loadingVehicles: false, //Servirá para quando forem vários veículos.
                    loadingVehicle: false, //Servirá para quando for apenas um veículo.
                    deletingVehicle: false,
                    savingVehicle: false,
                    typeSaveVehicle: false,
                    //Parametros Padrões
                    allVehiclesBoolean: 0, //Se vai ou não pegar com páginação.
                    paginationVehicles: {
                        current: 1,
                        last: 1
                    },
                    filterVehicle: '',
                    currentOwnerId: {
                        label: 'Você',
                        value: 0
                    },
                    currentOwnerModelId: 0,
                    filterVehicleTimeout: '', //Irá controlar o filtro do veículo para que não faça requisições demais.
                    //Conteúdo
                    vehicles: [],
                    currentVehicle: {
                        id: 0,
                        owner_id: 0,
                        plate: '',
                        brand: '',
                        vehicle_model: '',
                        year: '',
                        renavam: '',
                        owner: {
                            id: 0,
                            name: '',
                            email: '',
                            phone: '',
                            role: 0,
                            cpf: ''
                        }
                    },
                    //Parte votlada para os Models
                    collapseVehicleFilter: false,
                };

            },
            watch: {
                filterVehicle: function () {
                    let self = this;
                    clearTimeout(self.filterVehicleTimeout);
                    self.filterVehicleTimeout = setTimeout(function() {
                        self.getVehicles();
                    }, 800);
                },
                currentOwnerId: function () {
                    let self = this;
                    clearTimeout(self.filterVehicleTimeout);
                    self.filterVehicleTimeout = setTimeout(function() {
                        self.getVehicles();
                    }, 800);
                }
            },
            methods: {
                getVehicles: function() {
                    let self = this;
                    let loadingVehicles = true;

                    let vehicleData = {
                        params: {
                            page: this.paginationVehicles.current,
                            filter: this.filterVehicle,
                            owner_id: this.currentOwnerId.value
                        }
                    };

                    axios.get('/api/vehicles', vehicleData).then(function (result) {
                        self.vehicles = result.data.data;

                        self.loadingVehicles = false;

                        self.paginationVehicles.current = result.data.meta.current_page;
                        self.paginationVehicles.last = result.data.meta.last_page;
                    }).catch(function (errors) {
                        Vue.toasted.show('Problema ao carregar os veículos.', {
                            type: 'error',
                            icon: 'error_outline',
                            duration: 1500
                        });

                        console.log(errors);

                        self.loadingVehicles = false;
                    });


                },
                getVehicle: function (vehicle_id) {
                    let self = this;
                    this.loadingVehicle = true;

                    axios.get('/api/vehicles/'+vehicle_id).then(function (result) {
                        self.currentVehicle = result.data;

                        self.loadingVehicle = false;
                    }).catch(function (error) {
                        Vue.toasted.show('Problema ao carregar o veículo.', {
                            type: 'error',
                            icon: 'error_outline',
                            duration: 1500
                        });

                        console.log(errors.response);

                        self.loadingVehicle = false;
                    });
                },
                postVehicle: function (vehicle_id) {
                    this.$validator.validateAll('currentVehicle').then(function (result) {
                        if (result) {
                            let self = this;
                            self.savingVehicle = true;

                            let vehicleData = new FormData();
                            vehicleData.append('owner_id', this.currentOwnerModelId.value);
                            vehicleData.append('plate', this.currentVehicle.plate);
                            vehicleData.append('brand', this.currentVehicle.brand);
                            vehicleData.append('year', this.currentVehicle.year);
                            vehicleData.append('vehicle_model', this.currentVehicle.vehicle_model);
                            vehicleData.append('renavam', this.currentVehicle.renavam);

                            axios.post('/api/vehicles', vehicleData).then(function (result) {
                                self.getVehicles();

                                Vue.toasted.show('Veículo criado!', {
                                    type: 'success',
                                    icon: 'check',
                                    duration: 2000
                                });

                                self.savingVehicle = false;
                            }).catch(function (errors) {
                                console.log(errors.result);
                                Vue.toasted.show('Problema o criar veículo.', {
                                    type: 'error',
                                    icon: 'error_outline',
                                    duration: 2000
                                });

                                self.savingVehicle = false;
                            });
                        }
                    }.bind(this));
                },
                putVehicle: function () {
                    this.$validator.validateAll('currentVehicle').then(function (result) {
                        if (result) {
                            let self = this;
                            self.savingVehicle = true;

                            let vehicleData = {
                                owner_id: this.currentOwnerModelId.value,
                                plate: this.currentVehicle.plate,
                                brand: this.currentVehicle.brand,
                                year: this.currentVehicle.year,
                                vehicle_model: this.currentVehicle.vehicle_model,
                                renavam: this.currentVehicle.renavam
                            };

                            axios.put('/api/vehicles/'+this.currentVehicle.id, vehicleData).then(function (result) {
                                self.getVehicles();

                                Vue.toasted.show('Veículo editado!', {
                                    type: 'success',
                                    icon: 'check',
                                    duration: 2000
                                });

                                self.savingVehicle = false;
                            }).catch(function (errors) {
                                console.log(errors.result);
                                Vue.toasted.show('Problema ao editar veículo.', {
                                    type: 'error',
                                    icon: 'error_outline',
                                    duration: 2000
                                });

                                self.savingVehicle = false;
                            });
                        }
                    }.bind(this));
                },
                deleteVehicle: function (vehicle_id) {
                    let self = this;
                    this.deletingVehicle = true;

                    axios.delete('/api/vehicles/'+vehicle_id, {}).then(function (result) {
                        self.getVehicles();

                        Vue.toasted.show('Veículo Deletada!.', {
                            type: 'success',
                            icon: 'check',
                            duration: 2000
                        });

                        self.deletingVehicle = false;
                    }).catch(function (error) {
                        Vue.toasted.show('Problema ao deletar o veículo.', {
                            type: 'error',
                            icon: 'error_outline',
                            duration: 2000
                        });

                        self.deletingVehicle = false;
                    });
                },
                selectVehicle: function (vehicle) {
                    this.currentVehicle = vehicle;

                    this.currentOwnerModelId = {label: vehicle.owner.name, value: vehicle.owner.id};

                    this.typeSaveVehicle = true;

                    $('#vehicle-modal').modal();
                },
                newVehicle: function () {
                    this.currentVehicle = {
                        id: 0,
                        owner_id: 0,
                        plate: '',
                        brand: '',
                        vehicle_model: '',
                        year: '',
                        renavam: '',
                        owner: {
                            id: 0,
                            name: '',
                            email: '',
                            phone: '',
                            role: 0,
                            cpf: ''
                        }
                    };

                    this.currentOwnerModelId = 0;

                    this.typeSaveVehicle = false;

                    $('#vehicle-modal').modal();

                    this.$validator.clean();
                },
                /**
                 * Esse Método Irá decidir se vou criar ou atualizar um veículo.
                 */
                saveVehicle: function () {
                    if (this.typeSaveVehicle) {
                        this.putVehicle();
                    } else {
                        this.postVehicle();
                    }
                },
                //Voltado para a Paginação
                previowsPageVehicles: function () {
                    let target = this.paginationVehicles.current-1;
                    if(target >= 1) {
                        this.paginationVehicles.current = target;
                        this.getVehicles();
                    }
                },
                nextPageVehicles: function () {
                    let target = this.paginationVehicles.current+1;
                    if(target <= this.paginationVehicles.last) {
                        this.paginationVehicles.current = target;
                        this.getVehicles();
                    }
                },
                changePageVehicles: function (page) {
                    if(page >= 1 && page <= this.paginationVehicles.last) {
                        this.paginationVehicles.current = page;
                        this.getVehicles();
                    }
                }
            }
        });
    }
};

export default Vehicle;