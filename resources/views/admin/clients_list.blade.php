@extends('layouts.layoutAdmin')
@section('content')
    <section class="director-kunden director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans('common.clients')}}
            <a class="director-tarife__btn btn btn--plus" href="/office/clients/create"><i></i>{{trans('common.add')}}</a>
        </h1>

        <div class="director-content">

            <table class="table table--striped" id="clients-table">
                <thead>
                <tr>
                    <th>{{trans('common.nr')}}</th>
                    <th>{{trans('common.first_name')}}</th>
                    <th>{{trans('common.last_name')}}</th>
                    <th>{{trans('common.mobile')}}</th>
                    <th>{{trans('common.e-mail')}}</th>
                    <th>{{trans('common.birthday')}}</th>
                    <th>{{trans('common.created_at')}}</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1 + (($clients_info->currentPage() - 1) * $clients_info->perPage())?>
                @foreach($clients_info as $client)

                    <tr style="cursor: pointer" @click.stop="goTo('/office/clients/info/{{$client->id}}')">
                            <td>{{$i}}</td>
                            <td>{{$client->first_name}}</td>
                            <td>{{$client->last_name}}</td>
                            <td>{{$client->mobile}}</td>
                            <td>{{$client->email}}</td>
                            <td>
                                @if($client->birthday == '0000-00-00')
                                    {{''}}
                                @else
                                    {{$client->birthday}}
                                @endif
                            </td>
                            <td>{{(new \DateTime($client->created_at))->format('d-m-Y')}}</td>
                    </tr>

                    <?php $i++?>
                @endforeach
                </tbody>
            </table>
            {!! $clients_info->render() !!}
        </div>

    </section>
@stop