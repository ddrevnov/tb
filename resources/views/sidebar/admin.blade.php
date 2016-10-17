<template id="sidebar-template">
	<aside class="sidebar">
		<ul class="sidebar__list">
			@can('admin')
				<li class="sidebar__item">
					<a href="/office">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--time"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">{{trans('common.dashboard')}}</h2>
						</div>
					</a>
				</li>
			@endcan
			<li class="sidebar__item">
				<a href="/office/orders_list">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--burger"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">{{trans_choice('common.orders', 2)}}</h2>
					</div>
				</a>
			</li>

			<li class="sidebar__item">
				<a href="/office/kalendar">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--calendar"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">{{trans('common.calendar')}}</h2>
					</div>
				</a>
			</li>
			@can('admin')
				<li class="sidebar__item">
					<a href="#">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--settings"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">{{trans('common.config')}}</h2>
						</div>
					</a>

					<ul class="sidebar__submenu">
						<li><a href="/office/billing">{{trans('common.billing')}}</a></li>
						<li><a href="/office/firmdetails">{{trans('common.firm_details')}}</a></li>
						<li><a href="/office/profil_admin">{{trans('common.personal_info')}}</a></li>
						<li><a href="/office/tariff">{{trans('layout.tariff')}}</a></li>
						<li><a href="/office/slider">{{trans('common.slider')}}</a></li>
						<li><a href="/office/kalendar_config">{{trans('common.calendar_config')}}</a></li>
					</ul>
				</li>
			@endcan
			<li class="sidebar__item">
				<a href="/office/clients">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--user"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">{{trans_choice('common.clients', 2)}}</h2>
					</div>
				</a>
			</li>
			@can('admin')
				<li class="sidebar__item">
					<a href="/office/employees">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--users"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">{{trans_choice('common.employees', 2)}}</h2>
						</div>
					</a>
				</li>
			@endcan
			@can('admin')
				<li class="sidebar__item">
					<a href="/office/services">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--services"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">{{trans_choice('common.services', 2)}}</h2>
						</div>
					</a>
				</li>
			@endcan
			@can('admin')
				<li class="sidebar__item">
					<a href="/office/newsletter">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--newsletter"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">{{trans('common.newsletter')}}</h2>
						</div>
					</a>
				</li>
			@endcan
			@can('admin')
				<li class="sidebar__item">
					<a href="/office/gastebuch">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--book"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">{{trans('common.guest_book')}}</h2>
						</div>
					</a>
				</li>
			@endcan
			@can('admin')
				<li class="sidebar__item">
					<a href="/office/notice">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--notice"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">{{trans('common.notice')}}</h2>
						</div>
					</a>
				</li>
			@endcan
			<li class="sidebar__item">
				<a href="/office/messages">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--message"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">{{trans('common.messages')}}</h2>
					</div>
				</a>
			</li>
			<li class="sidebar__item">
				<a href="/office/sms#1">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--message"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">SMS</h2>
					</div>
				</a>
				<!-- <ul class="sidebar__submenu sms">
						<li><a href="/office/sms/#1">Allgemein</a></li>
						<li><a href="/office/sms/#2">SMS-Kaufe</a></li>
						<li><a href="/office/sms/#3">Käufe</a></li>
						<li><a href="/office/sms/#4">Einstellungen</a></li>
						<li><a href="/office/sms/#5">Message</a></li>
					</ul> -->
			</li>
		</ul>
	</aside>
</template>