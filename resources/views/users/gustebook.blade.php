@extends('layouts.layoutClient')
@section('content')
<div class="client-main">
    @if(isset($client))
    <aside class="client-aside">

        <div class="client-aside__avatar">
            <img class="settings-block__avatar"
                 src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}" alt="">

            <div class="client-aside__mess">{{trans('client_site.hello')}}, {{ $client->first_name }}!</div>
        </div>

        <ul class="client-aside__list">
            <li class="client-aside__item"><a href="/client/settings">{{trans('common.config')}}</a></li>
            <li class="client-aside__item"><a href="/client/newsletter">{{trans('common.newsletter')}}</a></li>
            <li class="client-aside__item"><a href="/client/logout">{{trans('layout.logout')}}</a></li>
        </ul>
    </aside>
    @else
    <aside class="client-aside">
        <div class="auth__container">
            <auth-form></auth-form>
        </div>
    </aside>
    @endif

    <div class="client-content">
        <section class="client-gustebook">
            @if(isset($client))
            <comment-form></comment-form>
            @endif

            @foreach($comments as $comment)
            <comment :data="{{$comment}}" :user-id="{{$client_id}}"></comment>
            @endforeach
            {!! $comments->links() !!}
        </section>
    </div>
</div>


<template id="comment-form-tpl">
    <h1 class="client-gustebook__heading">{{trans('client_site.guest_book')}}</h1>

    <div class="comment-form">
        <validator name="validation">
            <form novalidate>
                <div class="comment-form__rating">
                    <fieldset class="rating">
                        <input type="radio" id="star5" name="rating" value="5" v-model="comment.rating"/>
                        <label class="full" for="star5" title="Awesome - 5 stars"></label>

                        <input type="radio" id="star4" name="rating" value="4" v-model="comment.rating"/>
                        <label class="full" for="star4" title="Pretty good - 4 stars"></label>

                        <input type="radio" id="star3" name="rating" value="3" v-model="comment.rating"/>
                        <label class="full" for="star3" title="Meh - 3 stars"></label>

                        <input type="radio" id="star2" name="rating" value="2" v-model="comment.rating"/>
                        <label class="full" for="star2" title="Kinda bad - 2 stars"></label>

                        <input type="radio" id="star1" name="rating" value="1" v-model="comment.rating"/>
                        <label class="full" for="star1" title="Sucks big time - 1 star"></label>

                    </fieldset>
                </div>
                <div class="comment-form__input-fields">
                    <input class="form__input" type="text" initial="off" v-model="comment.title" name="heading"
                           v-validate:comment-title="{required: true}"
                           :classes="{ dirty: 'dirty-comment-title', invalid: 'invalid-comment-title' }"
                           placeholder="Heading"
                    >
                    <textarea class="form__input" rows="3" type="text" initial="off" v-model="comment.text" name="text"
                              v-validate:comment-text="{required: true}"
                              :classes="{ dirty: 'dirty-comment-text', invalid: 'invalid-comment-text' }"
                              placeholder="Text"
                    ></textarea>
                </div>
                <div class="comment-form__actions">
                    <button class="btn btn--red" @click="onSubmit"
                            :disabled="$validation.invalid || ($validation.valid && $validation.pristine)">{{trans('common.send')}}
                    </button>
                </div>
            </form>
        </validator>
    </div>
</template>

<template id="comment-tpl">
    <div class="comment" v-if="!showEditableForm">
        <div class="comment-preloader" v-if="deletingComment"></div>
        <div class="comment-header">
            <div class="comment-author">
                <span class="comment-author__name">@{{comment.name}}</span>
                <time class="comment-author__time">@{{comment.time}}</time>
            </div>
            <div class="comment-rating">
                <span class="comment-rating__star" v-for="star in comment.stars"></span>
            </div>
        </div>
        <div class="comment-body">
            <h2 class="comment-body__title">@{{comment.title}}</h2>

            <p class="comment-body__text">@{{comment.text}}</p>
        </div>
        <div class="comment-footer" v-if="isMyComment()">
            <div class="comment-footer__actions">
                @if(isset($client))
                <a href @click.prevent="deleteComment($event)">{{trans('common.delete')}}</a>
                <a href @click.prevent="showEditForm">{{trans('common.edit')}}</a>
                @endif
            </div>
        </div>
    </div>

    <div class="comment-form comment-form_editable" v-if="showEditableForm">
        <div class="comment-preloader" v-if="savingComment"></div>
        <div class="comment-form__rating">
            <fieldset class="rating">
                <input type="radio" id="star5-edit" name="rating" value="5" v-model="editableComment.stars"/>
                <label class="full" for="star5-edit" title="Awesome - 5 stars"></label>

                <input type="radio" id="star4-edit" name="rating" value="4" v-model="editableComment.stars"/>
                <label class="full" for="star4-edit" title="Pretty good - 4 stars"></label>

                <input type="radio" id="star3-edit" name="rating" value="3" v-model="editableComment.stars"/>
                <label class="full" for="star3-edit" title="Meh - 3 stars"></label>

                <input type="radio" id="star2-edit" name="rating" value="2" v-model="editableComment.stars"/>
                <label class="full" for="star2-edit" title="Kinda bad - 2 stars"></label>

                <input type="radio" id="star1-edit" name="rating" value="1" v-model="editableComment.stars"/>
                <label class="full" for="star1-edit" title="Sucks big time - 1 star"></label>

            </fieldset>
        </div>
        <div class="comment-form__input-fields">
            <input class="form__input" type="text" name="heading" required placeholder="{{trans('client_site.heading')}}"
                   v-model="editableComment.title">
            <textarea class="form__input" rows="3" type="text" name="text" required placeholder="{{trans('client_site.text')}}"
                      v-model="editableComment.text"></textarea>
        </div>
        <div class="comment-form__actions">
            <button class="btn btn--red" @click="updateComment">Сохранить</button>
            <a href @click.prevent="cancelComment">Отменить</a>
        </div>
    </div>
</template>

<template id="auth-form-tpl">
    <form action="/client/check" method="post" id="loginForm" v-if="showLogin">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input class="login-form__input login-form__input--email" type="text" name="email"
               placeholder="Ihre E-Mail">
        <input class="login-form__input login-form__input--pass" type="password" name="password"
               placeholder="Password">
        <input class="login-form__checkbox" type="checkbox" id="confirm" name="confirm">
        <label for="confirm">{{trans('client_site.stay_in_system')}}</label>
        <input class="login-form__submit" type="submit" value="{{trans('client_site.login')}}">

        <div>
            <a href="/client/registration">{{trans('client_site.registration')}}</a>
            <span>&middot;</span>
            <a href @click.prevent="showRestoreForm">{{trans('client_site.forgot_password')}}</a>
        </div>
    </form>
    <form action="forgotpass" v-if="showRestore" @submit.prevent="restorePassword" >
        <div class="auth-restore-form clearfix">
            <p v-if="invalidEmailRestore">{{trans('client_site.message_wrong_email')}}</p>
            <p v-if="validEmailRestore">{{trans('client_site.message_new_password_send')}}</p>
            <div class="auth-restore-form__inputs">
                <input type="email" name="forgotpass" id="forgotpass" class="login-form__input" v-model="restoreEmail" placeholder="E-mail">

            </div>
            <div class="sk-fading-circle" v-if="restoringPass">
                <div class="sk-circle1 sk-circle"></div>
                <div class="sk-circle2 sk-circle"></div>
                <div class="sk-circle3 sk-circle"></div>
                <div class="sk-circle4 sk-circle"></div>
                <div class="sk-circle5 sk-circle"></div>
                <div class="sk-circle6 sk-circle"></div>
                <div class="sk-circle7 sk-circle"></div>
                <div class="sk-circle8 sk-circle"></div>
                <div class="sk-circle9 sk-circle"></div>
                <div class="sk-circle10 sk-circle"></div>
                <div class="sk-circle11 sk-circle"></div>
                <div class="sk-circle12 sk-circle"></div>
            </div>
            <div class="auth-restore-form__actions">
                <input type="submit" class="login-form__restore fl"
                       value="{{trans('client_site.restore')}}"
                       :disabled="restoringPass">
                <a href @click.prevent="hideRestoreForm" class="fr">{{trans('client_site.back')}}</a>
            </div>
        </div>
    </form>
</template>
@stop
