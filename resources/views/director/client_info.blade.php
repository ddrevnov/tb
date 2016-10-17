@extends('layouts.layoutDirector')
@section('content')


	<user-info-vue></user-info-vue>

	<template id="user-info-template">

		<section class="director-mitarbeiter director-main">
			<h1 class="director-content__heading heading heading__h1">{{trans('common.clients')}}</h1>

			<div class="director-content">
				<section class="user-info">
					<ul class="user-info__list">

						<div
								class="user-info__block-img">
							<div v-show="showImgPreloader" class="user-info__preloader">
								<i></i>
							</div>
							<div class="crops"></div>
							<img class="user-info__avatar"
							     src="{{isset($client_info->avatarClient) ? $client_info->avatarClient->path : asset('images/default_avatar.png') }}"
							     alt="">
						</div>

						<div>
						</div>
						<li class="user-info__name">
							<h2 class="user-info__heading">{{trans('common.first_name')}} {{trans('common.last_name')}}</h2>
							<div>{{$client_info->first_name}} {{$client_info->last_name}}</div>
						</li>

						<li class="user-info__contact">
							<h2 class="user-info__heading">{{trans('common.contact')}}</h2>
							<div class="user-info__phone"><i></i> <span>{{$client_info->mobile}}</span></div>
							<div class="user-info__email"><i></i> <span>{{$client_info->email}}</span></div>
						</li>

						<li class="user-info__data">
							<h2 class="user-info__heading">{{trans('common.personal_info')}}Daten</h2>
							<div><strong>Geschlecht:</strong>{{$client_info->gender}}</div>
							<div><strong>Geburstag:</strong>{{$client_info->birthday}}</div>
						</li>
					</ul>
				</section>

				<section class="director-dienstleister2__main director-mitarbeiter__main">

					<div class="block">

						<ul class="block__nav block__nav--flex">
							<li data-tab="tab-1" class="block__item is-active">Protocoll</li>
							<li data-tab="tab-2" class="block__item">Orders</li>
						</ul>
						<div data-tab-id="tab-1" class="tab-content is-active">
							<table class="table table--striped table--avatar">
								<thead>
								<tr>
									<th>Nr:</th>
									<th>Datum</th>
									<th>Author</th>
									<th>Type</th>
									<th>Changes</th>
								</tr>
								</thead>
								<tbody>
								<?php $i = 1 + (($protocols->currentPage() - 1) * $protocols->perPage())?>
								@foreach($protocols as $protocol)
									<tr>
										<td>{{$i}}</td>
										<td>{{$protocol->created_at}}</td>
										@if($protocol->author == 'admin')
											<td>
												<img class="table__avatar" src="{{isset($protocol->admin->avatar->path) ? $protocol->admin->avatar->path : asset('images/default_avatar.png') }}"></td>
										@else
											<td>
												<img class="table__avatar" src="{{isset($client->avatar) ? $client->avatar->path : asset('images/default_avatar.png') }}"></td>
										@endif
										<td>{{trans('protocol.' . $protocol->type)}}</td>
										<td>{{$protocol->old_value .' -> '. $protocol->new_value}}</td>
									</tr>
									<?php $i++ ?>
								@endforeach
								</tbody>
							</table>
							{!! $protocols->render() !!}
						</div>

						<div data-tab-id="tab-2" class="tab-content ">
							<table class="table table--striped" id="client-orders-list">
								<thead>
								<tr>
									<th>{{trans('common.nr')}}</th>
									<th>{{trans_choice('common.services', 1)}}</th>
									<th>{{trans('common.price')}}</th>
								</tr>
								</thead>
								@if($orders)
									<tbody>
									<?php $i = 1 + (($orders->currentPage() - 1) * $orders->perPage())?>
									@foreach($orders as $order)
										<tr>
											<td>{{$i}}</td>
											<td>{{$order->service->service_name}}</td>
											<td>{{$order->price}} EUR</td>
										</tr>
										<?php $i++?>
									@endforeach
									</tbody>
								@endif
							</table>
							{!!$orders->render()!!}
						</div>

					</div>
				</section>
			</div>
		</section>
	</template>
@stop