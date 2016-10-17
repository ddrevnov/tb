@extends('layouts.layoutAdmin')
@section('content')
	<section class="admin-settings director-main">
		<h1 class="director-content__heading heading heading__h1">{{trans('tariff.tariff_info')}}</h1>

		<div class="director-content">

			<div class="remodal remodal--alert" id="freezeAlertModal">
				<p>{{trans('tariff.message_freeze_tariff')}}</p>
				<div>
					<button data-remodal-action="close" class="btn btn--red">{{trans('common.ok')}}</button>
				</div>
			</div>

			<tariff-vue></tariff-vue>

		</div>

	</section>

	<template id="tariff-temlate">

		<confirm-vue
				:is-confirm.sync="isConfirmChangeTariff"
				:show.sync="showConfirmChangeTariff">
			<p>{{trans('tariff.message_confirm')}}</p>
		</confirm-vue>

		<alert
				:show.sync="showDangerTarif"
				:duration="5000"
				type="danger"
				width="400px"
				placement="top-right"
				dismissable
		>
			<span class="icon-ok-circled alert-icon-float-left"></span>
			<strong>{{trans('tariff.message_change_tariff_error')}}</strong>
			<p>@{{ dangerReason }}</p>
		</alert>
		<div class="block">

			<ul class="block__nav">
				<li data-tab="tab-1" class="block__item is-active">{{trans('tariff.current_tariff')}}</li>
				<li data-tab="tab-2" class="block__item">{{trans('tariff.change_tariff')}}</li>
				{{--@if(!$discard_freeze)--}}
				<li data-tab="tab-3" class="block__item">{{trans('tariff.freeze_tariff')}}</li>
				{{--@endif--}}
			</ul>

			<div data-tab-id="tab-1" class="tab-content is-active">
				<div class="tarif">
					<h2 class="tarif__heading">{{$tariff_name}}</h2>
					<p class="tarif__desc">{{$tariff_description}}</p>
					<ul class="tarif__list">
						<li class="tarif__item"><i></i>{{trans('tariff.customer_management')}}</li>
						<li class="tarif__item"><i></i>{{trans('tariff.calendar')}}</li>
						<li class="tarif__item"><i></i>{{trans('tariff.booking_website')}}</li>
						<li class="tarif__item"><i></i>{{trans('tariff.services_info', ['count' => $services])}}</li>
						<li class="tarif__item"><i></i>{{trans('tariff.dashboard_info', ['count' => $dashboard])}}</li>
						<li class="tarif__item"><i></i>{{trans('tariff.newsletter_info', ['count' => $letters])}}</li>
						<li class="tarif__item"><i></i>{{trans('tariff.employee_info', ['count' => $employee])}}</li>
						<li class="tarif__item"><i></i>{{trans('tariff.email_reminder')}}</li>
					</ul>
				</div>

				<div class="tarif-info">
					<table class="table tarif-info__table">
						@if($tariff_type == 'paid')

							<tr>
								<td>{{trans('tariff.registered_from')}}:</td>
								<td>{{$registered_from}}</td>
							</tr>

							<tr>
								<td>{{trans('tariff.begin_date')}}:</td>
								<td>{{$tariff_from}}</td>
							</tr>

							<tr>
								<td>{{trans('tariff.end_year_date')}}:</td>
								<td>{{$tariff_to_year}}</td>
							</tr>

							<tr>
								<td>{{trans('tariff.price')}}:</td>
								<td>{{$price}} €</td>
							</tr>
						@else
							<tr>
								<td>{{trans('tariff.free')}}</td>
							</tr>
						@endif
					</table>
				</div>

				<a
						@click.stop.prevent="step2"
						class="admin-settings__btn btn btn--red f-right"
						href="javascript:void(0);">{{trans('tariff.change_tariff')}}</a>
			</div>

			<div data-tab-id="tab-2" class="tab-content">

				<div class="change-tarif">

					<p v-if="showAgree" class="admin-settings__text">{{trans('tariff.message_change_tariff_head')}}</p>

					<div v-if="!showAgree" class="change-tarif__tarif">
						<div class="change-tarif__header">
							{{trans('tariff.current_tariff')}}: {{$tariff_name}}
						</div>
						<div class="tarif">
							<h2 class="tarif__heading">{{$tariff_name}}</h2>
							<p class="tarif__desc">{{$tariff_description}}</p>
							<ul class="tarif__list">
								<li class="tarif__item"><i></i>{{trans('tariff.customer_management')}}</li>
								<li class="tarif__item"><i></i>{{trans('tariff.calendar')}}</li>
								<li class="tarif__item"><i></i>{{trans('tariff.booking_website')}}</li>
								<li class="tarif__item"><i></i>{{trans('tariff.services_info', ['count' => $services])}}
								</li>
								<li class="tarif__item">
									<i></i>{{trans('tariff.dashboard_info', ['count' => $dashboard])}}</li>
								<li class="tarif__item">
									<i></i>{{trans('tariff.newsletter_info', ['count' => $letters])}}</li>
								<li class="tarif__item"><i></i>{{trans('tariff.employee_info', ['count' => $employee])}}
								</li>
								<li class="tarif__item"><i></i>{{trans('tariff.email_reminder')}}</li>
							</ul>
							<div class="tarif__price">{{trans('tariff.price')}}: {{$price}} €</div>
						</div>
					</div>
					<div class="change-tarif__tarif">
						<select
								v-if="!showAgree"
								@change.stop="getSelectedTariff"
								v-model="selectedTariffId"
								class="change-tarif__header change-tarif__select" name="" id="">
							<option
									v-for="tariff in tariffs"
									:value="tariff.id">@{{ tariff.name }}</option>
						</select>
						<div class="tarif">
							<h2 class="tarif__heading">@{{ selectedTariff.name }}</h2>
							<p class="tarif__desc">@{{ selectedTariff.description }}</p>
							<ul class="tarif__list">
								<li class="tarif__item"><i></i>{{trans('tariff.customer_management')}}</li>
								<li class="tarif__item"><i></i>{{trans('tariff.calendar')}}</li>
								<li class="tarif__item"><i></i>{{trans('tariff.booking_website')}}</li>
								<li class="tarif__item">
									<i></i>@{{ $t("all.bis") | capitalize }} @{{ selectedTariff.services_unlimited === 0 ? selectedTariff.services_count : $t("all.unlimited") }} @{{ $t("all.services") | capitalize }}
								</li>
								<li class="tarif__item">
									<i></i>@{{ $t("all.bis") | capitalize }} @{{ selectedTariff.dashboard_unlimited === 0 ? selectedTariff.dashboard_count : $t("all.unlimited") }} @{{ $t("all.dashboardDays") }}
								</li>
								<li class="tarif__item"><i></i>@{{ $t("all.newsletterModule") }}
									(@{{ selectedTariff.letters_unlimited === 0 ? selectedTariff.letters_count : $t("all.unlimited") }} @{{ $t("all.recipient") }}
									)
								</li>
								<li class="tarif__item">
									<i></i>@{{ $t("all.bis") | capitalize }} @{{ selectedTariff.employee_unlimited === 0 ? selectedTariff.employee_count : 'unlimited' }} @{{ $t("all.employee") | capitalize }}
								</li>
								<li class="tarif__item"><i></i>{{trans('tariff.email_reminder')}}</li>
							</ul>
							<div class="tarif__price">{{trans('tariff.price')}}: @{{ selectedTariff.price }} €</div>
						</div>
					</div>

				</div>
				<div v-if="showAgree" class="tarif-block">
					<input @change="isDisabled = !isDisabled" v-model="isAgreeChangeTariff" type="checkbox" class="
					              tarif-block__checkbox">
					<div class="tarif-block__desc">
						<h3 class="tarif-block__heading">{{trans('tariff.message_change_tariff_footer')}}</h3>
						<p class="tarif-block__text">{{trans('tariff.message_change_tariff_footer_2')}}</p>
					</div>
				</div>
				<a
						@click.stop.prevent="setNewTariff"
						href="javascript:void(0);"
						class="admin-settings__btn btn btn--red f-right"
						:class="{'is-disabled': isDisabled}"
						:disabled="{'is-disabled': isDisabled}">{{trans('common.change')}}</a>

			</div>
			{{--@if(!$discard_freeze)--}}
			<div data-tab-id="tab-3" class="tab-content">

				<div class="tarif-step1">{!! trans('tariff.message_freeze_tariff_1') !!}</div>

				<div class="tarif-step2">
					<table class="table table--striped">

						<tr>
							<td>Vertragsinhaber</td>
							<td>{{$admin->firstname . ' ' . $admin->lastname}}</td>
						</tr>

						<tr>
							<td>Tarif</td>
							<td>{{$tariff_name}}</td>
						</tr>

						@if($tariff_type == 'paid')
							<tr>
								<td>Vertrag aktiv seit</td>
								<td>{{$tariff_from}}</td>
							</tr>
						@endif

					</table>
					<select class="tarif-step2__select" name="">
						<option value="">{{trans('tariff.technical_problem')}}</option>
						<option value="">{{trans('tariff.tariff_problem')}}</option>
						<option value="">{{trans('common.billing')}}</option>
						<option value="">{{trans('tariff.no_information')}}</option>
					</select>
				</div>

				<a @click.prevent.stop="freeze" href="javascript:void(0);"
				   class="admin-settings__btn btn btn--red f-right">Jetzt ändern</a>
			</div>
			{{--@endif--}}
		</div>
	</template>
@stop