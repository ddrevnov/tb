@extends('layouts.layoutDirector')
@section('content')
<section class="director-benachrichtigung director-main">
    <h1 class="director-content__heading heading heading__h1">Newsletter
        <a class="director-benachrichtigung__btn btn btn--plus" href="/backend/newsletter2"><i></i>Hinzufügen</a>
    </h1>


    <div class="director-content" id="directorNewsletter">
        <div class="remodal kalendar-form" id="newsletterModal">
            <button data-remodal-action="close" class="remodal-close"><i></i></button>
            <div class="newsletterModal__content"></div>
        </div>

        <table class="table table--striped" id="newsletter-table">
            <thead>
                <tr>
                    <th>Nr:</th>
                    <th>Name</th>
                    <th>Betreff</th>
                    <th>Erstellt am:</th>
                    <th>Verschickt am</th>
                    <th>Anzahl der Empfänger</th>
                </tr>
            </thead>
            <?php $i = 1 + (($mails->currentPage() - 1) * $mails->perPage())?>
            <tbody>
                @foreach($mails as $mail)
                <tr onclick="document.location = '/backend/newsletter/{{$mail->id}}'">
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
                            <a href="/backend/newsletter2/{{$mail->id}}">
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
        {!! $mails->links() !!}
    </div>

</section>
@stop