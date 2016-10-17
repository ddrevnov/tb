@extends('layouts.layoutAdmin')
@section('content')

<services-vue></services-vue>

<template id="services-template">
  <section class="admin-leistungen director-main">
  <h1 class="heading heading__h1">{{trans_choice('common.services', 2)}}</h1>

  <div class="director-content">
      
  @include('remodals.services_remodal')

    <div class="block">

      <ul class="block__nav">
        <li 
        @click="showCategoryBtn"
        data-tab="tab-1" class="block__item is-active">{{trans_choice('services.categories', 2)}}</li>
        <li 
        @click="showServiceBtn"
        data-tab="tab-2" class="block__item">{{trans('services.services')}}</li>
        <a
        @click.stop="openCategoryModal('categoryModal')"
        v-show="categoryBtn"
        href="javascript:void(0);" 
        id="leistungenBtn1" 
        class="admin-leistungen__btn btn btn--red f-right">{{trans('services.add_category')}}</a>
        <a 
        @click.stop="openServiceModal('serviceModal')"
        v-show="serviceBtn"

        href="javascript:void(0);" 
        id="leistungenBtn2" 
        class="admin-leistungen__btn btn btn--red f-right">{{trans('services.add_service')}}</a>
      </ul>

      <div data-tab-id="tab-1" class="tab-content is-active">
          <table class="table table--striped table--sortable" id="category-table">
          <thead>    
          <tr>
            <th>{{trans('common.nr')}}</th>
            <th>{{trans('common.name')}}</th>
            <th>{{trans('common.status')}}</th>
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
              <td>@{{ +category.category_status ? 'Active' : 'Not Active' }}</td>
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

      <div data-tab-id="tab-2" class="tab-content">
          <table class="table table--striped table--sortable" id="services-table">
              <thead>
          <tr>
            <th>{{trans('common.nr')}}</th>
            <th>{{trans('common.name')}}</th>
            <th>{{trans_choice('services.categories', 1)}}</th>
            <th>{{trans('common.price')}}</th>
            <th>{{trans('common.duration')}}</th>
            <th>{{trans('common.status')}}</th>
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
              <td>@{{ +service.service_status ? 'Active' : 'Not Active'}}</td>
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

</section>
</template>
  
@stop