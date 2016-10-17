@extends('layouts.layoutDirector')
@section('content')
    <section class="director-benachrichtigung director-main">
        <h1 class="director-content__heading heading heading__h1">Benachrichtigung

        </h1>

        <div class="director-content">

            <table class="table table--striped" id="notice-table">
                <thead>
                <tr>
                    <th>Nr:</th>
                    <th>Name</th>
                    <th>Erstellt am:</th>
                    <th>Betreff</th>
                    <th>Verschickt am</th>
                </tr>
                </thead>
                <tbody>
                @if($notices)
                    <?php $i = 1?>
                    @foreach($notices as $notice)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$notice->firstname}} {{$notice->lastname}}</td>
                            <td>{{$notice->created_at->format('Y-m-d')}}</td>
                            <td>{{$notice->notice_type}}</td>
                            <td>{{$notice->created_at->format('H:i')}}</td>
                        </tr>
                        <?php $i++?>
                    @endforeach
                @endif
                </tbody>
            </table>
            {!! $notices->render() !!}
        </div>

    </section>
@stop