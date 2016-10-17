@extends('layouts.layoutDirector')
@section('content')
    <section class="director-tarife director-main">
        <h1 class="director-content__heading heading heading__h1">Tarife
            <a class="director-tarife__btn btn btn--plus" href="#"><i></i>Hinzufügen</a>
        </h1>

        <div class="director-content">

            <section class="bearbeiten">
                <h2 class="bearbeiten__heading heading__h1">Basic Paket bearbeiten</h2>

                <div class="bearbeiten__main">

                <tariffs-vue></tariffs-vue> 

                    <template id="tariffs-tamlate">
                    <form action="/backend/tariffs/store" method="post" id="tarifForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="tariff_id" value="{{isset($tariff_edit) ? $tariff_edit->id : ''}}">
                        <h2 class="bearbeiten_display">Название тарифа</h2>
                        <input type="text" class="bearbeiten_marg" name="name" value="{{isset($tariff_edit) ? $tariff_edit->name : ''}}">
                        </br>

                        @if(!isset($tariff_edit))
                        <label>
                            <input 
                            v-model="selectedTarif" 
                            type="radio" name="type" value="paid" checked>
                            <p class="bearbeiten_display bearb">Тариф платный</p>
                        </label>

                        <label>
                            <input 
                            v-model="selectedTarif" 
                            type="radio" name="type" value="free">
                            <p class="bearbeiten_display bearb">Тариф бесплатный</p></br>
                        </label>
                        @endif

                        <label>
                            <input type="radio" name="status" value="1"
                               @if(isset($tariff_edit) && $tariff_edit->status == 1) checked @endif>
                        <p class="bearbeiten_display bearb">Активный</p>
                        </label>

                        <label>
                            <input type="radio" name="status" value="0"
                               @if(isset($tariff_edit) && $tariff_edit->status == 0) checked @endif>
                        <p class="bearbeiten_display bearb">Неактивный</p></br>
                        </label>

                        @if(isset($tariff_edit))
                                @if($tariff_edit->price != 0)
                        <p class="bearbeiten_display">Цена: <strong v-if="selectedTarif === 'free'">Free</strong></p>
                            <input
                            v-if="selectedTarif !==  'free'"
                            :disabled="selectedTarif ===  'free'" 
                            type="text" name="price" class="bearbeiten_marg"
                                   value="{{$tariff_edit->price}}">
                                @else
                                <p>FREE</p>
                                @endif
                        @else
                            <p class="bearbeiten_display">Цена: <strong v-if="selectedTarif === 'free'">Free</strong></p>
                            <input
                                    v-if="selectedTarif !==  'free'"
                                    :disabled="selectedTarif ===  'free'"
                                    type="text" name="price" class="bearbeiten_marg"
                                    value="0">
                        @endif

                        <p class="bearbeiten_display">Действует:</p>
                            <input type="text" name="duration" class="bearbeiten_marg"
                                   value="{{isset($tariff_edit) ? $tariff_edit->duration : ''}}">
                        </br>

                        <p class="bearbeiten_display">Описание:</p>
                        <input type="text" name="description" class="bearbeiten_marg"
                               value="{{isset($tariff_edit) ? $tariff_edit->description : ''}}">
                        </br>

                        <p class="bearbeiten_display limited_number">Ограниченное кол-во</p>
                        <p class="bearbeiten_display">Безлимит</p>

                        <div 
                        @change.stop="checkTable"
                        class="bearbeiten_size">
                            <input type="text" class="bearbeiten_readonly" readonly value="Кол-во писем из рассылки">
                            <input
                            v-model="lettersCount"
                            :disabled="lettersUnlimited" 
                            type="text" name="letters_count" class="bearbeiten_readonly1"
                                    @if(isset($tariff_edit) && $tariff_edit->letters_count != 0)
                                        value="{{$tariff_edit->letters_count}}"
                                    @endif
                            >
                            <div class="bearbeiten_border">
                                <input type="hidden" name="letters_unlimited" value="0">
                                <input
                                v-model="lettersUnlimited"
                                type="checkbox" name="letters_unlimited" value="1" id="unlimited_label"
                                        @if(isset($tariff_edit) && $tariff_edit->letters_unlimited == 1)
                                            checked
                                        @endif
                                >
                                <label for="unlimited_label" class="bearbeiten_unlimited_label"></label>
                            </div></br>

                            <input type="text" class="bearbeiten_readonly" readonly value="Кол-во сотрудников">
                            <input
                            v-model="employeeCount" 
                            :disabled="employeeUnlimited"
                            type="text" name="employee_count" class="bearbeiten_readonly1"
                                    @if(isset($tariff_edit) && $tariff_edit->employee_count != 0)
                                        value="{{$tariff_edit->employee_count}}"
                                    @endif
                            >
                            <div class="bearbeiten_border">
                                <input type="hidden" name="employee_unlimited" value="0">
                                <input 
                                v-model="employeeUnlimited"
                                type="checkbox" name="employee_unlimited" value="1" id="unlimited_label_1"
                                        @if(isset($tariff_edit) && $tariff_edit->employee_unlimited == 1)
                                            checked
                                        @endif
                                >
                                <label for="unlimited_label_1" class="bearbeiten_unlimited_label"></label>
                            </div></br>

                            <input type="text" class="bearbeiten_readonly" readonly value="Кол-во услуг">
                            <input
                            v-model="servicesCount"
                            :disabled="servicesUnlimited" 
                            type="text" name="services_count" class="bearbeiten_readonly1"
                                    @if(isset($tariff_edit) && $tariff_edit->services_count != 0)
                                        value="{{$tariff_edit->services_count}}"
                                    @endif
                            >
                            <div class="bearbeiten_border">
                                <input type="hidden" name="services_unlimited" value="0">
                                <input 
                                v-model="servicesUnlimited"
                                type="checkbox" name="services_unlimited" value="1" id="unlimited_label_2"
                                        @if(isset($tariff_edit) && $tariff_edit->services_unlimited == 1)
                                            checked
                                        @endif
                                >
                                <label for="unlimited_label_2" class="bearbeiten_unlimited_label"></label>
                            </div></br>

                            <input type="text" class="bearbeiten_readonly" readonly value="Dashborad кол-во недель">
                            <input
                            v-model="dashboardCount"
                            :disabled="dashboardUnlimited" 
                            type="text" name="dashboard_count" class="bearbeiten_readonly1"
                                    @if(isset($tariff_edit) && $tariff_edit->dashboard_count != 0)
                                        value="{{$tariff_edit->dashboard_count}}"
                                    @endif>
                            <div class="bearbeiten_border">
                                <input type="hidden" name="dashboard_unlimited" value="0">
                                <input
                                v-model="dashboardUnlimited"
                                 type="checkbox" name="dashboard_unlimited" value="1" id="unlimited_label_3"
                                        @if(isset($tariff_edit) && $tariff_edit->dashboard_unlimited == 1)
                                            checked
                                        @endif
                                >
                                <label for="unlimited_label_3" class="bearbeiten_unlimited_label"></label>
                            </div>

                        </div>

                        <input type="submit" class="bearbeiten__btn btn btn--red" value="Speichern">

                    </form>
                    </template>
                </div>

            </section>

        </div>

    </section>
    @stop