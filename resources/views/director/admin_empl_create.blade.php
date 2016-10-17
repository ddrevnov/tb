@extends('layouts.layoutDirector')
@section('content')
	<section class="director-mitarbeiter director-main">
		<h1 class="director-content__heading heading heading__h1">Mitarbeiter</h1>
		<form method="post" action="admin_empl_store" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{!! csrf_token() !!}">
			<div class="director-content">

				<section class="user-info">
					<ul class="user-info__list">


						<li class="user-info__name">
							<h2 class="user-info__heading">Avatar</h2>
							<img src="{{asset('images/default_avatar.png') }}">
							<div><input type="file" name="avatar"></div>
						</li>

						<li class="user-info__name">
							<h2 class="user-info__heading">Name & Vorname</h2>
							<div>
								<input class="user-info__input" type="text" name="name" required>
								<input class="user-info__input" type="text" name="last_name" required>
							</div>
						</li>

						<li class="user-info__contact">
							<h2 class="user-info__heading">Kontact</h2>
							<div class="user-info__phone"><i></i>
								<input class="user-info__input" type="tel" name="phone">
							</div>
							<div class="user-info__email"><i></i>
								<input @blur="checkEmail($event, '/backend/check_email')"
							                class="user-info__input" type="email" name="email" required>
							</div>
						</li>

						<li class="user-info__data">
							<h2 class="user-info__heading">Persönliche Daten</h2>
							<div><strong>Geschlecht:</strong>
								<select name="gender">
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
							</div>
							<div><strong>Geburstag:</strong>
								<input class="user-info__input input-date" name="birthday" type="text">
							</div>
						</li>

						<li class="user-info__data">
							<h2 class="user-info__heading">Status</h2>
							<div><strong>Group:</strong>
								<select name="group">
									<option value="admin">Admin</option>
									<option value="employee">Employee</option>
								</select>
							</div>
							<div><strong>Status:</strong>
								<select name="status">
									<option value="active">Active</option>
									<option value="not active">Not active</option>
								</select>
							</div>
						</li>

					</ul>


				</section>

				<section class="director-dienstleister2__main director-mitarbeiter__main">

					<table class="table table--striped">

						<tr>
							<th>Nr:</th>
							<th>Leistung</th>
							<th>Status</th>
						</tr>
						<?php $i = 1?>
						@foreach($services as $service)
							<tr>
								<td>{{$i}}</td>
								<td>{{ $service->service_name }}</td>
								<td><input class="checkbox" type="checkbox" name="services[]"
								           value="{{ $service->id }}"></td>
							</tr>
							<?php $i++?>
						@endforeach
					</table>

					<div class="director-dienstleister2__bottom">
						<button type="submit" class="btn btn--red">Create now</button>
					</div>
				</section>
			</div>
		</form>
	</section>

@stop