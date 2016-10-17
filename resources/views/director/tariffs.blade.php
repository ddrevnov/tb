@extends('layouts.layoutDirector')
@section('content')
    <section class="director-tarife director-main">
        <h1 class="director-content__heading heading heading__h1">Tarife
            <a class="director-tarife__btn btn btn--plus" href="/backend/tariffs/create"><i></i>Hinzufügen</a>
        </h1>

        <div class="director-content">

            <table class="table table--striped" id="tariffs-table">
                <thead>
                <tr>
                    <th>Nr:</th>
                    <th>Tarif</th>
                    <th>Erstellt am:</th>
                    <th>Preise</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @if($tariffs)
                    <?php $i = 1?>
                    @foreach($tariffs as $tariff)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$tariff->name}}</td>
                            <td>{{$tariff->created_at->format('Y-m-d')}}</td>
                            <td>{{($tariff->price == '0') ? 'Free' : $tariff->price . ',- €'}}</td>
                            <td>
                                @if($tariff->status)
                                    Activ
                                @else
                                    Not activ
                                @endif
                            </td>
                            <td>
                                <a href="/backend/tariffs/edit/{{$tariff->id}}">
                                    <i class="i">
                                        {!! file_get_contents(asset('images/svg/pencil.svg')) !!}
                                    </i>
                                </a>
                            </td>
                            <td>
                                <a href="/backend/tariffs/remove/{{$tariff->id}}">
                                    <i class="i">
                                        {!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
                                    </i>
                                </a>
                            </td>
                        </tr>
                        <?php $i++?>
                    @endforeach
                @endif
                </tbody>
            </table>
            {!! $tariffs->render() !!}
        </div>
    </section>
@stop