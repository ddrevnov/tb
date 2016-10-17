<!doctype html>
<html class="no-js" lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="locale" content="de">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> director-dashboard </title>

        <link rel="stylesheet" type="text/css" href="{{ asset('styles/token-input.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('styles/token-input-facebook.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('styles/token-input-mac.css') }}" />
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300italic,600italic,700italic,400italic,300' rel='stylesheet' type='text/css'>
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="{{ asset('styles/admin.css') }}">
    </head>
    <body class="page">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <input type="hidden" name="my_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">

        <div id="sitePreloader"></div>

        <div class="container">

            @if(Session::has('status'))
                <div class="alert alert-info">{{ Session::get('status') }}</div>
            @endif

        <header-vue></header-vue>

            <template id="header-template">
                <header class="admin-header">
                <div class="admin-header__logo">
                    <a href="/backend/">
                        <img src="{{ asset('images/admin-logo.png') }}" alt="">
                    </a>

                    <ul class="search__icons">
                        <li class="search__send">
                            <a 
                              @click.stop.prevent="showUserPopupHandler"
                              href="javascript:void(0);" id="display_new_massage"><i></i></a>
                            <span v-show="users.length" class="search__count">@{{users.length}}</span>
                            <div
                            v-if="users.length"
                            v-show="showUsersPopap"
                            class="mess-popup"
                            v-cloak>
                                    <a
                                        v-show="$index < showMoreMess"
                                        v-for="user in users | reverseArr" track-by="$index"
                                        class="mess-popup__link" href="@{{'/'+pathWho+'/messages/'+user.from }}">
                                        <span class="mess-popup__avatar">
                                            <img class="mess-popup__img" :src="user.path ? user.path : '/images/default_avatar.png'" alt="Avatar">
                                        </span>
                                        <span class="mess-popup__name">@{{ user.first_name }} @{{ user.last_name }}</span>
                                        <span class="mess-popup__text">@{{ user.message }}</span>
                                    </a>
                                <div v-show="showMoreMess < users.length" class="mess-popup__more">
                                    <a
                                        @click.stop.prevent="showMoreMess += 3"
                                        href="javascript:void(0);" class="mess-popup__link--blue">See more</a>
                                </div>
                            </div>
                        </li>

                        <li class="search__notif">
                            <a 
                            @click.stop="showNewAdminsPopupHandler"
                            href="javascript:void(0);"><i></i></a>
                            <span v-show="notifications.length" class="search__count">@{{ notifications.length }}</span>

                          <div v-show="showNewAdminsPopap">
                              <div
                                      v-if="notifications.length"
                                      v-show="showNewAdminsPopap"
                                      class="mess-popup"
                                      v-cloak>
                                  <div
                                          v-show="$index < showMoreNotices"
                                          v-for="notification in notifications | reverseArr" track-by="$index"
                                          class="mess-popup__link">
                                        <span class="mess-popup__avatar">
                                            <img class="mess-popup__img" :src="notification.path ? notification.path : '/images/default_avatar.png'" alt="Avatar">
                                        </span>
                                      <button v-if="!(notification.notice_type === 'new_registration')" @click.stop="deleteNotice(notification)" class="mess-popup__delete">x</button>
                                      <a
                                      @click.stop.prevent="transitionLink(notification, $event)"
                                      class="mess-popup__link--blue"
                                      href="/@{{ pathWho }}/@{{ notification.notice_type === 'new_registration' ? 'admins_new' : 'admins' }}/@{{ notification.admin_id }}">
                                          @{{ notification.firstname }} @{{ notification.lastname }}
                                      </a>
                                      <span class="mess-popup__type">@{{ notification.notice_type | noticeHeaderName }}</span>
                                      <div class="mess-popup__time">@{{ notification.created_at | getRelativeTime }}</div>
                                  </div>
                                  <div v-show="showMoreNotices < notifications.length" class="mess-popup__more">
                                      <a
                                      @click.stop.prevent="showMoreNotices += 3"
                                      href="javascript:void(0);" class="mess-popup__link--blue">See more</a>
                                  </div>
                              </div>
                          </div>
                        </li>
                    </ul>
                </div>
                <div class="search">
                    <div class="search__input">
                        <input
                        @keydown.esc="reset"
                        @input="search | debounce 500"
                        v-model="query" 
                        type="text" placeholder="Was möchten Sie suchen?">
                        <i></i>

                            <!-- the list -->
                          <div 
                            v-if="showSearchList"
                            class="search-list">
                              <div class="search-list__block">
                                  <div 
                                  class="search-list__heading" 
                                  v-if="searchData.admins.length">Admins</div>
                                  <ul class="search-list__list">
                                      <li 
                                      v-for="admin in searchData.admins"
                                      class="search-list__item">
                                          <a
                                                  v-if="admin.admin_last_name"
                                                  :href="'/' + pathWho + '/admins/'+ admin.id">@{{ admin.admin_last_name }}</a>
                                          <a
                                                  v-if="admin.admin_first_name"
                                                  :href="'/' + pathWho + '/admins/'+ admin.id">@{{ admin.admin_first_name }}</a>
                                          <a
                                                  v-if="admin.admin_email"
                                                  :href="'/' + pathWho + '/admins/'+ admin.id">@{{ admin.admin_email }}</a>
                                      </li>
                                  </ul>
                              </div>

                              <div class="search-list__block">
                                  <div
                                          class="search-list__heading"
                                          v-if="searchData.clients.length">Clients</div>
                                  <ul class="search-list__list">
                                      <li
                                              v-for="client in searchData.clients"
                                              class="search-list__item">
                                          <a
                                                  v-if="client.client_first_name"
                                                  :href="'/' + pathWho + '/clients/'">@{{ client.client_first_name }}</a>
                                          <a
                                                  v-if="client.admin_last_name"
                                                  :href="'/' + pathWho + '/clients/'">@{{ client.client_last_name }}</a>
                                          <a
                                                  v-if="client.client_email"
                                                  :href="'/' + pathWho + '/clients/'">@{{ client.client_email }}</a>
                                      </li>
                                  </ul>
                              </div>

                              <div class="search-list__block">
                                  <div
                                          class="search-list__heading"
                                          v-if="searchData.admins_new.length">New Admins</div>
                                  <ul class="search-list__list">
                                      <li
                                              v-for="admin_new in searchData.admins_new"
                                              class="search-list__item">
                                          <a
                                                  v-if="admin_new.admin_first_name"
                                                  :href="'/' + pathWho + '/admins_new/'+admin_new.id">@{{ admin_new.admin_first_name }}</a>
                                          <a
                                                  v-if="admin_new.admin_last_name"
                                                  :href="'/' + pathWho + '/admins_new/'+admin_new.id">@{{ admin_new.admin_last_name }}</a>
                                          <a
                                                  v-if="admin_new.admin_telnumber"
                                                  :href="'/' + pathWho + '/admins_new/'+admin_new.id">@{{ admin_new.admin_telnumber }}</a>
                                          <a
                                                  v-if="admin_new.admin_email"
                                                  :href="'/' + pathWho + '/admins_new/'+admin_new.id">@{{ admin_new.admin_email }}</a>
                                      </li>
                                  </ul>
                              </div>

                              <div class="search-list__block">
                                  <div 
                                  class="search-list__heading" 
                                  v-if="searchData.employees.length">Employees</div>
                                  <ul class="search-list__list">
                                      <li 
                                      v-for="employee in searchData.employees"
                                      class="search-list__item">
                                          <a
                                                  v-if="!!employee.employee_first_name"
                                                  :href="'/' + pathWho + '/admins/edit_employee/'+ employee.id">
                                            @{{ employee.employee_first_name }}
                                          </a>
                                          <a
                                                  v-if="!!employee.employee_email"
                                                  :href="'/' + pathWho + '/admins/edit_employee/'+ employee.id">
                                              @{{ employee.employee_email }}
                                          </a>
                                      </li>
                                  </ul>
                              </div>

                              <div class="search-list__block">
                                  <div
                                          class="search-list__heading"
                                          v-if="searchData.bills.length">Bills</div>
                                  <ul class="search-list__list">
                                      <li
                                              v-for="bill in searchData.bills"
                                              class="search-list__item">
                                          <a
                                                  v-if="!!bill.bill_number"
                                                  :href="'/' + pathWho + '/orders/download/' + bill.id">
                                              @{{ bill.bill_number }}
                                          </a>
                                      </li>
                                  </ul>
                              </div>

                              <div class="search-list__block">
                                  <div 
                                  class="search-list__heading" 
                                  v-if="searchData.letters.length">Letters</div>
                                  <ul class="search-list__list">
                                      <li 
                                      v-for="letter in searchData.letters"
                                      class="search-list__item">
                                      <a
                                              v-if="!!letter.subject"
                                              :href="'/' + pathWho + '/newsletter/'+ letter.id">
                                          @{{ letter.subject }}
                                      </a>
                                      </li>
                                  </ul>
                              </div>

                            </div>
                    </div>
                </div>

<div class="admin-header__right">
            <header-time-vue></header-time-vue>
            <div class="admin-header__avatar">
                <a href="#">
                    <img class="user-info__avatar-small" src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}" alt=""
                         style="width: 48px;height: 48px">
                </a>
                <ul>
                    <li><a href="/backend/profil">Profil bearbeiten</a></li>
                    <li><a href="/backend/tariffs">Tarife</a></li>
                    <li><a href="/backend/orders">Rechnung</a></li>
                    <li><a href="#">Geben Sie Ihr Feedback</a></li>
                    <li><a href="/logout">Abmelden</a></li>
                </ul>
            </div>
            <div class="admin-header__question"><a href="#"><i></i></a></div>
            <a href="#"></a>
        </div>
    </header>
            </template>

            <div class="container__in">
            
              <sidebar-vue></sidebar-vue>

                @include('sidebar.director')

                @yield('content')
                <footer class="admin-footer">
                    <select v-model="locale" @change.stop="changeLocale" class="admin-footer__select select" name="locale">
                        <option value="lang-de">DE</option>
                        <option value="lang-en">EN</option>
                    </select>

                    <div class="admin-footer__copy"> &copy; 20013-2015 GrafikonDesign UG</div>
                </footer>
            </div>

        </div>
        
        <script src="{{ asset('scripts/libs/socket.io-1.3.4.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery.formstyler.min.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery.sticky.js') }}"></script>
        <script src="{{ asset('scripts/libs/slick.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('scripts/libs/messages_ru.js') }}"></script>
        <script src="{{ asset('scripts/libs/messages_de.js') }}"></script>
        <script src="{{ asset('scripts/libs/remodal.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery-ui-timepicker-addon.js') }}"></script>
        <script src="{{ asset('scripts/libs/spectrum.js') }}"></script>
        <script src="{{ asset('scripts/libs/d3.min.js') }}"></script>
        <script src="{{ asset('scripts/libs/c3.min.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery.tokeninput.js') }}"></script>
        <script src="{{ asset('scripts/libs/jquery.tablesorter.js') }}"></script>
        <script src="{{ asset('scripts/admin.js') }}"></script>
        <script src="{{ asset('scripts/director.js') }}"></script>
        <script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
    </body>
</html>
