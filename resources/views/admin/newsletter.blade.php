@extends('layouts.layoutAdmin')
@section('content')
    <section class="director-benachrichtigung director-main">
        <h1 class="director-content__heading heading heading__h1">{{trans('common.newsletter')}}
                <a class="director-tarife__btn btn btn--plus" href="/office/newsletter2"><i></i>{{trans('common.add')}}</a>
            @if(session('can_create'))
                <p class=""><i></i>{{trans('newsletter.block')}}</p>
            @endif
        </h1>

        <div class="director-content" id="adminNewsletter">
            <div class="remodal kalendar-form" id="newsletterModal">
                <button data-remodal-action="close" class="remodal-close"><i></i></button>
                <div class="newsletterModal__content"></div>
            </div>

            <table class="table table--striped" id="newsletter-table">
                <thead>
                <tr>
                    <th>{{trans('common.nr')}}</th>
                    <th>{{trans('common.name')}}</th>
                    <th>{{trans('common.subject')}}</th>
                    <th>{{trans('common.time')}}</th>
                    <th>{{trans('common.date')}}</th>
                    <th>{{trans('newsletter.count_receives')}}</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1 + (($mails->currentPage() - 1) * $mails->perPage())?>
                @foreach($mails as $mail)

                    <tr onclick="document.location = '/office/newsletter/{{$mail->id}}'">
                        <td>{{$i}}</td>
                        <td>{{ $mail->title }}</td>
                        <td>{{ $mail->subject }}</td>
                        <td>{{ (new \DateTime($mail->created_at))->format("d.m.Y H:i") }}</td>
                        <td>
                            @if($mail->send)
                                {{ (new \DateTime($mail->updated_at))->format("d.m.Y H:i") }}
                            @endif
                        </td>
                        <td>{{$mail->to}}</td>

                        <td>
                            @if($mail->send === '0')
                                <a href="/office/newsletter2/{{$mail->id}}">
                                    <i class="i">
                                        {!! file_get_contents(asset('images/svg/pencil.svg')) !!}
                                    </i>
                                </a>
                            @endif
                        </td>

                        <td>
                            @if($mail->img)
                                <i class="i">
                                    {!! file_get_contents(asset('images/svg/clip.svg')) !!}
                                </i>
                            @endif
                        </td>
                    </tr>
                    <?php $i++ ?>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $mails->links() !!}
    </section>
@stop
