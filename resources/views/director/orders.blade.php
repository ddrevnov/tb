@extends('layouts.layoutDirector')
@section('content')
    <section class="director-kunden director-main">
        <h1 class="director-content__heading heading heading__h1">Rechnungen</h1>

        <div class="director-content">

            <orders-vue></orders-vue>

    <template id="orders-template">

    <alert
      :show.sync="showSuccess"
      :duration="3000"
      type="success"
      width="400px"
      placement="top-right"
      dismissable>
      <strong>Well Done!</strong>
      <p>E-mail was send.</p>
    </alert>

    <alert
        :show.sync="showSuccessCancel"
        :duration="3000"
        type="success"
        width="400px"
        placement="top-right"
        dismissable>
        <strong>Well Done!</strong>
        <p>Canceled</p>
    </alert>

    <alert
      :show.sync="showDanger"
      :duration="3000"
      type="danger"
      width="400px"
      placement="top-right"
      dismissable>
      <strong>Oh snap!</strong>
      <p>E-mail was not send.</p>
    </alert>

        <div class="remodal kalendar-form leistungen-form" id="orderModal1">
            <button data-remodal-action="close" class="remodal-close"><i></i></button>

            <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Bankverbindung edit</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <form class="kalendar-form__form" id="orderForm1" action="/backend/orders/update_bank_details"
                          method="POST">
                        <fieldset class="kalendar-form__fieldset">
                            {{csrf_field()}}
                            <div class="kalendar-form__row">
                                <div>
                                    <input
                                    v-model="bankInfo.account_owner" 
                                    type="text" name="account_owner" class="kalendar-form__input kalendar-input"
                                           placeholder="Kontoinhaber">
                                </div>
                                <div>
                                    <input
                                    v-model="bankInfo.account_number"
                                     type="text" name="account_number" class="kalendar-form__input kalendar-input"
                                           placeholder="Kontonummer">
                                </div>
                            </div>

                            <div class="kalendar-form__row">
                                <div>
                                    <input
                                    v-model="bankInfo.bank_code"
                                     type="text" name="bank_code" class="kalendar-form__input kalendar-input"
                                           placeholder="Bankleitzahl">
                                </div>
                                <div>
                                    <input
                                    v-model="bankInfo.bank_name"
                                    type="text" name="bank_name" class="kalendar-form__input kalendar-input" placeholder="Bankname">
                                </div>
                            </div>

                            <div class="kalendar-form__row">
                                <div>
                                    <input 
                                    v-model="bankInfo.iban"
                                    type="text" name="iban" class="kalendar-form__input kalendar-input" placeholder="IBAN">
                                </div>
                                <div>
                                    <input
                                     v-model="bankInfo.bic"
                                    type="text" name="bic" class="kalendar-form__input kalendar-input" placeholder="BIC">
                                </div>
                            </div>

                            <div class="kalendar-form__row">
                                <div>
                                    <input
                                            v-model="bankInfo.ust_id"
                                    type="text" name="ust_id" class="kalendar-form__input kalendar-input" placeholder="USt-ID">
                                </div>
                                <div>
                                    <input
                                            v-model="bankInfo.trade_register"
                                    type="text" name="trade_register" class="kalendar-form__input kalendar-input" placeholder="Handelsregister">
                                </div>
                            </div>

                            <div class="kalendar-form__row">
                                <div>
                                    <input
                                            v-model="bankInfo.tax_number"
                                    type="text" name="tax_number" class="kalendar-form__input kalendar-input" placeholder="Steuernummer">
                                </div>
                            </div>

                        </fieldset>
                        <fieldset class="kalendar-form__fieldset">
                            <input class="kalendar-form__submit btn btn--red" id="edit_category" type="submit"
                                   value="Edit">
                        </fieldset>
                    </form>
                </div>

            </div>

        </div>

        <div class="remodal kalendar-form leistungen-form" id="orderModal2">
            <button data-remodal-action="close" class="remodal-close"><i></i></button>

            <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-2" class="block__item is-active">Rechnungsadresse edit</li>
                </ul>

                <div data-tab-id="tab-2" class="tab-content is-active">
                    <form class="kalendar-form__form" id="orderForm2" action="/backend/orders/update_legal_address"
                          method="POST">
                        <fieldset class="kalendar-form__fieldset">
                            {{csrf_field()}}
                            <div class="kalendar-form__row">
                                <div>
                                    <input
                                    v-model="legalAddress.firm_name" 
                                    type="text" name="firm_name" class="kalendar-form__input kalendar-input" placeholder="Firma und Rechtsform">
                                </div>
                                <div>
                                    <input 
                                    v-model="legalAddress.first_last_name"
                                    type="text" name="first_last_name"
                                           class="kalendar-form__input kalendar-input"
                                           placeholder="Vorname & Nachnahme">
                                </div>
                            </div>

                            <div class="kalendar-form__row">
                                <div>
                                    <input
                                    v-model="legalAddress.post_index" 
                                    type="text" name="post_index" class="kalendar-form__input kalendar-input" placeholder="PLZ/Ort">
                                </div>
                                <div>
                                    <input 
                                    v-model="legalAddress.street"
                                    type="text" name="street" class="kalendar-form__input kalendar-input" placeholder="Straße/Nr">
                                </div>
                            </div>

                            <div class="kalendar-form__row">
                                <div>
                                    <input 
                                    v-model="legalAddress.addition_address"
                                    type="text" name="addition_address"
                                           class="kalendar-form__input kalendar-input" placeholder="Adresszusatz">
                                </div>
                            </div>

                        </fieldset>
                        <fieldset class="kalendar-form__fieldset">
                            <input class="kalendar-form__submit btn btn--red" id="edit_category" type="submit"
                                   value="Edit">
                        </fieldset>
                    </form>
                </div>

            </div>

        </div>
                <div class="block">
                    <ul class="block__nav">
                        <li 
                        @click.stop="searchShow = true"
                        data-tab="tab-1" 
                        class="block__item is-active">Rechnungen</li>
                        <li
                        @click.stop="searchShow = false" 
                        data-tab="tab-2" class="block__item">Bankverbindung</li>
                        <li
                        @click.stop="searchShow = false" 
                        data-tab="tab-3" class="block__item">Rechnungsadresse</li>
                        <li
                        @click.stop="searchShow = false" 
                        data-tab="tab-4" class="block__item">Logo</li>
                        <li v-show="searchShow">
                            <input
                                @blur.stop="searchOrders"
                                v-model="ordersFrom"
                                id="ordersFrom"
                                type="text" class="input-date input-date--small">
                            <input
                                @blur.stop="searchOrders"
                                v-model="ordersTo"
                                id="ordersTo"
                                type="text" class="input-date input-date--small">
                        </li>

                        <li v-show="searchShow">
                            <input
                            v-model="query"
                            @input="searchOrders" 
                            class="input-search" type="search" placeholder="Suchen">
                        </li>
                    </ul>

                    <div data-tab-id="tab-1" class="tab-content is-active">

                    <table class="table table--striped orders-table" id="orders-table">
                        <thead>
                            <tr>
                                <th class="sorter-false"></th>
                                <th>Nr:</th>
                                <th>Name</th>
                                <th>Unternehmen</th>
                                <th>Betrag</th>
                                <th>Rechungsdatum</th>
                                <th>Zahlung</th>
                                <th class="sorter-false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                            v-for="order in orders" track-by="$index"
                            data-order-id="@{{order.id}}">
                                        <td class="table__color-block 
                                        @{{ order.status === 'paid' ? 'table__color-block--green' : '' }} 
                                        @{{ order.status === 'attention' ? 'table__color-block--yellow' : '' }} 
                                        @{{ order.status === 'warning' ? 'table__color-block--red' : '' }}
                                        @{{ order.status === 'cancel' ? 'table__color-block--blue' : '' }}
                                        ">
                                            <input
                                                v-if="order.status !== 'paid'"
                                                @change="paidHandler($event)" type="checkbox">
                                        </td>
                                        <td>@{{order.order_number}}</td>
                                        <td>@{{order.firstname}} @{{order.lastname}}</td>
                                        <td>@{{order.firmlink}}.timebox24.com</td>
                                        <td>@{{order.price}} €</td>
                                        <td>
                                            @{{ order.created_at | formatDate "DD-MM-YYYY" }}
                                        </td>
                                        <td>
                                            @{{ order.status === 'paid' ? '' : 'night bezahlt ' }}
                                            @{{ order.status === 'paid' ? order.paid_at : '' | formatDate "DD-MM-YYYY" }}
                                        </td>
                                        <td class="table__last-td">
                                            <div class="settings">
                                                <div class="settings__ico"><i></i></div>
                                                <ul class="settings__list">
                                                    <li class="settings__item"><a href="/backend/orders/download/@{{order.id}}">Herunterladen</a></li>
                                                    <li v-show="order.status === 'paid'" class="settings__item">
                                                        <a
                                                                @click.prevent="cancel($event, $index)"
                                                                href="/backend/orders/cancel/@{{order.id}}">Cancel</a>
                                                    </li>
                                                    <li 
                                                    @click.prevent="sendEmail($event)"
                                                    class="settings__item"><a href="/backend/orders/send/@{{order.id}}">Per E-Mail versenden</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                        </tbody>
                    </table>
                        <pagination-vue :count="countPages"></pagination-vue>
                        <button @click="submitPaid" class="btn btn--red f-right">Yes</button>
                        <span v-show="!!!query">

                        </span>
                    </div>

                    <div data-tab-id="tab-2" class="tab-content">
                        <table class="table table--striped">

                            <tr>
                                <td>Kontoinhaber владеле счета</td>
                                <td>{{$details->account_owner}}</td>
                            </tr>

                            <tr>
                                <td>Kontonummer номер счета</td>
                                <td>{{$details->account_number}}</td>
                            </tr>

                            <tr>
                                <td>Bankleitzahl код банка</td>
                                <td>{{$details->bank_code}}</td>
                            </tr>

                            <tr>
                                <td>Bankname имя банка</td>
                                <td>{{$details->bank_name}}</td>
                            </tr>

                            <tr>
                                <td>IBAN</td>
                                <td>{{$details->iban}}</td>
                            </tr>

                            <tr>
                                <td>BIC</td>
                                <td>{{$details->bic}}</td>
                            </tr>

                            <tr>
                                <td>USt-ID</td>
                                <td>{{$details->ust_id}}</td>
                            </tr>

                            <tr>
                                <td>Handelsregister</td>
                                <td>{{$details->trade_register}}</td>
                            </tr>

                            <tr>
                                <td>Steuernummer</td>
                                <td>{{$details->tax_number}}</td>
                            </tr>

                        </table>
                        <a
                                @click.stop="getBankInfo"
                                class="director-kunden__btn btn btn--red" href="javascript:void(0);">Jetzt ändern</a>
                    </div>

                    <div data-tab-id="tab-3" class="tab-content">
                        <table class="table table--striped">

                            <tr>
                                <td>Firma und Rechtsform название фирмы</td>
                                <td>{{$details->firm_name}}</td>
                            </tr>

                            <tr>
                                <td>Vorname & Nachnahme имя-фамилия?</td>
                                <td>{{$details->first_last_name}}</td>
                            </tr>

                            <tr>
                                <td>PLZ/Ort почтовый индекс</td>
                                <td>{{$details->post_index}}</td>
                            </tr>

                            <tr>
                                <td>Straße/Nr улица</td>
                                <td>{{$details->street}}</td>
                            </tr>

                            <tr>
                                <td>Adresszusatz дополнение к адрессу</td>
                                <td>{{$details->addition_address}}</td>
                            </tr>

                        </table>
                        <a
                        @click.stop="getLegalAddress"
                        class="director-kunden__btn btn btn--red" href="javascript:void(0);">Jetzt ändern</a>
                    </div>

                    <div data-tab-id="tab-4" class="tab-content">

                        <logo-vue></logo-vue>
                        
                    </div>
                </div>
            </template>

            <template id="logo-template">
                <alert
                        :show.sync="showLogoSuccess"
                        :duration="3000"
                        type="success"
                        width="400px"
                        placement="top-right"
                        dismissable
                >
                    <span class="icon-ok-circled alert-icon-float-left"></span>
                    <strong>Well Done!</strong>
                    <p>Logo es verändert wurde</p>
                </alert>
                <div class="logo-block">
                    <form @submit.prevent="sendForm" class="logo-block__form" action="/backend/orders/store_logo" method="post"
                          enctype="multipart/form-data">
                        <input
                        @change="readURL($event)" 
                        class="logo-block__file logo-block__file--hide" name="firm_logo" type="file"/>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    </form>
                    <div>
                        <a 
                        @click.prevent.stop="selectFile"
                        class="logo-block__btn btn btn--gray" href="javascript:void(0);">Datei auswählen</a>
                    </div>
                    <div class="logo-block__img">
                        <div v-show="showImgPreloader" class="user-info__preloader">
                            <i></i>
                        </div>
                        <img id="blah" src="{{($details->logo != '') ? $details->logo : asset('images/default_logo.png')}}"
                             alt="">
                    </div>
                    <div>
                        <a
                                @click.stop.prevent="sendForm"
                                class="logo-block__btn btn btn--red" href="javascript:void(0);">Speichern</a>
                    </div>
                </div>
        </template>

        </div>

    </section>
@stop