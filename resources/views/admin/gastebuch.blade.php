@extends('layouts.layoutAdmin')
@section('content')
    <section class="director-kunden director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans('common.guest_book')}}</h1>

        <div class="director-content">

            <table class="table table--striped">

                <tr>
                    <th>{{trans('common.nr')}}</th>
                    <th>{{trans('common.first_name')}}</th>
                    <th>{{trans('guest_book.comment')}}</th>
                    <th>{{trans('guest_book.rating')}}</th>
                    <th>{{trans('common.date')}}</th>
                    <th>{{trans('common.status')}}</th>

                </tr>

                <?php $t = 1?>
                @foreach($comments as $comment)
                    <tr>
                    <td>{{$t}}</td>

                        <td>{{$comment->client->first_name}}</td>
                    <td>{{ $comment->text}}</td>
                    <td>
                        @for ($i = 0; $i < $comment->star; $i++)
                            <span class="director-guestbook__star"></span>
                        @endfor
                    </td>
                    <td>{{ $comment->created_at}}</td>
                    <td>Aktiv</td>
                </tr>
                 <?php $t++?>
                @endforeach
            </table>
            {!! $comments->render()!!}
        </div>

    </section>


    @stop


