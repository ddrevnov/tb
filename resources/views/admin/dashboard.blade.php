@extends('layouts.layoutAdmin')
@section('content')

<dashboard-vue></dashboard-vue>

<template id="dashboard-template">
    <section class="director-dashboard director-main">
        <h1 class="heading heading__h1">{{trans('common.dashboard')}}</h1>

        <div class="director-content">

            <div class="director-dashboard__nav">
                <ul class="director-dashboard__list">
                    <button
                            @click.stop="getDashboard('all')"
                            class="btn btn--green">{{trans('dashboard.all')}}
                    </button>
                    <button
                            @click.stop="getDashboard('currentMonth')"
                            class="btn btn--green">{{trans('dashboard.month')}}
                    </button>
                    <button
                            @click.stop="getDashboard('currentWeek')"
                            class="btn btn--green">{{trans('dashboard.week')}}
                    </button>
                    <li class="director-dashboard__item">
                        <input
                                v-model="dateFrom"
                                type="text" id="dashboardFrom">
                        <input
                                v-model="dateTo"
                                type="text" id="dashboardTo">
                        <button
                                @click.stop="getDashboard()"
                                class="btn btn--red">{{trans('dashboard.ok')}}
                        </button>
                    </li>
                </ul>
            </div>

            <section class="grafic">
                <ul class="grafic__list grafic__list--admin">

                    <li class="grafic__item">
                        <div class="grafic__hack">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ calendarSum }}</div>
                                <div class="grafic__desc">{{trans('dashboard.calendar_orders')}}</div>
                            </div>
                        </div>
                    </li>

                    <li class="grafic__item">
                        <div class="grafic__hack">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ subdomainSum }}</div>
                                <div class="grafic__desc">{{trans('dashboard.site_orders')}}</div>
                            </div>
                        </div>
                    </li>

                    <li class="grafic__item">
                        <div class="grafic__hack">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ deletedSum }}</div>
                                <div class="grafic__desc">{{trans('dashboard.deleted_orders')}}</div>
                            </div>
                        </div>
                    </li>

                    <li class="grafic__item">
                        <div class="grafic__hack">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ emailsSum }}</div>
                                <div class="grafic__desc">{{trans('dashboard.send_e-mails')}}</div>
                            </div>
                        </div>

                    </li>

                </ul>

                <div class="grafic__hero">
                    <div class="count">@{{ ordersSum }}</div>
                    <div class="text">{{trans('dashboard.total_income')}}</div>
                </div>

                <div id="grafic" class="grafic__img grafic__img--admin"></div>
            </section>

            <section class="block-left block">
                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">{{trans_choice('common.employees', 2)}}</li>
                    <li data-tab="tab-2" class="block__item">{{trans_choice('common.services', 2)}}</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <table class="table table--striped">

                        <tr>
                            <th>{{trans('common.nr')}}</th>
                            <th>{{trans('common.name')}}</th>
                            <th>{{trans('dashboard.cost')}}</th>
                        </tr>

                        <tr v-for="employee in dashboardInfo.employee_sum">
                            <td>@{{ $index+1 }}</td>
                            <td>@{{ employee.first_name }} @{{ employee.last_name }}</td>
                            <td>@{{ employee.price }},- €</td>
                        </tr>

                    </table>
                </div>

                <div data-tab-id="tab-2" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <th>{{trans('common.nr')}}</th>
                            <th>{{trans('dashboard.favorite')}}</th>
                        </tr>

                        <tr v-for="popular in dashboardInfo.popular_goods">
                            <td>@{{ $index+1 }}</td>
                            <td>@{{ popular.service_name }}</td>
                        </tr>

                    </table>
                </div>

            </section>

            <section class="block-right">
                <ul class="block-right__list">

                    @if($last_chat_messages)
                    @foreach($last_chat_messages as $message)
                    <a href="/office/messages/{{$message->from}}">
                        <li class="block-right__item">
                        <img src="{{isset($message->path) ? $message->path : asset('images/default_avatar.png')}}" alt="" class="block-right__img">

                        <h3 class="block-right__heading">{{$message->first_name}} {{$message->last_name}}
                            <time>{{$message->created_at}}</time>
                        </h3>
                        <p class="block-right__desc">{{$message->massage}}</p>
                        </li>
                    </a>
                    @endforeach
                    @endif

                </ul>
            </section>

        </div>
    </section>
    <div class="remodal remodal-info" data-remodal-id="modal-days-limit">
        <div class="remodal-info__header">
            <button data-remodal-action="close" class="remodal-close"><i></i></button>
        </div>
        <div class="remodal-info__content">
            <h2>Limit Report History</h2>
            <p>Your tariff plan provides data for the last @{{days}} days from the current date.</p>
            <p>To remove the restriction is necessary to change the tariff plan.</p>
        </div>
        <div class="remodal-info__footer">
            <button data-remodal-action="close" class="btn btn--red">Ok</button>
        </div>


    </div>
</template>
@stop