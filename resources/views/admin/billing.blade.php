@extends('layouts.layoutAdmin')
@section('content')
    <section class="admin-settings director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans('common.billing')}}</h1>

        <div class="director-content">

            <billing-vue></billing-vue>

        </div>

    </section>

    <template id="billing-template">

        <div class="remodal kalendar-form leistungen-form" id="billingBankModal">
          <button data-remodal-action="close" class="remodal-close"><i></i></button>

          <div class="block">

            <ul class="block__nav">
              <li data-tab="tab-1" class="block__item is-active">{{trans('billing.bank_details')}}</li>
            </ul>

            <div data-tab-id="tab-1" class="tab-content is-active">
              <form 
              @submit.prevent="setBankDetails('#billingBankForm')"
              class="kalendar-form__form" id="billingBankForm" action="" method="POST">
                <fieldset class="kalendar-form__fieldset">

                  <div class="kalendar-form__row">
                      <div>
                          <input
                                  v-model="bankDetails.account_owner"
                                  name="account_owner"
                                  type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.account_owner')}}" required>
                      </div>
                    <div>
                      <input 
                      v-model="bankDetails.bank_name"
                      name="bank_name"
                      type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.bank_name')}}" required>
                    </div>
                  </div>

                  <div class="kalendar-form__row">
                    <div>
                      <input
                      v-model="bankDetails.iban" 
                      name="iban"
                      type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.iban')}}" required>
                    </div>
                    <div>
                      <input 
                      v-model="bankDetails.bic"
                      name="bic"
                      type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.bic')}}" required>
                    </div>
                      <input type="hidden" name="agreement" value="1">
                  </div>
                  
                </fieldset>
                <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__submit btn btn--red" type="submit" value="{{trans('common.edit')}}">
                </fieldset>
              </form>
            </div>

          </div>

        </div>


        <div class="remodal kalendar-form leistungen-form" id="billingAdressModal">
          <button data-remodal-action="close" class="remodal-close"><i></i></button>

          <div class="block">

            <ul class="block__nav">
              <li data-tab="tab-1" class="block__item is-active">{{trans('billing.legal_address')}}</li>
            </ul>

            <div data-tab-id="tab-1" class="tab-content is-active">
              <form 
              @submit.prevent="setBankDetails('#billingAdressForm')"
              class="kalendar-form__form" id="billingAdressForm" action="" method="POST">
                <fieldset class="kalendar-form__fieldset">

                    <div class="kalendar-form__row">

                        <div>
                            <select
                                    v-model="bankDetails.legal_country"
                                    @change="getStates(bankDetails.legal_country)"
                                    name="legal_country"
                                    class="kalendar-form__input kalendar-input" required>
                                <option v-for="country in countries" :value="country.country_id">@{{ country.name }}</option>
                            </select>
                        </div>

                        <div>
                            <select
                                    v-model="bankDetails.legal_state"
                                    @change="getCities(bankDetails.legal_state)"
                                    name="legal_state"
                                    class="kalendar-form__input kalendar-input" required>
                                <option v-for="state in states" :value="state.state_id">@{{ state.name }}</option>
                            </select>
                        </div>

                    </div>

                  <div class="kalendar-form__row">
                      <div>
                          <select
                                  v-model="bankDetails.legal_city"
                                  name="legal_city"
                                  class="kalendar-form__input kalendar-input" required>
                              <option v-for="city in cities" :value="city.city_id">@{{ city.name }}</option>
                          </select>
                      </div>
                    <div>
                      <input 
                      v-model="bankDetails.bank_name"
                      name="bank_name"
                      type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.bank_name')}}" required>
                    </div>
                  </div>

                  <div class="kalendar-form__row">
                    <div>
                      <input 
                      v-model="bankDetails.legal_post_index"
                      name="legal_post_index"
                      type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.legal_post_index')}}" required>
                    </div>
                      <div>
                          <input
                                  v-model="bankDetails.legal_street"
                                  name="legal_street"
                                  type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.legal_street')}}" required>
                      </div>
                  </div>

                    <div class="kalendar-form__row">
                        <div>
                            <input
                                    v-model="bankDetails.legal_firm_name"
                                    name="legal_firm_name"
                                    type="text" class="kalendar-form__input kalendar-input" placeholder="{{trans('billing.legal_firm_name')}}" required>
                        </div>
                    </div>
                  
                </fieldset>
                <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__submit btn btn--red" type="submit" value="{{trans('common.save')}}">
                </fieldset>
              </form>
            </div>

          </div>

        </div>

        <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">{{trans('billing.current_bills')}}</li>
                    <li data-tab="tab-2" class="block__item">{{trans('billing.archive_bills')}}</li>
                    <li data-tab="tab-3" class="block__item">{{trans('billing.bank_details')}}</li>
                    <li data-tab="tab-4" class="block__item">{{trans('billing.legal_address')}}</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <ul class="rechnungen">
                        @if($orders_new)
                            @foreach($orders_new as $order)
                                <li class="rechnungen__item">
                                    <div class="rechnungen__wrap">
                                        <div class="rechnungen__name">{{trans('billing.bill_for') .' ' . $order->created_at}}</div>
                                        <div class="rechnungen__desc">{{trans('billing.bill_amount')}}</div>
	                                    <div class="rechnungen__price">
		                                    {{($order->price + $order->extra_price > 1) ? $order->price + $order->extra_price : '0' }}€
	                                    </div>
                                    </div>
                                    <a class="btn btn--red"
                                       href="/office/billing/download/{{$order->id}}">{{trans('billing.bill_download')}}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div data-tab-id="tab-2" class="tab-content">
                    <ul class="rechnungen">
                        @if($orders_old)
                            @foreach($orders_old as $order)
                                <li class="rechnungen__item">
                                    <div class="rechnungen__wrap">
                                        <div class="rechnungen__name">{{trans('billing.bill_for') .' ' . $order->created_at}}</div>
                                        <div class="rechnungen__desc">{{trans('billing.bill_amount')}}</div>
                                        <div class="rechnungen__price">
                                            {{($order->price + $order->extra_price > 1) ? $order->price + $order->extra_price : '0' }}€
                                        </div>
                                    </div>
                                    <a class="btn btn--red"
                                       href="/office/billing/download/{{$order->id}}">{{trans('billing.bill_download')}}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div data-tab-id="tab-3" class="tab-content">
                    <table v-show="bankDetails.agreement != 0" class="table table--striped">

                        <tr>
                            <td>{{trans('billing.account_owner')}}</td>
                            <td>
                                <span class="td-data">@{{ bankDetails.account_owner }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('billing.bank_name')}}</td>
                            <td>
                                <span class="td-data">@{{ bankDetails.bank_name }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('billing.iban')}}</td>
                            <td><span class="td-data">@{{ bankDetails.iban }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('billing.bic')}}</td>
                            <td><span class="td-data">@{{ bankDetails.bic }}</span>
                            </td>
                        </tr>
                    </table>
                    <button
                    @click.stop="refusal"
                    v-if="bankDetails.agreement == 1"
                    class="btn admin-settings__btn btn btn--red f-left">{{trans('billing.refusal')}}</button>

		                <a v-if="bankDetails.agreement == 1"
		                   class="admin-settings__btn btn btn--red"
		                   href="/office/billing/document">Download document</a>

                    <a
                    @click.stop.prevent="openBankModal"
                    href="javascript:void(0);" class="admin-settings__btn btn btn--red f-right">{{trans('common.edit')}}</a>
                </div>

                <div data-tab-id="tab-4" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <td>{{trans('billing.legal_country')}}</td>
                            <td>
                                <span class="td-data-2">@{{ bankDetails.legal_country_name }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('billing.legal_state')}}</td>
                            <td>
                                <span class="td-data-2">@{{ bankDetails.legal_state_name }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('billing.legal_city')}}</td>
                            <td>
                                <span class="td-data-2">@{{ bankDetails.legal_city_name }}</span>
                            </td>
                        </tr>



                        <tr>
                            <td>{{trans('billing.legal_post_index')}}</td>
                            <td>
                                <span class="td-data-2">@{{ bankDetails.legal_post_index }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('billing.legal_street')}}</td>
                            <td><span class="td-data-2">@{{ bankDetails.legal_street }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('billing.legal_firm_name')}}</td>
                            <td><span class="td-data-2">@{{ bankDetails.legal_firm_name}}</span>
                            </td>
                        </tr>

                    </table>
                    <a
                    @click.stop.prevent="openAdressModal"
                    href="javascript:void(0);" class="admin-settings__btn btn btn--red f-right" id="firm_adress_edit">{{trans('common.edit')}}</a>
                </div>

            </div>
    </template>
@stop