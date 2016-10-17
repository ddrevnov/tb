<template id="sidebar-template">
	<aside class="sidebar">
		<ul class="sidebar__list">
			@can('director')
				<li class="sidebar__item">
					<a href="/backend">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--time"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">Dashborad</h2>
							<p class="sidebar__desc">доска директора</p>
						</div>
					</a>
				</li>
			@endcan
			<li class="sidebar__item">
				<a href="/backend/admins">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--time"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">Dienstleister</h2>
					</div>
				</a>
			</li>
			@can('director')
				<li class="sidebar__item">
					<a href="/backend/clients">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--time"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">Kunden</h2>
							<p class="sidebar__desc">Клиенты клиента</p>
						</div>
					</a>
				</li>
			@endcan


			@can('director')
				<li class="sidebar__item">
					<a href="/backend/orders">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--time"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">Rechnungen</h2>
							<p class="sidebar__desc">счета</p>
						</div>
					</a>

					<!-- <ul class="sidebar__submenu sidebar__submenu--admin">
						<li><a href="/backend/dienstleister">Rechnungen = Счёт</a></li>
						<li><a href="/backend/mitarbeiter">Rechnungsanschrift = Адрес фирмы</a></li>
						<li><a href="/backend/mitarbeiter2">Logo = Логотип</a></li>
						<li><a href="/backend/nachrichten">Bankverbindung = Банковские данные</a></li>
					</ul>-->
				</li>
			@endcan




			@can('director')
				<li class="sidebar__item">
					<a href="/backend/tariffs">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--time"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">Tarife </h2>
							<p class="sidebar__desc">тарифы (создание тарифов)</p>
						</div>
					</a>
				</li>
			@endcan
			@can('director')
				<li class="sidebar__item">
					<a href="/backend/notice">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--time"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">Benachrichtigung</h2>
							<p class="sidebar__desc">оповещение (оповещает владельца о всех действиях)</p>
						</div>
					</a>
				</li>
			@endcan

			<li class="sidebar__item">
				<a href="/backend/messages">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--message"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">Nachrichten</h2>
						<p class="sidebar__desc">сообщение (это в админку)</p>
					</div>
				</a>
			</li>
			@can('director')
				<li class="sidebar__item">
					<a href="/backend/newsletter">
						<div class="sidebar__left">
							<div class="sidebar__icon sidebar__icon--newsletter"><i></i></div>
						</div>
						<div class="sidebar__right">
							<h2 class="sidebar__heading heading heading__h2">Newsletter </h2>
							<p class="sidebar__desc">Рассылка (клиентам на почту)</p>
						</div>
					</a>
				</li>
			@endcan

			<li class="sidebar__item">
				<a href="/backend/employees">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--time"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">Mitarbeiter</h2>
						<p class="sidebar__desc">Сотрудники ()</p>
					</div>
				</a>
			</li>

			<li class="sidebar__item">
				<a href="/backend/sms">
					<div class="sidebar__left">
						<div class="sidebar__icon sidebar__icon--time"><i></i></div>
					</div>
					<div class="sidebar__right">
						<h2 class="sidebar__heading heading heading__h2">SMS</h2>
					</div>
				</a>
			</li>


		</ul>
	</aside>
</template>