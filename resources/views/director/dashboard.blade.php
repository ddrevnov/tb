@extends('layouts.layoutDirector')
@section('content')

    <dashboard-vue></dashboard-vue>

    <template id="dashboard-template">
        <section class="director-dashboard director-main">
            <h1 class="director-dashboard__heading heading heading__h1">Dashboard</h1>
            <div class="director-content">

                <div class="director-dashboard__nav">
                    <ul class="director-dashboard__list">
                        <button
                                @click.stop="getDashboard('all')"
                                class="btn btn--green">All
                        </button>
                        <button
                                @click.stop="getDashboard('currentMonth')"
                                class="btn btn--green">Month
                        </button>
                        <button
                                @click.stop="getDashboard('currentWeek')"
                                class="btn btn--green">Week
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
                                    class="btn btn--red">Ok
                            </button>
                        </li>
                    </ul>
                </div>

                <section class="grafic">
                    <ul class="grafic__list">

                        <li class="grafic__item">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ subdomainSum }}</div>
                                <div class="grafic__desc">Subdomain orders</div>
                            </div>
                        </li>

                        <li class="grafic__item">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ calendarSum }}</div>
                                <div class="grafic__desc">Calendar orders</div>
                            </div>
                        </li>

                        <li class="grafic__item">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ deletedSum }}</div>
                                <div class="grafic__desc">Deleted orders</div>
                            </div>
                        </li>

                        <li class="grafic__item">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ clientsSum }}</div>
                                <div class="grafic__desc">Clietns count</div>
                            </div>
                        </li>

                        <li class="grafic__item">
                            <div class="grafic__ico"><i></i></div>
                            <div class="grafic__fr">
                                <div class="grafic__count">@{{ adminsSum }}</div>
                                <div class="grafic__desc">Admins count</div>
                            </div>
                        </li>

                    </ul>

                    <div class="grafic__img" id="grafic">
                    </div>
                </section>

                <section class="block-left block">
                    <ul class="block__nav">
                        <li data-tab="tab-1" class="block__item is-active">Dienstleister</li>
                        <li data-tab="tab-2" class="block__item">Kunden</li>
                    </ul>

                    <div data-tab-id="tab-1" class="tab-content is-active">
                        <table class="table table--striped">

                            <tr>
                                <th>Nr:</th>
                                <th>Name</th>
                                <th>Unternehmen</th>
                            </tr>

                            <tr v-for="admin in dashboardInfo.last_five_admins">
                                <td>@{{ $index+1 }}</td>
                                <td>@{{ admin.first_name }} @{{ admin.last_name }}</td>
                                <td>@{{ admin.firmtype }}</td>
                            </tr>

                        </table>
                    </div>

                    <div data-tab-id="tab-2" class="tab-content">
                        <table class="table table--striped">

                            <tr>
                                <th>Nr:</th>
                                <th>Name</th>
                            </tr>

                            <tr v-for="client in dashboardInfo.last_five_clients">
                                <td>@{{ $index+1 }}</td>
                                <td>@{{ client.first_name }} @{{ client.last_name }}</td>
                            </tr>

                        </table>
                    </div>

                </section>

                <section class="block-right">
                    <ul class="block-right__list">
                        @if($last_chat_messages)
                            @foreach($last_chat_messages as $message)
                                <a href="/backend/messages/{{$message->from}}">
                                    <li class="block-right__item">
                                        <img src="{{isset($message->path) ? $message->path : asset('images/default_avatar.png')}}"
                                             alt="" class="block-right__img">
                                        <h3 class="block-right__heading">
                                            @if($message->admin_first_name)
                                                {{$message->first_name}}
                                            @elseif($message->employee_first_name)
                                                {{$message->employee_first_name}}
                                            @else
                                                {{$message->dir_first_name}}
                                            @endif

                                            @if($message->admin_last_name)
                                                {{$message->admin_last_name}}
                                            @elseif($message->employee_last_name)
                                                {{$message->employee_last_name}}
                                            @else
                                                {{$message->dir_last_name}}
                                            @endif
                                            <time>{{$message->created_at}}</time>
                                        </h3>
                                        <p class="block-right__desc">{{$message->massage}}</p>
                                    </li>
                                </a>
                            @endforeach
                        @endif
                    </ul>
                </section>
                @if($statistic)
                    <section class="block-bottom block">
                        <ul class="block__nav">
                            <li data-tab="tab-3" class="block__item is-active">Land</li>
                            <li data-tab="tab-4" class="block__item">Bundesland</li>
                            <li data-tab="tab-5" class="block__item">Stadt</li>
                        </ul>

                        <div data-tab-id="tab-3" class="tab-content is-active">
                            <table class="table table--striped">

                                <tr>
                                    <th>Nr:</th>
                                    <th>Land</th>
                                    <th>Anzahl</th>
                                    <th>Anzahl in %</th>
                                </tr>
                                <?php $i = 1?>

                                @foreach($statistic['country'] as $key => $value)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$key}}</td>
                                        <td>{{$value}}</td>
                                        <td>
                                            <span class="table__percent">{{round($value / $all_firms * 100)}}%</span>
                                            <div class="table__progressbar-wrap">
                                                <div class="table__progressbar"
                                                     style="width: {{$value / $all_firms * 100}}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++?>
                                @endforeach
                            </table>
                        </div>

                        <div data-tab-id="tab-4" class="tab-content">
                            <table class="table table--striped">

                                <tr>
                                    <th>Nr:</th>
                                    <th>Bundesland</th>
                                    <th>Anzahl</th>
                                    <th>Anzahl in %</th>
                                </tr>
                                <?php $i = 1?>
                                @foreach($statistic['state'] as $key => $value)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$key}}</td>
                                        <td>{{$value}}</td>
                                        <td>
                                            <span class="table__percent">{{round($value / $all_firms * 100)}}%</span>
                                            <div class="table__progressbar-wrap">
                                                <div class="table__progressbar"
                                                     style="width: {{$value / $all_firms * 100}}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++?>
                                @endforeach
                            </table>
                        </div>

                        <div data-tab-id="tab-5" class="tab-content">
                            <table class="table table--striped">

                                <tr>
                                    <th>Nr:</th>
                                    <th>Stadt</th>
                                    <th>Anzahl</th>
                                    <th>Anzahl in %</th>
                                </tr>
                                <?php $i = 1?>
                                @foreach($statistic['city'] as $key => $value)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$key}}</td>
                                        <td>{{$value}}</td>
                                        <td>
                                            <span class="table__percent">{{round($value / $all_firms * 100)}}%</span>
                                            <div class="table__progressbar-wrap">
                                                <div class="table__progressbar"
                                                     style="width: {{$value / $all_firms * 100}}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++?>
                                @endforeach
                            </table>
                        </div>
                    </section>
                @endif
            </div>
        </section>
    </template>
@endsection