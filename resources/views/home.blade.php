@extends(layout())

@section('header')
    <link href="{{ mix('/css/home.css') }}" rel="stylesheet" >
@endsection

@section('content')
    <div id="home" class="home">
        <div class="container">
            <!-- Segue Filtro dos Veículos-->
            @if (Auth::user()->role === 2)
            <div class="row filter-user-row">
                <div id="filterVehicle" role="tablist" aria-multiselectable="true" class="col-12">
                    <div class="card">
                        <div class="card-header" id="header-filter-user" role="tab">
                            <a data-toggle="collapse" data-parent="#filterVehicle" @click="openVehicleFilter()" aria-expanded="true">
                                        <span class="mb-0 list-header-button-model">
                                            Filtro
                                        </span>
                            </a>
                        </div>
                        <div class="collapse" id="addUserFilter" role="tabpanel" aria-labelledby="#header-filter-user"
                             :class="{'show': collapseVehicleFilter}">
                            <div class="row">
                                <div class="col-6">
                                    Proprietário:
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <v-select id="ownerFilter" name="onwers"
                                                  v-model="currentOwnerId" v-validate="'required'" required
                                                  :disabled="loadingVehicles"
                                                  :options="usersNames"
                                                  placeholder="Proprietários">
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final do Filtro -->
            @endif

            <!-- Lista de Veículos -->
            <div class="row home-row no-gutters home-row">
                <div class="col-12 home-title">
                    <div class="container-fluid">
                        <div class="row no-gutters">
                            <div class="col-6">
                                <p>{{Auth::user()->role === 1 ? 'Meus ': ''}}Veículos</p>
                            </div>
                            <div class="col-2">
                                @if(Auth::user()->role === 2)
                                    <span class="add-home" @click="newVehicle()">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="col-4">
                                <input type="text" id="search-home" name="search-home"
                                       placeholder="Buscar" v-model="filterVehicle">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 home-body">
                    <div class="row no-gutters home-loading justify-content-center" v-show="loadingVehicles">
                        <i class="fa fa-refresh fa-spin fa-4x home-loading"></i>
                    </div>
                    <div class="row no-gutters home-elements" v-for="vehicle in vehicles" @click="selectVehicle(vehicle)" v-show="!loadingVehicles">
                        <div class="col-8">
                            <p>@{{ vehicle.plate }} -  @{{ vehicle.brand }}</p>
                            <p>Modelo: @{{ vehicle.vehicle_model }}</p>
                            <p>RENAVAM: @{{ vehicle.renavam }}</p>
                            <p>Proprietário: @{{ vehicle.owner.name }}</p>
                        </div>
                        <div class="col-4">
                            <p></p>
                            <p>Ano: @{{ vehicle.year}}</p>
                            <p>@{{ vehicle.owner.phone }}</p>
                        </div>
                    </div>
                    <div class="row w-100 justify-content-center mt-3" v-show="!loadingVehicles">
                        <div class="col-auto">
                            <nav aria-label="Navegação">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Anterior"
                                           :class="{ 'disabled': paginationVehicles.current === 1}"
                                           :disabled="paginationVehicles.current === 1"
                                           @click   ="previowsPageVehicles()">
                                            <span aria-hidden="true" class="fa fa-angle-left"></span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="page in this.paginationVehicles.last"
                                        :class="{ 'active': page === paginationVehicles.current }"
                                        @click="changePageVehicles(page)">
                                        <a class="page-link" href="#">@{{ page }}</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Próximo"
                                           :class="{ 'disabled': paginationVehicles.current === paginationVehicles.last}"
                                           :disabled="paginationVehicles.current === paginationVehicles.last"
                                           @click="nextPageVehicles()">
                                            <span aria-hidden="true" class="fa fa-angle-right"></span>
                                            <span class="sr-only">Próximo</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim da Lista dos Veículos -->
        </div>

        @if(Auth::user()->role === 2)
            @include('modals.vehicle-modal')
        @endif
    </div>
@endsection

@section('scripts')
    <script type="application/javascript">
        @if(Auth::user())
            let ROLE = {{ Auth::user()->role }};
            let USER_ID = {{ Auth::user()->id }};

            try {
                localStorage.setItem('federal-api-token', " {{ Auth::user()->api_token }} ");
            } catch (e) {
                Cookies.set('federal-api-token', " {{ Auth::user()->api_token }} ");
            }
        @endif
    </script>

    <script type="application/javascript" src="{{mix('js/home.js')}}"></script>
@endsection