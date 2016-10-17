@extends('layouts.layoutDirector')
@section('content')
    <span style="display: none;" id="main_user">{{$user_id}}</span>
    <section class="director-nachrichten director-main">
        <h1 class="heading heading__h1">Nachrichten</h1>

        <div class="director-content">

            <div class="block">

                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Eingang</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content tab-content--wrap is-active">
                    <chat-vue></chat-vue>
                </div>

            </div>

        </div>

    </section>

    <template id="chat-template">
        <section class="eingang">
            <div class="contacts">
                <input 
                @keyup.enter="searchUsers"
                class="eingang__search" type="search" placeholder="Suchen" autofocus>

                <div class="chat-accordion" id="chatAccordion">
                    <h3>Director employees</h3>
                    <ul class="eingang__list">
                        @foreach($director_employees as $director_employee)
                            <li
                                    @click.stop="getUser"
                                    class="eingang__item"
                                    id="{{$director_employee['id']}}">
                                <div class="avatar">
                                    <img class="avatar__img"
                                         src="{{isset($director_employee['path']) ? $director_employee['path'] : asset('images/default_avatar.png') }}"
                                         alt="">
                                    <h4 class="avatar__heading">{{$director_employee['name']}}</h4>
                                    <div class="avatar__email">{{$director_employee['email']}}</div>
                                </div>
                                <div class="contacts__count">{{$director_employee['count_new_message']}}</div>
                                <time class="contacts__time">{{$director_employee['last_new_message']['created_at']}}</time>
                                <div class="contacts__text">{{$director_employee['last_new_message']['massage']}}</div>
                            </li>
                        @endforeach
                    </ul>

                    @foreach($admin_employees as $firmlink => $admin)
                        <h3>{{$firmlink}}</h3>
                        <ul class="eingang__list">

                            <li
                            @click="getUser"
                            class="eingang__item" id="{{$admin['dir_id']}}">
                            <div class="avatar">
                                <img class="avatar__img" src="{{isset($admin['path']) ? $admin['path'] : asset('images/default_avatar.png') }}" alt="">
                                <h4 class="avatar__heading">{{$admin['dir_name']}}</h4>
                                <div class="avatar__email">{{$admin['dir_mail']}}</div>
                            </div>
                            <div class="contacts__count">{{$admin['count_new_massage']}}</div>
                            <time class="contacts__time"></time>
                            <div class="contacts__text">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                elit...
                            </div>
                            </li>

                            <li class="eingang__item">

                                <h3>Employees</h3>
                                <ul class="eingang__list">
                                    @if($admin['employee'] )
                                        @foreach($admin['employee'] as $empl)
                                            <li
                                            @click="getUser"
                                            class="eingang__item" id="{{$empl['id']}}">
                                            <div class="avatar">
                                                <img class="avatar__img" src="{{isset($empl['path']) ? $empl['path'] : asset('images/default_avatar.png') }}"
                                                     alt="">
                                                <h4 class="avatar__heading">{{$empl['name']}}</h4>
                                                <div class="avatar__email">{{$empl['email']}}</div>
                                            </div>
                                            <div class="contacts__count">{{$empl['count_new_massage']}}</div>
                                            <time class="contacts__time"></time>
                                            <div class="contacts__text">Lorem ipsum dolor sit amet, consectetuer
                                                adipiscing
                                                elit...
                                            </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>

                            </li>
                        </ul>
                    @endforeach
                </div>

            </div>

            <div v-show="showContact" class="contact" id="contact">
                <div class="avatar">
                    <img class="avatar__img" src="" alt="">
                    <h4 class="avatar__heading"></h4>
                    <div class="avatar__email"></div>
                </div>
            <div class="contact__block-wrap">
                    <div class="contact__text-block" id="allMessages">
                        <div>
                            <button
                                    @click.stop="prevBtnHandler"
                                    v-show="showPrevBtn"
                                    class="btn contact__show-prev"
                                    id="showPrevBtn">Show prev</button>
                        </div>

                        <p
                        v-for="userMessage in userMessages.messages"
                        track-by="$index"
                        :class="['contact__text', (userMessage.from == myId) ? 'right' : 'left']">
                            <span class="text">@{{ userMessage.text }}</span> 
                            <span class="time">@{{ userMessage.created_at }}</span>

                        </p>
                    </div>
                </div>
                        <textarea
                            @keyup.enter="onEnterMess"
                            v-model="text"
                            class="contact__textarea" name="">
                        </textarea>
                <button
                        @click.stop="showMessage"
                        class="btn btn--red" id="sendMessBtn">Senden
                </button>
            </div>

        </section>
    </template>
@stop