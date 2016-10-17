@extends('layouts.layoutAdmin')
@section('content')
  
<section class="director-benachrichtigung director-main">
  <h1 class="director-content__heading heading heading__h1">{{trans('common.newsletter')}}</h1>

  <div class="director-content">

    <newsletter-vue></newsletter-vue>

  </div>

</section>
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
            <input type="text" class="kalendar-form__input kalendar-input kalendar-form__input--signatur" id="service_name" disabled>
          </div>
          <div class="kalendar-form__row">
            <div class="kalendar-form__input kalendar-input kalendar-form__input--text" id="service_name"></div>
          </div>

          <div class="kalendar-form__row">
            <img id="blah" src="{{isset($editMail->img) ? '/images/mailImage/' . $editMail->img : '#'}}" alt="your image" style="width: 100%"/>
          </div>

        </fieldset>
      </form>
    </div>

  </div>

</div>
  <template id="newsletter-template">
    <form class="form-article" id="formArticle" action="/office/newsletter_store" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="{{isset($editMail) ? $editMail->id : ''}}">
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <fieldset class="form-article__fields">

        <div class="form-article__field">
          <label for="betreff">{{trans('common.name')}}</label>
          <input id="betreff" type="text" name="title" value="{{{isset($editMail->title) ? $editMail->title : ''}}}">
        </div>

        <div class="form-article__field">
          <label for="betreff">{{trans('common.subject')}}</label>
          <input id="betreff" type="text" name="subject" value="{{{isset($editMail->subject) ? $editMail->subject : ''}}}">
        </div>

        <div class="form-article__field">
          <label for="von">{{trans('newsletter.from')}}:</label>
          <input id="von" type="text" name="form" value="{{$von}}">
        </div>

        <div>
          <label >Send for :</label>
          <input type="radio" name="client_type" value="all" class="radio"> {{trans('newsletter.all')}}
          <input type="radio" name="client_type" value="some" class="radio" checked> {{trans('newsletter.some')}}
        </div>
        <div class="form-article__field clients">
          <label for="inputClient">{{trans('newsletter.receives')}}:</label>
          <input type="text" name="client_id_test" id="inputClient" value="">
          @if(isset($clients))
            @foreach($clients as $client)
              <input type="hidden" class="draft-email" data-draft-id="{{$client->id}}" data-draft-email="{{$client->email}}">
            @endforeach
          @endif
        </div>
        <div>
          <input type="file" name="img" >
        </div>
      </fieldset>
      <fieldset class="form-article__btns">
        <input type="submit" class="btn btn--red" value="{{trans('newsletter.send')}}" name="send">
        <a @click.stop.prevent="preview" href="javascript:void(0);" class="btn btn--gray">{{trans('newsletter.preview')}}</a>
        <input type="submit" class="btn btn--gray" value="{{trans('newsletter.save')}}">
      </fieldset>
      <fieldset class="form-article__article">
        <textarea class="ckeditor" name="text" style="width: 900px;height: 444px;">{{{isset($editMail->text) ? $editMail->text : ''}}}</textarea>
      </fieldset>
    </form>
  </template>
    @stop