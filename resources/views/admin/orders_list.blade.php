@extends('layouts.layoutAdmin')
@section('content')
    <section class="director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans_choice('common.orders', 2)}}</h1>

        <div class="director-content">

            <table class="table table--striped" id="calendar-table">
                <thead>
                <tr><th>{{trans('common.nr')}}</th>
                    <th>{{trans('common.first_name')}}</th>
                    <th>{{trans('common.last_name')}}</th>
                    <th>{{trans_choice('common.services', 1)}}</th>
                    <th>{{trans_choice('common.employees', 1)}}</th>
                    <th>{{trans('common.time')}}</th>
                    <th>{{trans('common.date')}}</th>
                    <th>{{trans('common.sum')}}</th>
                    <th>{{trans('common.status')}}</th>
                    <th>{{trans('common.date_deleted')}}</th>
                </tr>
                </thead>

                <tbody>
                <?php $i= $calendarData->total() - (($calendarData->currentPage() - 1) * $calendarData->perPage())?>
                @foreach($calendarData as $calendars)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$calendars->first_name}}</td>
                    <td>{{$calendars->last_name}}</td>
                    <td>{{$calendars->service_name}}</td>
                    <td>{{$calendars->name}}</td>
                    <td>{{$calendars->time_from}}</td>
                    <td>{{$calendars->date}}</td>
                    <td>{{$calendars->price}} EUR</td>
                    <td>{{$calendars->status}}</td>
                    <td>{{isset($calendars->date_deleted) ? $calendars->date_deleted : ''}}</td>
                </tr>


            <?php $i--?>
            @endforeach
            </tbody>
            </table>
        </div>
        {!! $calendarData->links()!!}
    </section>
    @stop
