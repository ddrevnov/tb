@extends('layouts.layoutDirector')
@section('content')

	<directorstats-vue :data="{{json_encode($data)}}"></directorstats-vue>

	<template id="directorstats-templ">
	<section class="director-kunden director-main">
		<h1 class="director-content__heading heading heading__h1">SMS
		</h1>

		<div class="director-content">
			<div class="sms_main_menu">
					<ul class="nav_sms_menu">
						<li class="is-active" data-tab="tab-1">Allgemein</li>
						<li data-tab="tab-2">SMS-Kaufe</li>
						<li data-tab="tab-3">Käufe</li>
					</ul>
				</div>
			<div class="all_sms_info_block">
				<div data-tab-id="tab-1" class="tab_content is-active">
					<div class="director_stats">
						<h2>Übersicht</h2>
						<div class="all_tables">
							<table>
								<thead>
									<tr>
										<th>SMS</th>
										<th>Gesendet</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Diesen Monat</td>
										<td>@{{ data.current_month }}</td>
									</tr>
									<tr>
										<td>Letzten Monat</td>
										<td>@{{ data.last_month }}</td>
									</tr>
								</tbody>
							</table>
							<table>
								<thead>
									<tr>
										<th>SMS</th>
										<th>Gesendet</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Heute</td>
										<td>@{{ data.today }}</td>
									</tr>
									<tr>
										<td>Gestern</td>
										<td>@{{ data.yesterday }}</td>
									</tr>
								</tbody>
							</table>
							<ul>
								<li class="title">Geplant</li>
								<li>Anzahl geplanter Nachrichten <span class="count">@{{ data.sms_count }}</span></li>
								<li>Reserviertes Guthaben	<span class="count">@{{ data.balance.amount }} €</span></li>
							</ul>
							<ul>
								<li class="title">Geplant</li>
								<li>Offene Rechnungen <span class="count">@{{ data.unpaid_orders }}</span></li>
								<li>Offene Aufträge	<span class="count">@{{ data.paid_orders }}</span></li>
							</ul>
						</div>
						<div class="grafics">
							<h3>Gesamtzahl gesendeter Nachrichten</h3>
							<div class="buttons">
								<button @click="showSMSStatistic('all')">All</button>
								<button @click="showSMSStatistic('week')">Week</button>
								<button @click="showSMSStatistic('month')">Month</button>
							</div>
							<div id="graphics_sms_director"></div>
						</div>
					</div>
				</div>
				<div data-tab-id="tab-2" class="tab_content">
					<table class="table table--striped info_table">
						<thead>
						<tr>
							<th>Nr:</th>
							<th>Price</th>
							<th>Package title</th>
							<th>Count of sms</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
							<tr style="cursor: pointer" v-for="package in data.sms_packages">
									<td @click="smsPackageEdit(package)">@{{$index+1}}</td>
									<td @click="smsPackageEdit(package)">@{{package.price}}</td>
									<td @click="smsPackageEdit(package)">@{{package.package_title}}</td>
									<td @click="smsPackageEdit(package)">@{{package.count}}</td>
									<td>
										<a href="/backend/sms/delete/@{{ package.id }}">
											<i class="i">
												{!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
											</i>
										</a>
									</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div data-tab-id="tab-3" class="tab_content">
					<div class="create_sms_package">
						<form class="form-horizontal" action="/backend/sms/store" method="post">
						{{csrf_field()}}
						<div class="form-group">
							<label for="price" class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10">
								<input type="number"
								       step="0.01"
								       min="0"
								       class="form-control"
								       id="price"
								       placeholder="price"
								       name="price">
							</div>
						</div>
						<div class="form-group">
							<label for="count" class="col-sm-2 control-label">Count sms</label>
							<div class="col-sm-10">
								<input type="number"
								       min="0"
								       class="form-control "
								       id="count"
								       placeholder="count of sms"
								       name="count">
							</div>
						</div>
						<div class="form-group">
							<label for="package_title" class="col-sm-2 control-label">Package name</label>
							<div class="col-sm-10">
								<input type="text"
								       class="form-control "
								       id="package_title"
								       placeholder="count of sms"
								       name="package_title">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Create</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</section>

		<div class="remodal kalendar-form leistungen-form" id="smsPackageModal">
			<button data-remodal-action="close" class="remodal-close"><i></i></button>

			<div class="block">
					<form class="kalendar-form__form" id="smsPackageModal" action="/backend/sms/edit/@{{ editPackage.id }}"
					      method="POST">
						<fieldset class="kalendar-form__fieldset">
							{{csrf_field()}}
							<div class="kalendar-form__row">
								<div>
									<input
											v-model="editPackage.package_title"
											type="text" name="package_title" class="kalendar-form__input kalendar-input"
											placeholder="package title">
								</div>
								<div>
									<input
											type="number" name="count" v-model="editPackage.count"
											class="kalendar-form__input kalendar-input"
											placeholder="count of sms">
								</div>
							</div>

							<div class="kalendar-form__row">
								<div>
									<input
											v-model="editPackage.price"
											type="number" name="price"
											step="0.01"
											class="kalendar-form__input kalendar-input"
											placeholder="price">
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

	</template>
@stop