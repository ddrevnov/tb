@extends('layouts.layoutAdmin')
@section('content')

	<smsinfo-vue :data="{{json_encode($sms_data)}}"></smsinfo-vue>

	<template id="smsinfo-template">
		<section class="director-benachrichtigung director-main">
			<h1 class="director-content__heading heading heading__h1">SMS

			</h1>

			<div class="director-content">
				<div class="sms_ballance">
					<p class="ballance_user">@lang('sms.sms_count')</p>
					<p class="ballance">@{{ data.sms_data.count }}</p>
				</div>
				<div class="sms_main_menu">
					<ul class="nav_sms_menu">
						<li @click="toggleMenu('#1')" :class="{'is-active': toggleMenuSms === '#1'}">@lang('sms.statistic')</li>
						<li @click="toggleMenu('#2')" :class="{'is-active': toggleMenuSms === '#2'}">@lang('sms.sms_buy')</li>
						<li @click="toggleMenu('#3')" :class="{'is-active': toggleMenuSms === '#3'}">@lang('sms.buys')</li>
						<li @click="toggleMenu('#4')" :class="{'is-active': toggleMenuSms === '#4'}">@lang('sms.settings')</li>
						<li @click="toggleMenu('#5')" :class="{'is-active': toggleMenuSms === '#5'}">@lang('sms.message')</li>
					</ul>
				</div>
				<div class="all_sms_info_block">
					<div class="tab_content" :class="{'is-active':  toggleMenuSms === '#1'}">
						<div class="sms_deatil_info">
							<div class="graphic_info">
                            <div class="buttons">
                                <button @click="showSMSStatistic('all')">@lang('sms.all')</button>
                                <button @click="showSMSStatistic('week')">@lang('sms.week')</button>
                                <button @click="showSMSStatistic('month')">@lang('sms.month')</button>
                            </div>
								<div id="graphics_sms">

								</div>
							</div>
						</div>
					</div>
					<div class="tab_content"  :class="{'is-active':  toggleMenuSms === '#2'}">
						<div class="sms_packages">

							<div class="chose_package" :class="{disable:confirmBuy}">
								<div class="sms_or_calculate" v-show="!showDetailInfo">
									<label for="sms_variable">
										<input type="radio"
										       id="sms_variable"
										       name="sms_variable"
										       value="package"
										       v-model="typeOfBuy">@lang('sms.sms_packages')</label>
									<p>@lang('sms.sms_packages_description')</p>


									<div class="all_tarifs active" :class="{disable:typeOfBuy == 'calculate'}">
										<div v-for="sms_package in data.sms_packages"
										     class="single_tarif"
										@click="chooseSMSPackage(sms_package)">

										<p class="title_sum">@{{ sms_package.count}}<span>SMS</span></p>
										<p class="name_package">@{{ sms_package.price }} €</p>

									</div>
								</div>
								<label for="sms_variable_calculate">
									<input type="radio"
									       id="sms_variable_calculate"
									       name="sms_variable"
									       value="calculate"
									       v-model="typeOfBuy">@lang('sms.sms_calculate')</label>
								<p>@lang('sms.sms_calculate_description')</p>

								<div class="calculate_sms" :class="{disable:typeOfBuy == 'package'}">
									<h3>@lang('sms.sms_calculate')</h3>
									<input type="number"
									       min="150"
									       v-model="countSMS"
									@input="calculateSMS"
									@change="checkCalculateSMS"
									      >
								</div>

							</div>

							<div class="detail_info" :class={active:showDetailInfo}>

								<div class="all_info_user">
									<h2>@lang('billing.legal_address')</h2>
									<div class="info">
										<p>@lang('billing.legal_firm_name')</p>
										<input type="text"
										       placeholder="Unternehmen"
										       v-model="data.bank_details.legal_firm_name">
									</div>
									<div class="info">
										<p>@lang('billing.legal_street')</p>
										<input type="text"
										       placeholder="Strasse / Nr."
										       v-model="data.bank_details.legal_street">
									</div>
									<div class="info">
										<p>@lang('billing.post_index')</p>
										<input type="text"
										       placeholder="Plz / Stadt"
										       v-model="data.bank_details.legal_post_index">
									</div>
									<div class="info">
										<p>@lang('billing.legal_country')</p>
										<select v-model="data.bank_details.legal_country">
											@foreach($countries as $country)
												<option value="{{$country->id}}">{{$country->name}}</option>
											@endforeach
										</select>
									</div>
								</div>

								<h2>@lang('billing.legal_address')</h2>

								<div class="radiobox">
									<label for="chose_1">
										<input type="radio"
										       id="chose_1"
										       name="check"
										       value="0"
										       v-model="data.bank_details.agreement"
										>
										@lang('sms.transfer')</label>
									<label for="chose_2">
										<input type="radio"
										       id="chose_2"
										       name="check"
										       value="1"
										       v-model="data.bank_details.agreement"
										> @lang('sms.sepa_debit')</label>
								</div>

								<div class="all_info_user" v-if="data.bank_details.agreement == 1">
									<h2>@lang('billing.bank_details')</h2>
									<div class="info">
										<p>@lang('billing.account_owner')</p>
										<input type="text"
										       placeholder="Unternehmen"
										       v-model="data.bank_details.account_owner">
									</div>
									<div class="info">
										<p>@lang('billing.bank_name')</p>
										<input type="text"
										       placeholder="Bank Name"
										       v-model="data.bank_details.bank_name">
									</div>
									<div class="info">
										<p>@lang('billing.iban')</p>
										<input type="text"
										       placeholder="IBAN"
										       v-model="data.bank_details.iban">
									</div>
									<div class="info">
										<p>@lang('billing.bic')</p>
										<input type="text"
										       placeholder="BIC"
										       v-model="data.bank_details.bic">
									</div>
									<div class="info">
										<p>Confirm</p>
										<input type="checkbox"
										       placeholder="BIC"
										       v-model="sepaRules">
									</div>
								</div>

								<div class="info_footer">
									@lang('sms.buy_information_description')
								</div>
							</div>
						</div>

						<!-- class disable for info_package from hide block -->
						<div class="info_package" :class="{disable:confirmBuy}">
							<h2>@lang('sms.buy_preview')</h2>
							<p>@lang('sms.buy_preview_price')<span class="sum">@{{ chosenPackage.price | currency '€ '}}</span></p>
							<p>@lang('sms.buy_preview_tax')<span class="sum">@{{ tax | currency '€ '}}</span></p>
							<p class="total">@lang('sms.buy_preview_sum')
								<span class="sum">
									@{{ finalSum | currency '€ '}}
								</span>
							</p>
							<button class="chose"
										@click="confirmChosen"
							              :class="{disable: !rulesOk && showDetailInfo, enable: rulesOk}">
							                  @lang('sms.buy_preview_submit')
							</button>
							<label for="rules_info" v-show="showDetailInfo">
								<input type="checkbox" id="rules_info" v-model="generalRules">
								@lang('sms.rules')
							</label>
						</div>

						<!-- class active for show thanks page   -->
						<div class="thanks_page" :class="{active:confirmBuy}">
							<h2>@lang('sms.thanks_for_buy_title')</h2>
							<p class="desc">@lang('sms.thanks_for_buy_description')</p>
						</div>


					</div>
				</div>
				<div class="tab_content" :class="{'is-active':  toggleMenuSms === '#3'}">
					<div class="detail_stats">
						<h2>
							@lang('sms.overview_orders')
						</h2>
						<div class="date_block">
							<input
									v-model="dateFrom"
									type="text" id="smsStatFrom">
							bis

							<input
									v-model="dateTo"
									type="text" id="smsStatTo">
							<button @click="filterOrdersByDate">@lang('sms.search')</button>
						</div>
						<table class="table table--striped" id="notice-table">
							<thead>
							<tr>
								<th>Nr.</th>
								<th>@lang('sms.table_tariff')</th>
								<th>@lang('sms.table_count')</th>
								<th>@lang('sms.table_date')</th>
								<th>@lang('sms.table_sum')</th>
							</tr>
							</thead>
							<tbody>
							<tr v-for="order in data.orders">
								<td>@{{ $index+1 }}</td>
								<td>@{{ order.order_s_m_s.package_title }}</td>
								<td>@{{ order.order_s_m_s.count }}</td>
								<td>@{{ order.order_s_m_s.created_at }}</td>
								<td>@{{ order.price | currency '€ ' }}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab_content" :class="{'is-active':  toggleMenuSms === '#4'}">
					<div class="settings_tab">
						<div class="left_settings">
							<h2>@lang('sms.credit_notify')</h2>
							<p>@lang('sms.credit_notify_description')</p>
						</div>
						<div class="right_settings">
							<label for="sett_1">
								<input type="radio"
								       name="settings"
								       id="sett_1"
								       value="0"
								       v-model="data.sms_data.is_notify">
								@lang('sms.disable_notify')
							</label>
							<label for="sett_2">
								<input type="radio"
								       name="settings"
								       id="sett_2"
								       value="1"
								       v-model="data.sms_data.is_notify">
								@lang('sms.enable_notify')
							</label>

							<div v-show="data.sms_data.is_notify == '1'" class="checked_info">
								<div class="label_setting">
									<label for="sett_3">
										<input type="radio"
										       name="notify"
										       value="sms"
										       id="sett_3"
										       v-model="data.sms_data.notify_type">
										@lang('sms.notify_sms')
									</label>
									<label for="sett_4">
										<input type="radio"
										       name="notify"
										       value="email"
										       id="sett_4"
										       v-model="data.sms_data.notify_type">
										@lang('sms.notify_email')
									</label>
									<label for="sett_5">
										<input type="radio"
										       name="notify"
										       value="sms+email"
										       id="sett_5"
										       v-model="data.sms_data.notify_type">
										@lang('sms.notify_sms_email')
									</label>
								</div>

								<label for="email_info_pay">
									@lang('sms.notify_limit')
									<input type="number"
									       id="email_info_pay"
									       placeholder="10"
									       v-model="data.sms_data.sms_balance_notify"> € @lang('sms.notify_limit_2').
								</label>
							</div>

							<button type="button" class="save_settings" @click="changeSMSNotify">OK</button>

						</div>
					</div>
				</div>
				<div class="tab_content" :class="{'is-active':  toggleMenuSms === '#5'}">
					<div class="custom_message">
						<h2>@lang('sms.message_edit')</h2>
							
							<div class="message_form">
								<div class="left">

									<div class="originator">
										<p>@lang('sms.message_originator'):</p>
										<input type="text" id="titleSMS" v-model="data.sms_data.title">
									</div>
									<p>@lang('sms.message_body')</p>
									<textarea id="smsBody"
									          placeholder="Write your message"
									          v-model="data.sms_data.body"
									          maxlength="1300"></textarea>
									<span>@{{ data.sms_data.body.length }}/1300 SMS: @{{ smsBodyCount }}</span>

								</div>
								<div class="right">
									<select @change="setBodyField"
									               id="select_contact">
										<option value="[FIRST_NAME]">First name</option>
										<option value="[LAST_NAME]">Last name</option>
										<option value="[FROM]">Time from</option>
										<option value="[TO]">Time to</option>
										<option value="[DATE]">Date</option>
										<option value="[COUNTRY]">Country</option>
										<option value="[CITY]">City</option>
										<option value="[STREET]">Street</option>
										<option value="[FIRM_TELNUMBER]">Telnumber</option>
										<option value="[E_FIRST_NAME]">Employee first name</option>
										<option value="[E_LAST_NAME]">Employee last name</option>
										<option value="[SERVICE_TITLE]">Service title</option>
										<option value="[SERVICE_PRICE]">Service price</option>
									</select>
								</div>
							</div>
							<div class="save_mess">
								<button @click="saveSMSContent">@lang('sms.message_save')</button>
							</div>
					</div>
				</div>
			</div>
			</div>

		</section>
	</template>
@stop