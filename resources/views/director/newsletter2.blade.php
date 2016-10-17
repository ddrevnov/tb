@extends('layouts.layoutDirector')
@section('content')
    <section class="director-benachrichtigung director-main">
        <h1 class="director-content__heading heading heading__h1">Newsletter</h1>

        <div class="director-content">

            <newsletter-vue></newsletter-vue>

        </div>
        <div class="remodal kalendar-form leistungen-form" id="mailModal">
            <button data-remodal-action="close" class="remodal-close"><i></i></button>

            <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Mail</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <form class="kalendar-form__form" action="">
                        <fieldset class="kalendar-form__fieldset">
                            <div class="kalendar-form__row">
                                <input type="text" class="kalendar-form__input kalendar-input kalendar-form__input--betref" id="service_name" disabled>
                            </div>
                            <div class="kalendar-form__row">
                                <input type="text" class="kalendar-form__input kalendar-input kalendar-form__input--von" id="service_name" disabled>
                            </div>
                            <div class="kalendar-form__row">
                                <div class="kalendar-form__input kalendar-input kalendar-form__input--text" id="service_name"></div>
                            </div>

                            <div class="kalendar-form__row">
                                <img id="blah" src="{{isset($editMail->img) ? '/images/mailImage/' . $editMail->img : '#'}}" alt="your image" style="width: 100%;"/>
                            </div>

                        </fieldset>
                    </form>
                </div>

            </div>

        </div>
    </section>

    <template id="newsletter-template">
        <form class="form-article" id="formArticle" action="{{ action('Director\MailController@storeMail') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{isset($editMail) ? $editMail->id : ''}}">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <fieldset class="form-article__fields">

                <div class="form-article__field">
                    <label for="betreff">Name</label>
                    <input id="betreff" type="text" name="title" value="{{isset($editMail->title) ? $editMail->title : ''}}" required>
                </div>

                <div class="form-article__field">
                    <label for="betreff">Betref</label>
                    <input id="betreff" type="text" name="subject" value="{{isset($editMail->subject) ? $editMail->subject : ''}}" required>
                </div>

                <div class="form-article__field">
                    <label for="von">Von:</label>
                    <input id="von" type="text" name="form" value="{{$von}}" required>
                </div>

                <div class="form-article__box">
                    <label >Send for :</label>
                    <div class="form-article__radio-box">
                        <label>
                            <input type="radio" name="admin_type" value="all" class="radio"> All
                        </label>
                        <label>
                            <input type="radio" name="admin_type" value="some" class="radio" checked> Some
                        </label>


                    </div>
                </div>
                <div class="form-article__field admins">
                    <label for="inputAdmin">Empfanger:</label>
                    <input type="text" name="admin_id_test" id="inputAdmin">
                    @if(isset($admins))
                        @foreach($admins as $admin)
                            <input type="hidden" class="draft-email" data-draft-id="{{$admin->id}}" data-draft-email="{{$admin->email}}">
                        @endforeach
                    @endif
                </div>
                <div>
                    <input type="file" name="img">
                </div>
            </fieldset>
            <fieldset class="form-article__btns">
                <input type="submit" class="btn btn--red" value="Absenden" name="send">
                <a @click.stop.prevent="preview" href="javascript:void(0);" class="btn btn--gray">Vorschau</a>
                <input type="submit" class="btn btn--gray" value="Speichern">
            </fieldset>
            <fieldset class="form-article__article">
                <textarea class="ckeditor" name="text" style="width: 900px;height: 444px;">{{isset($editMail->text) ? $editMail->text : ''}}</textarea>
            </fieldset>
        </form>
    </template>
    @stop