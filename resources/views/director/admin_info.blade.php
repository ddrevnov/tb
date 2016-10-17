@extends('layouts.layoutDirector')
@section('content')
@include('remodals.remodal')

<services-vue></services-vue>

<template id="services-template">
    <section class="director-dienstleister2 director-main">
    <h1 class="director-content__heading heading heading__h1">Dienstleister</h1>

    <div class="director-content">

    @include('remodals.services_remodal')

    <user-info-vue></user-info-vue>

        <section class="director-dienstleister2__main">

            <div class="block">

                <ul class="block__nav block__nav--flex">
                    <li data-tab="tab-1" class="block__item is-active">Mitarbeiter</li>
                    <li data-tab="tab-2" class="block__item">Rechnungen</li>
                    <li @click.stop="getWorktimes" data-tab="tab-3" class="block__item">Öffnungszeiten</li>
                    <li data-tab="tab-4" class="block__item">Standorte</li>
                    <li data-tab="tab-5" class="block__item">Leistungen</li>
                    <li data-tab="tab-6" class="block__item">Protocoll</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <table class="table table--striped table--avatar" id="employee-table">
                        <thead>
                            <tr>
                                <th>Nr:</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Telefon</th>
                                <th>E-Mail</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1 + (($employee->currentPage() - 1) * $employee->perPage())?>
                        @foreach($employee as $empl)
                        <tr data-employee-id="{{$empl->id}}">
                            <td>{{$i}}</td>
                            <td>
                                <img class="table__avatar" src="{{isset($empl->avatarEmployee) ? $empl->avatarEmployee->path : asset('images/default_avatar.png') }}" alt=""></td>
                            <td>
                                <span  class="span-empl" id="empl-name">{{$empl->name}}</span>
                            </td>
                            <td>
                                <span class="span-empl" id="empl-phone">{{$empl->phone}}</span>
                            </td>
                            <td>
                                <span class="span-empl" id="empl-email">{{$empl->email}}</span>
                            </td>
                            <td>
                                <span class="span-empl" id="empl-status">{{$empl->status}}</span>
                            </td>
                            <td><a href="{{'/backend/admins/edit_employee/' . $empl->id}}" class="edit_admin_employees">
                                <i class="i">
                                    {!! file_get_contents(asset('images/svg/pencil.svg')) !!}
                                </i>
                            </a></td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $employee->render() !!}

                    <div class="admin-edit-button" id="create_new_employee">
                        <a href="/backend/admins/{{$admin->id}}/create_employee" class="btn btn--red">Create new Employee</a>
                    </div>

                </div>
                <div data-tab-id="tab-2" class="tab-content tab-content--level2">

                    <div class="block">

                        <ul class="block__nav">
                            <li data-tab="tab-6" class="block__item is-active">Nicht bezahlt Rechnungen</li>
                            <li data-tab="tab-7" class="block__item">Bankverbindung</li>
                        </ul>

                        <div data-tab-id="tab-6" class="tab-content is-active">
                            <ul class="rechnungen">
                                @if($orders)
                                    @foreach($orders as $order)
                                    <li class="rechnungen__item">
                                        <div class="rechnungen__wrap">
                                            <div class="rechnungen__name">Rechnung vom {{$order->created_at}}</div>
                                            <div class="rechnungen__desc">{{$order->status}}</div>
                                            <div class="rechnungen__price">
                                                {{($order->price + $order->extra_price > 1) ? $order->price + $order->extra_price : '0' }}€
                                            </div>
                                        </div>
                                        <a class="btn btn--red" href="/backend/orders/download/{{$order->id}}">Rechnung downloaden</a>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div data-tab-id="tab-7" class="tab-content">
                            @if($bank_details)
                            <table class="table table--striped">
                                <tr>
                                    <td>Kontoinhaber</td>
                                    <td>{{$bank_details->account_owner}}</td>
                                </tr>
                                <tr>
                                    <td>Kontonummer</td>
                                    <td>{{$bank_details->account_number}}</td>
                                </tr>
                                <tr>
                                    <td>Bankleitzahl</td>
                                    <td>{{$bank_details->bank_code}}</td>
                                </tr>
                                <tr>
                                    <td>Bankname</td>
                                    <td>{{$bank_details->bank_name}}</td>
                                </tr>
                                <tr>
                                    <td>IBAN</td>
                                    <td>{{$bank_details->iban}}</td>
                                </tr>
                                <tr>
                                    <td>BIC</td>
                                    <td>{{$bank_details->bic}}</td>
                                </tr>
                            </table>
                            @else
                                <p>NOT AGGREMENT FOR USING BANK DETAILS</p>
                            @endif
                        </div>
                    </div>

                </div>

                <div data-tab-id="tab-3" class="tab-content">
                    <work-times-vue></work-times-vue>
                </div>

                <div data-tab-id="tab-4" class="tab-content">
                    <table class="table table--striped">

                        <tr>
                            <td>Firma und Rechtsform</td>
                            <td><span class="td-data-2">{{(isset($admin->firm->firm_name)) ? $admin->firm->firm_name : ''}}</span>
                                <input class="input-data-2" id="firm_name">
                            </td>
                        </tr>

                        <tr>
                            <td>Vorname & Nachnahme</td>
                            <td><span class="td-data-2">{{(isset($admin->firm->street)) ? $admin->firm->street : ''}}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>PLZ/Ort</td>
                            <td><span class="td-data-2">{{(isset($admin->firm->post_index)) ? $admin->firm->post_index : ''}}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>Strabe/Nr</td>
                            <td><span class="td-data-2">{{(isset($admin->firm->countryInfo->name)) ? $admin->firm->countryInfo->name : ''}}</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div data-tab-id="tab-5" class="tab-content tab-content--level2">
                    <div class="block">

                      <ul class="block__nav">
                        <li
                        @click="showCategoryBtn"
                        data-tab="tab-20" class="block__item is-active">Kategorien</li>
                        <li
                        @click="showServiceBtn"
                        data-tab="tab-21" class="block__item">Produkten</li>
                        <a
                        @click.prevent="openCategoryModal('categoryModal')"
                        v-show="categoryBtn"
                        href="javascript:void(0);"
                        id="leistungenBtn1"
                        class="admin-leistungen__btn btn btn--red f-right">Kategorie hinzufügen</a>
                        <a
                        @click.prevent="openServiceModal('serviceModal')"
                        v-show="serviceBtn"
                        href="javascript:void(0);"
                        id="leistungenBtn2"
                        class="admin-leistungen__btn btn btn--red f-right">Produkt hinzufügen</a>
                      </ul>

                      <div data-tab-id="tab-20" class="tab-content is-active">
                          <table class="table table--striped table--hand table--sortable" id="category-table">
                          <thead>
                          <tr>
                            <th>Nr:</th>
                            <th>Name</th>
                            <th>Status</th>
                          </tr>
                          </thead>
                          <tbody class="sortable">
                            <tr
                            v-for="category in categories"
                            @click.stop="openCategoryModal('categoryModal', category)"
                            data-category-id="@{{ category.id }}"
                            >
                              <td>@{{$index+1}}</td>
                              <td>@{{category.category_name}}</td>
                              <td>@{{category.category_status ? 'Activ' : 'Not Activ'}}</td>
                              <td>
                                <a
                                @click.stop="deleteCategory(category)"
                                href="javascript:void(0);"
                                class="delete-category">
                                    <i class="i">
                                        {!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
                                    </i>
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div data-tab-id="tab-21" class="tab-content">
                        <table class="table table--striped table--hand table--sortable" id="services-table">
                              <thead>
                          <tr>
                            <th>Nr:</th>
                            <th>Name</th>
                            <th>Kategorie</th>
                            <th>Preis</th>
                            <th>Dauer</th>
                            <th>Status</th>
                          </tr>
                              </thead>
                          <tbody class="sortable">
                            <tr
                            v-for="service in services"
                            @click.stop="openServiceModal('serviceModal', service)"
                            data-service-id="@{{service.id}}">
                              <td>@{{ $index+1 }}</td>
                              <td>@{{ service.service_name }}</td>
                              <td>@{{ service.category_name }}</td>
                              <td><span>@{{ service.price }}</span> EUR</td>
                              <td class="service_duration">@{{ service.duration | hourMinutes }}</td>
                              <td>@{{ service.service_status ? 'Activ' : 'Not Activ'}}</td>
                              <td>
                                  <a
                                  @click.stop="deleteService(service)"
                                  href="javascript:void(0);"
                                  class="delete-service">
                                      <i class="i">
                                          {!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
                                      </i>
                                  </a>
                              </td>
                          </tr>
                          </tbody>

                        </table>
                      </div>

                    </div>
                </div>

                <div data-tab-id="tab-6" class="tab-content tab-content--level2">
                    <div class="block">
                        <ul class="block__nav">
                            <li data-tab="1" class="block__item">Personal</li>
                            <li data-tab="2" class="block__item">Categories</li>
                            <li data-tab="3" class="block__item">Services</li>
                            <li data-tab="4" class="block__item">Employees</li>
                            <li data-tab="5" class="block__item">Newsletter</li>
                        </ul>
                        <div data-tab-id="1" class="tab-content is-active">
                            <table class="table table--striped table--avatar">
                                <thead>
                                <tr>
                                    <th>Nr:</th>
                                    <th>Datum</th>
                                    <th>Author</th>
                                    <th>Type</th>
                                    <th>Changes</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1?>
                                @foreach($protocols['personal'] as $p_personal)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$p_personal->created_at}}</td>
                                        @if($p_personal->author == 'admin')
                                            <td>
                                              <img class="table__avatar" src="{{isset($admin->avatar->path) ? $admin->avatar->path : asset('images/default_avatar.png') }}"></td>
                                        @else
		                                    <td>
                                          <img class="table__avatar" src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}">
                                        </td>
                                        @endif
                                        <td>{{trans('protocol.' . $p_personal->type)}}</td>
                                        <td>{{$p_personal->old_value .' -> '. $p_personal->new_value}}</td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div data-tab-id="2" class="tab-content">
                            <table class="table table--striped table--avatar">
                                <thead>
                                <tr>
                                    <th>Nr:</th>
                                    <th>Datum</th>
                                    <th>Author</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Changes</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1?>
                                @foreach($protocols['categories'] as $p_category)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$p_category->created_at}}</td>
	                                    @if($p_category->author == 'admin')
		                                    <td>
                                          <img class="table__avatar" src="{{isset($admin->avatar->path) ? $admin->avatar->path : asset('images/default_avatar.png') }}"></td>
	                                    @else
		                                    <td>
                                          <img class="table__avatar" src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}"></td>
	                                    @endif
                                        <td>{{trans('protocol.' . $p_category->type)}}</td>
                                        <td>{{$p_category->category->category_name}}</td>
                                        <td>{{$p_category->old_value .' -> '. $p_category->new_value}}</td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div data-tab-id="3" class="tab-content">
                            <table class="table table--striped table--avatar">
                                <thead>
                                <tr>
                                    <th>Nr:</th>
                                    <th>Datum</th>
                                    <th>Author</th>
                                    <th>Type</th>
                                    <th>Service</th>
                                    <th>Changes</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1?>
                                @foreach($protocols['services'] as $p_service)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$p_service->created_at}}</td>
	                                        @if($p_service->author == 'admin')
		                                        <td>
                                              <img class="table__avatar" src="{{isset($admin->avatar->path) ? $admin->avatar->path : asset('images/default_avatar.png') }}"></td>
	                                        @else
		                                        <td><img class="table__avatar" src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}"></td>
	                                        @endif
                                            <td>{{trans('protocol.' . $p_service->type)}}</td>
                                            <td>{{$p_service->service->service_name}}</td>
                                            <td>{{$p_service->old_value .' -> '. $p_service->new_value}}</td>
                                        </tr>
                                    <?php $i++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div data-tab-id="4" class="tab-content">
                            <table class="table table--striped table--avatar">
                                <thead>
                                <tr>
                                    <th>Nr:</th>
                                    <th>Datum</th>
                                    <th>Author</th>
                                    <th>Type</th>
                                    <th>Employee</th>
                                    <th>Changes</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1?>
                                @foreach($protocols['employees'] as $p_employee)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$p_employee->created_at}}</td>
	                                    @if($p_employee->author == 'admin')
		                                    <td>
                                          <img class="table__avatar" src="{{isset($admin->avatar->path) ? $admin->avatar->path : asset('images/default_avatar.png') }}"></td>
	                                    @else
		                                    <td>
                                          <img class="table__avatar" src="{{isset($avatar) ? $avatar->path : asset('images/default_avatar.png') }}"></td>
	                                    @endif
                                        <td>{{trans('protocol.' . $p_employee->type)}}</td>
                                        <td>{{$p_employee->employee->name}}</td>
                                        <td>{{$p_employee->old_value .' -> '. $p_employee->new_value}}</td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div data-tab-id="5" class="tab-content">
                            <table class="table table--striped table--avatar">
                                <thead>
                                <tr>
                                    <th>Nr:</th>
                                    <th>Datum</th>
                                    <th>Author</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1?>
                                @foreach($protocols['newsletters'] as $p_newsletter)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$p_newsletter->created_at}}</td>
                                        @if($p_newsletter->author == 'admin')
                                            <td><img class="table__avatar" src="{{isset($admin->avatar->path) ? $admin->avatar->path : asset('images/default_avatar.png') }}"></td>
                                        @else
                                            <td><img class="table__avatar" src="{{isset($p_newsletter->employee->avatar) ? $p_newsletter->employee->avatarEmployee->path : asset('images/default_avatar.png') }}"</td>
                                        @endif
                                        <td>{{trans('protocol.' . $p_newsletter->type)}}</td>
                                        <td>{{$p_newsletter->title}}</td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

    </section>
    </div>

</section>
</template>

<template id="user-info-template">
    <alert
            :show.sync="showLogoSuccess"
            :duration="3000"
            type="success"
            width="400px"
            placement="top-right"
            dismissable
    >
        <span class="icon-ok-circled alert-icon-float-left"></span>
        <strong>Well Done!</strong>
        <p>Logo wurde geändert.</p>
    </alert>
    <alert
            :show.sync="showAvatarSuccess"
            :duration="3000"
            type="success"
            width="400px"
            placement="top-right"
            dismissable
    >
        <span class="icon-ok-circled alert-icon-float-left"></span>
        <strong>Well Done!</strong>
        <p>Avatar wurde geändert.</p>
    </alert>
    <editing-modal-vue></editing-modal-vue>
    <section class="user-info">
            <ul class="user-info__list">

            <div class="user-info__block-img" @click="logoShow = true">
                <div v-show="showImgPreloader" class="user-info__preloader">
                    <i></i>
                </div>
                <div class="crops"></div>

                         <img
                         class="user-info__logo" src="{{isset($admin->logo->firm_logo) ? $admin->logo->firm_logo : asset('images/default_logo.png') }}">

                        <img
                         class="user-info__avatar" src="{{isset($admin->avatar->path) ? $admin->avatar->path : asset('images/default_avatar.png') }}">
                    </div>

                <div>
                    <button
                    v-show="logoShow"
                    @click="logoShow = !logoShow"
                    class="user-info__btn btn btn--red">
                        @{{ logoShow ? 'Do not change' : 'Change' }}
                    </button>
                    <form
                       @submit.prevent="sendLogo"
                       v-show="logoShow"
                       class="logo-block__form" action="" method="post" enctype="multipart/form-data">
                        <button @click.prevent.stop="changeLogo" class="btn btn--green">Change logo</button>
                        <input id="changeLogo" class="logo-block__file logo-block__file--hide" name="firm_logo" type="file" />
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input class="btn btn--gray" type="submit" value="Send File" id="send-logo"/>
                    </form>

                    <form
                    @submit.prevent="sendAvatar"
                     v-show="logoShow"
                     class="logo-block__form" action="" method="post" enctype="multipart/form-data">
                        <button @click.prevent.stop="changeAvatar" class="btn btn--green">Change avatar</button>
                        <input @change.stop.prevent="selectFile($event)" id="changeAvatar" class="logo-block__file logo-block__file--hide" name="avatar" type="file" />
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input class="btn btn--gray" type="submit" value="Send File" id="send-avatar"/>
                    </form>
                </div>

                <li class="user-info__name">
                    <h2 class="user-info__heading">Name & Vorname</h2>
                    <div>
                        <span class="personal-span" id="firstname">{{$admin->firstname}}</span>
                        <input type="text" class="edit-input personal">
                        <span class="personal-span" id="lastname">{{$admin->lastname}}</span>
                        <input type="text" class="edit-input personal">
                    </div>
                </li>

                <li class="user-info__contact">
                    <h2 class="user-info__heading">Kontact</h2>
                    <div class="user-info__phone"><i></i>
                        <span class="personal-span" id="mobile">{{(isset($admin->mobile)) ? $admin->mobile : ''}}</span>
                    </div>
                    <div class="user-info__phone"><i></i>
                        <span class="personal-span" id="mobile">{{(isset($admin->telnumber)) ? $admin->telnumber : ''}}</span>
                    </div>
                    <div class="user-info__email"><i></i>
                        <span class="personal-span" id="email">{{$admin->email}}</span>
                    </div>
                </li>

                <li class="user-info__data">
                    <h2 class="user-info__heading">Persönliche Daten</h2>
                    <div><strong>Geschlecht:</strong>
                        <span class="personal-span" id="gender">{{$admin->gender}}</span>
                    </div>
                    <div><strong>Geburstag:</strong>
                        <span class="personal-span" id="birthday">{{isset($admin->birthday) ? $admin->birthday : ''}}</span>
                    </div>
                    <div><strong>Send Email:</strong>
                        @if($admin->email_send)
                            <span class="personal-span">YES</span>
                        @else
                            <span class="personal-span">NO</span>
                        @endif
                    </div>
                </li>

                <li class="user-info__data">
                    <h2 class="user-info__heading">Tariffe</h2>
                    <div><strong>Tariffe:</strong>
                        <span class="personal-span" id="gender">{{(isset($admin->tariffJournal))? $admin->tariffJournal->name : ''}}</span>
                    </div>
                </li>

                <li class="user-info__data">
                    <h2 class="user-info__heading">Über das UNternehmen</h2>

                    <div><strong>Branche:</strong>
                        <span class="personal-span" id="firmtype">{{(isset($admin->firmTypeInfo)) ? $admin->firmTypeInfo->firmtype : ''}}</span>
                    </div>

                    <div><strong>Mitglied seit:</strong>
                        <span class="personal-span" id="created_at">{{$admin->created_at->format('Y-m-d')}}</span>
                    </div>

                    <div><strong>Status:</strong>
                        <span class="personal-span" id="status">{{$admin->status}}</span>
                    </div>

                    <div class="user-info__address">
                        <strong>Adresse:</strong>
                        <div>
                            <span class="personal-span" id="street">{{(isset($admin->firm->street)) ? $admin->firm->street : ''}}</span>
                            <br>
                            <span class="personal-span" id="city">{{(isset($admin->firm->cityInfo->name)) ? $admin->firm->cityInfo->name : ''}}</span>
                            <br>
                            <span class="personal-span" id="state">{{(isset($admin->firm->stateInfo->name)) ? $admin->firm->stateInfo->name : ''}}</span>
                            <br>
                            <span class="personal-span" id="country">{{(isset($admin->firm->countryInfo->name)) ? $admin->firm->countryInfo->name : ''}}</span>
                        </div>
                    </div>


                    <a @click="openUserInfoModal" href="javascript:void(0);" class="btn btn--red">Edit</a>
                </li>



            </ul>

        </section>
</template>

<template id="editing-modal-template">
    <div class="remodal kalendar-form" id="userInfoModal">
        <button data-remodal-action="close" class="remodal-close"><i></i></button>

        <div class="block">
            <ul class="block__nav">
                <li data-tab="tab-1" class="block__item is-active">Change personal info</li>
                <li data-tab="tab-2" class="block__item">Change password</li>
                <li data-tab="tab-3" class="block__item">Change email</li>
            </ul>

            <div data-tab-id="tab-1" class="tab-content is-active">
                <form
                class="kalendar-form__form" id="infoForm">
                    <fieldset class="kalendar-form__fieldset">
                        <div class="kalendar-form__row">
                            <div>
                                <input
                                    v-model="editingInfo.firstname"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="Name"
                                    name="firstname"
                                    type="text">
                            </div>
                            <div>
                                <input
                                    v-model="editingInfo.lastname"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="Vorname"
                                    name="lastname"
                                    type="text">
                            </div>
                        </div>
                        <div class="kalendar-form__row">
                            <div>
                                <input
                                    v-model="editingInfo.mobile"
                                    class="kalendar-form__input kalendar-input"
                                    placeholder="mobile"
                                    name="mobile"
                                    type="text">
                            </div>
                            <div>
                                <input
                                    v-model="editingInfo.birthday"
                                    class="kalendar-form__input kalendar-input input-date"
                                    name="birthday"
                                    placeholder="birthday"
                                    type="text">
                            </div>
                        </div>
                        <div class="kalendar-form__row">
                            <div>
                                <select
                                v-model="editingInfo.gender"
                                 class="kalendar-form__input kalendar-input" name="gender">
                                    <option
                                    v-for="gender in genders"
                                    value="@{{ gender.value }}">@{{ gender.text }}</option>
                                </select>
                            </div>
                            <div>
                                <select
                                v-model="editingInfo.firmtype_id"
                                class="kalendar-form__input kalendar-input" name="firmtype">
                                    @foreach($firmType as $firm)
                                    <option
                                    value="{{$firm->id}}">{{$firm->firmtype}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="kalendar-form__row">
                            <div>
                                <input
                                        class="kalendar-form__input kalendar-input"
                                        type="text" name="street"
                                        placeholder="street"
                                        v-model="editingInfo.street">
                            </div>
                            <div>
                            <select
                            v-model="editingInfo.city_id"
                            class="kalendar-form__input kalendar-input"
                            placeholder="city"
                            type="text"
                            name="city">
                                <option
                                v-for="city in cities"
                                :value="city.city_id">
                                    @{{ city.name }}
                                </option>
                            </select>
                            </div>
                        </div>

                        <div class="kalendar-form__row">
                            <div>
                            <select
                            @change="getCities"
                            v-model="editingInfo.state_id"
                            class="kalendar-form__input kalendar-input"
                            placeholder="state"
                            type="text"
                            name="state">
                                <option
                                v-for="state in states"
                                :value="state.state_id">
                                    @{{ state.name }}
                                </option>
                            </select>
                            </div>
                            <div>
                            <select
                            @change="getStates"
                            v-model="editingInfo.country_id"
                            class="kalendar-form__input kalendar-input"
                            placeholder="country"
                            type="text"
                            name="country">
                                <option
                                v-for="country in countries"
                                :value="country.country_id">
                                    @{{ country.name }}
                                </option>
                            </select>

                            </div>
                        </div>
                        <div class="kalendar-form__row">
                            <div>
                                <select
                                v-model="editingInfo.status"
                                name="status" class="kalendar-form__input kalendar-input">
                                    <option
                                    v-for="status in statuses"
                                     value="@{{ status.value }}">@{{ status.text }}</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="kalendar-form__fieldset">
                        <input
                        class="kalendar-form__submit btn btn--red" type="submit" value="Edit">
                    </fieldset>
                </form>
            </div>

            <div data-tab-id="tab-2" class="tab-content">
                <form class="kalendar-form__form" id="passwordForm" action="" method="POST">
                    <fieldset class="kalendar-form__fieldset">
                        <div>
                            <input class="kalendar-form__password kalendar-input" type="password" name="old_password" placeholder="Current password">
                        </div>
                        <div>
                            <input
                                class="kalendar-form__password kalendar-input newPass1"
                                type="password" name="new_password-1" placeholder="New password">
                        </div>
                        <div>
                            <input
                                class="kalendar-form__password kalendar-input"
                                type="password" name="new_password-2" placeholder="New password">
                        </div>
                    </fieldset>

                    <div
                            v-show="errors.password"
                            class="vue-error"
                    >Неправильный пароль</div>

                    <fieldset class="kalendar-form__fieldset">
                    <input class="kalendar-form__submit btn btn--red" type="submit" value="Edit">
                    </fieldset>
                </form>
            </div>
            <div data-tab-id="tab-3" class="tab-content">
                <form class="kalendar-form__form" id="emailForm" action="" method="POST">
                    <fieldset class="kalendar-form__fieldset">
                        <div>
                            <input
                                v-model="editingInfo.email"
                                class="kalendar-form__input kalendar-input"
                                placeholder="E-mail"
                                name="email"
                                type="email">
                        </div>
                    </fieldset>

                    <div
                            v-show="errors.email"
                            class="vue-error"
                    >Неправильный email</div>

                    <fieldset class="kalendar-form__fieldset">
                        <input class="kalendar-form__submit btn btn--red" type="submit" value="Edit">
                    </fieldset>
                </form>
            </div>
        </div>


    </div>

    </div>
</template>
@stop