<!--      remodal for create and edit category-->
<div class="remodal kalendar-form leistungen-form" id="categoryModal">
  <button data-remodal-action="close" class="remodal-close"><i></i></button>

  <div class="block">

    <ul class="block__nav">
      <li data-tab="tab-1" class="block__item is-active">{{trans('services.add_category')}}</li>
    </ul>

    <div data-tab-id="tab-1" class="tab-content is-active">
      <form
      @submit.prevent="sendCategoryForm($event)" 
      class="kalendar-form__form" id="kategorieForm" action="" method="POST">
        <fieldset class="kalendar-form__fieldset">

          <div class="kalendar-form__row">
              <input
              name="category_name" type="text"
              v-model="editCategory.category_name"
              class="kalendar-form__input kalendar-input kalendar-form__input--name" 
              placeholder="{{trans('services.ph_category_name')}}"
              required>
          </div>

          <div class="kalendar-form__row">
              <select
              v-model="editCategory.category_status" 
              name="category_status" class="kalendar-form__input kalendar-form__input--service kalendar-input" required>
                <option
                value="1">Active</option>
                <option
                value="0">No active</option>
            </select>
          </div>
          
        </fieldset>
        <fieldset class="kalendar-form__fieldset">
            <input class="kalendar-form__submit btn btn--red" id="create_new_category" type="submit" value="{{trans('common.create')}}">
        </fieldset>
      </form>
    </div>

  </div>

</div>

<!--remodal for create and edit service-->
<div class="remodal kalendar-form leistungen-form" id="serviceModal">
  <button data-remodal-action="close" class="remodal-close"><i></i></button>

  <div class="block">

    <ul class="block__nav">
      <li data-tab="tab-1" class="block__item is-active">{{trans('services.add_service')}}</li>
    </ul>

    <div data-tab-id="tab-1" class="tab-content is-active">
      <form
      @submit.prevent="sendServiceForm($event)"
      id="sendServiceForm"  
      class="kalendar-form__form" action="">
        <fieldset class="kalendar-form__fieldset">

          <div class="kalendar-form__row">
              <div>
                <input 
                v-model="editService.service_name"
                type="text" name="service_name"
                class="kalendar-form__input kalendar-input"
                id="service_name"
                placeholder="{{trans('services.ph_service_name')}}">
              </div>
              <div>
                <select 
                v-model="editService.category_id"
                class="kalendar-form__input kalendar-input category-select" name="category_id" id="category_name">
                  <option
                  v-for="category in categories"
                  :value="category.id">
                    @{{ category.category_name }}
                  </option>
                </select>
              </div>
          </div>

          <div class="kalendar-form__row">
              <div>
                <input
                v-model="editService.price"
                type="text" name="price" 
                class="kalendar-form__input kalendar-input" 
                id="price" 
                placeholder="{{trans('common.price')}}">
              </div>
              <div>
                <input 
                v-model="editService.duration"
                type="text" name="duration"
                class="worktime-timepicker kalendar-form__input kalendar-input"
                id="duration"
                readonly
                placeholder="{{trans('common.duration')}}">
              </div>
          </div>
            
         <div class="kalendar-form__row">
            <select 
            v-model="editService.service_status"
            name="service_status" class="kalendar-form__input kalendar-form__input--service kalendar-input" required>
              <option value="1">Active</option>
              <option value="0">No active</option>
            </select>
          </div>

          <div class="kalendar-form__row">
            <p class="is-danger" v-show="showServiceDanger">{{trans('services.tariff_warning')}}</p>
          </div>

        </fieldset>
        <fieldset class="kalendar-form__fieldset">
            <input class="kalendar-form__submit btn btn--red" id="create_new_service" type="submit" value="{{trans('common.create')}}">
        </fieldset>
      </form>
    </div>

  </div>

</div>