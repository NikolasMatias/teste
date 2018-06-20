<div class="modal fade" id="vehicle-modal" tabindex="-1" role="dialog" aria-hidden="true" v-if="currentVehicle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-if="currentVehicle.id">Editar Veículo</h5>
                <h4 class="modal-title" v-if="!currentVehicle.id">Criar novo Veículo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form data-vv-scope="currentVehicle" @submit.prevent="saveVehicle()">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="row new-input">
                                    <div class="col-4">
                                        <label>Proprietário:</label>
                                    </div>
                                    <div class="col-8 select-list">
                                        <div class="form-group" :class="{'has-danger': errors.has('currentVehicle.proprietario')}">
                                            <v-select id="owner" name="proprietario"
                                                      v-model="currentOwnerModelId" v-validate="'required'" required
                                                      :disabled="savingVehicle"
                                                      :class="{'form-control-danger': errors.has('currentVehicle.proprietario')}"
                                                      :options="usersNames"
                                                      placeholder="Proprietário">
                                            </v-select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>RENAVAM: </label>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group" :class="{'has-danger': errors.has('currentVehicle.renavam')}">
                                            <input type="text" class="form-control" id="renavam" name="renavam"
                                                   placeholder="XXXXXXXXXXX" v-model="currentVehicle.renavam"
                                                   :disabled="savingVehicle"
                                                   v-validate="'required|min:9'"
                                                   data-vv-validate-on="blur"
                                                   :class="{'form-control-danger': errors.has('currentVehicle.renavam')}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="row new-input">
                                    <div class="col-4">
                                        <label>Placa: </label>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group" :class="{'has-danger': errors.has('currentVehicle.placa')}">
                                            <input type="text" class="form-control" id="plate" name="placa"
                                                   placeholder="Placa" v-model="currentVehicle.plate"
                                                   :disabled="savingVehicle" v-validate="'required'"
                                                   data-vv-validate-on="blur"
                                                   :class="{'form-control-danger': errors.has('currentVehicle.placa')}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Modelo: </label>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group" :class="{'has-danger': errors.has('currentVehicle.modelo')}">
                                            <input type="text" class="form-control" id="vehicle_model" name="modelo"
                                                   placeholder="Modelo" v-model="currentVehicle.vehicle_model"
                                                   :disabled="savingVehicle" v-validate="'required|date_format:YYYY'"
                                                   data-vv-validate-on="blur"
                                                   :class="{'form-control-danger': errors.has('currentVehicle.modelo')}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Ano:</label>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group" :class="{'has-danger': errors.has('currentVehicle.ano')}">
                                            <input type="text" class="form-control" id="year" name="ano"
                                                   placeholder="Ano" v-model="currentVehicle.year"
                                                   :disabled="savingVehicle" v-validate="'required|date_format:YYYY'"
                                                   data-vv-validate-on="blur"
                                                   :class="{'form-control-danger': errors.has('currentVehicle.ano')}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label>Marca: </label>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group" :class="{'has-danger': errors.has('currentVehicle.marca')}">
                                            <input type="text" class="form-control" id="brand" name="marca"
                                                   placeholder="Marca" v-model="currentVehicle.brand"
                                                   :disabled="savingVehicle" v-validate="'required'"
                                                   data-vv-validate-on="blur"
                                                   :class="{'form-control-danger': errors.has('currentVehicle.marca')}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer w-100">
                    <span class="text-danger pull-left" v-show="errors.any('currentVehicle')">@{{ errors.all('currentVehicle')[0] }}</span>

                    <div class="col-profile-buttom" v-if="typeSaveVehicle">
                        <button type="button" class="btn btn-success pull-left profile-modal-delete-buttom"
                                :disabled="deletingVehicle" @click="deleteOneVehicle(currentVehicle.id)">
                            <span v-show="!deletingVehicle">Deletar</span>
                            <i class="fa fa-cog fa-spin" v-show="deletingVehicle"></i>
                        </button>
                    </div>


                    <div class="col-profile-buttom">
                        <button type="submit" class="btn btn-success pull-right profile-modal-buttom"
                                :disabled="savingVehicle">
                            <span v-show="!savingVehicle" v-if="!typeSaveVehicle">Criar</span>
                            <span v-show="!savingVehicle" v-if="typeSaveVehicle">Salvar</span>
                            <i class="fa fa-cog fa-spin" v-show="savingVehicle"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-secondary profile-modal-close-buttom pull-right" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
