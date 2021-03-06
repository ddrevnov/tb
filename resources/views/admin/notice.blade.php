@extends('layouts.layoutAdmin')
@section('content')
    <section class="director-benachrichtigung director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans('common.notice')}}

        </h1>

        <div class="director-content">

            <table class="table table--striped" id="notice-table">
                <thead>
                <tr>
                    <th>{{trans('common.nr')}}</th>
                    <th>{{trans('common.date')}}</th>
                    <th>{{trans('common.subject')}}</th>
                    <th>{{trans('common.time')}}</th>
                </tr>
                </thead>
                <tbody>
                @if($notices)
                    <?php $i = 1?>
                    @foreach($notices as $notice)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$notice->created_at->format('Y-m-d')}}</td>
                            <td>{{trans('notice.'. $notice->notice_type )}}</td>
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