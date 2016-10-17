@extends('layouts.layoutAdmin')
@section('content')
	<section class="director-benachrichtigung director-main">
		<h1 class="director-content__heading heading heading__h1">{{trans_choice('common.employees', 2)}}
			<a class="director-tarife__btn btn btn--plus" href="/office/employees/create"><i></i>{{trans('common.add')}}
			</a>
		</h1>

		<employees-list-vue></employees-list-vue>

		<template id="employees-list-template">
			<div class="director-content">

				<table class="table table--striped" id="employee-table">
					<thead>
					<tr>
						<th>{{trans('common.nr')}}</th>
						<th>{{trans('common.avatar')}}</th>
						<th>{{trans('common.first_name')}}</th>
						<th>{{trans('common.mobile')}}</th>
						<th>{{trans('common.e-mail')}}</th>
						<th>{{trans('common.group')}}</th>
						<th>{{trans('common.status')}}</th>
						<th></th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php $i = 1?>
					@foreach($employees as $employee)
						<tr>
							<td>{{$i}}</td>
							<td><img class="table__avatar"
											 src="{{ isset($employee->avatarEmployee)
						                ? $employee->avatarEmployee->path
						                : asset('images/default_avatar.png') }}"
											 alt="Avatar"></td>
							<td>{{ $employee->name }}</td>
							<td>{{ $employee->phone }}</td>
							<td>{{ $employee->email }}</td>
							<td>{{ trans('employees.'. $employee->group) }}</td>
							<td>{{ $employee->status }}</td>
							<td>
								<a href="/office/employees/info/{{ $employee->id }}">
									<i class="i">
										{!! file_get_contents(asset('images/svg/pencil.svg')) !!}
									</i>
								</a>
							</td>
							<td>
								<a @click.prevent="deleteEmployee('/office/employees/delete/{{$employee->id}}')" href="/office/employees/delete/{{$employee->id}}">
									<i class="i">
										{!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
									</i>
								</a>
							</td>
						</tr>
						<?php $i++?>
					@endforeach
					</tbody>
				</table>
			</div>
		</template>
		{!!$employees->render()!!}
	</section>
@stop