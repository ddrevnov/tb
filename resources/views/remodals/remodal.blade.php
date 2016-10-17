<!--      remodal for edit category-->
<div class="remodal kalendar-form leistungen-form" id="leistungenModal3">
  <button data-remodal-action="close" class="remodal-close"><i></i></button>

  <div class="block">

    <ul class="block__nav">
      <li data-tab="tab-1" class="block__item is-active">{{trans('services.add_category')}}</li>
    </ul>

    <div data-tab-id="tab-1" class="tab-content is-active">
      <form class="kalendar-form__form" id="kategorieForm" action="" method="POST">
        <fieldset class="kalendar-form__fieldset">

          <div class="kalendar-form__row">
            <div>
              <input name="edit_category_name" type="text" class="kalendar-form__input kalendar-input kalendar-form__input--name" placeholder="{{trans('services.ph_category_name')}}" required>
            </div>
            <input type="hidden" name="edit-category-id" value="">
          </div>

          <div class="kalendar-form__row">
            <div>
              <select name="edit_category_status" class="kalendar-form__input kalendar-form__input--service kalendar-input" required>
              <option value="active">Active</option>
              <option value="noactive">No active</option>
            </select>
            </div>
          </div>
          
        </fieldset>
        <fieldset class="kalendar-form__fieldset">
            <input class="kalendar-form__submit btn btn--red" id="edit_category" type="submit" value="{{trans('common.save')}}" data-remodal-action="close">
        </fieldset>
      </form>
    </div>

  </div>

</div>
           
      
<!--      remodal for create category-->
  <div class="remodal kalendar-form leistungen-form" id="leistungenModal1">
  <button data-remodal-action="close" class="remodal-close"><i></i></button>

  <div class="block">

    <ul class="block__nav">
      <li data-tab="tab-1" class="block__item is-active">{{trans('services.add_category')}}</li>
    </ul>

    <div data-tab-id="tab-1" class="tab-content is-active">
      <form class="kalendar-form__form" id="kategorieForm" action="" method="POST">
        <fieldset class="kalendar-form__fieldset">

          <div class="kalendar-form__row">
            <div>
              <input name="create_category_name" type="text" class="kalendar-form__input kalendar-input kalendar-form__input--name" placeholder="{{trans('services.ph_category_name')}}" required>
            </div>
          </div>

          <div class="kalendar-form__row">
            <div>
              <select name="create_category_status" class="kalendar-form__input kalendar-form__input--service kalendar-input" required>
              <option value="active">Active</option>
              <option value="noactive">No active</option>
            </select>
            </div>
          </div>
          
        </fieldset>
        <fieldset class="kalendar-form__fieldset">
            <input class="kalendar-form__submit btn btn--red" id="create_new_category" type="submit" value="{{trans('common.save')}}" data-remodal-action="close">
        </fieldset>
      </form>
    </div>

  </div>

</div>

<!--remodal for edit service-->
      <div class="remodal kalendar-form leistungen-form" id="leistungenModal4">
  <button data-remodal-action="close" class="remodal-close"><i></i></button>

  <div class="block">

    <ul class="block__nav">
      <li data-tab="tab-1" class="block__item is-active">{{trans('services.add_service')}}</li>
    </ul>

    <div data-tab-id="tab-1" class="tab-content is-active">
      <form class="kalendar-form__form" id="productEditForm" action="">
        <fieldset class="kalendar-form__fieldset">

          <div class="kalendar-form__row">
              <div>
                <input type="text" name="edit_service_name" class="kalendar-form__input kalendar-input kalendar-form__input--name" id="service_name" placeholder="{{trans('services.ph_service_name')}}">
              </div>
              <input type="hidden" name="edit_service_id" value="">
          </div>

          <div class="kalendar-form__row">
            <div>
              <select class="kalendar-form__input kalendar-form__input--service kalendar-input category-select" name="edit_service_category" id="category_name">
              @foreach($admin->categories as $category)
              <option value="{{$category->id}}">{{$category->category_name}}</option>
              @endforeach
            </select>
            </div>
          </div>

          <div class="kalendar-form__row">
              <div>
                <input type="text" name="edit_service_price" class="kalendar-form__input kalendar-input" id="price" placeholder="{{trans('common.price')}} EUR">
              </div>
              <div>
                <input type="text" name="edit_service_duration" class="kalendar-form__input kalendar-input" id="duration" placeholder="{{trans('common.duration')}}">
              </div>
          </div>
            
         <div class="kalendar-form__row">
            <div>
              <select name="edit_service_status" class="kalendar-form__input kalendar-form__input--service kalendar-input" required>
              <option value="active">Active</option>
              <option value="noactive">No active</option>
            </select>
            </div>
          </div>

        </fieldset>
        <fieldset class="kalendar-form__fieldset">
            <input class="kalendar-form__submit btn btn--red" id="edit_service" type="submit" value="{{trans('common.save')}}">
        </fieldset>
      </form>
    </div>

  </div>

</div>

<!--remodal for create service-->
      <div class="remodal kalendar-form leistungen-form" id="leistungenModal2">
  <button data-remodal-action="close" class="remodal-close"><i></i></button>

  <div class="block">

    <ul class="block__nav">
      <li data-tab="tab-1" class="block__item is-active">{{trans('services.add_service')}}</li>
    </ul>

    <div data-tab-id="tab-1" class="tab-content is-active">
      <form class="kalendar-form__form" action="">
        <fieldset class="kalendar-form__fieldset">

          <div class="kalendar-form__row">
              <div>
                <input type="text" name="create_service_name" class="kalendar-form__input kalendar-input kalendar-form__input--name" id="service_name" placeholder="{{trans('services.ph_service_name')}}">
              </div>
          </div>

          <div class="kalendar-form__row">
            <div>
              <select class="kalendar-form__input kalendar-form__input--service kalendar-input category-select" name="create_service_category" id="{{trans('services.ph_category_name')}}">
              @foreach($admin->categories as $category)
              <option value="{{$category->id}}">{{$category->category_name}}</option>
              @endforeach
            </select>
            </div>
          </div>

          <div class="kalendar-form__row">
              <div>
                <input type="text" name="create_service_price" class="kalendar-form__input kalendar-input" id="price" placeholder="{{trans('common.price')}} EUR">
              </div>
              <div>
                <input type="text" name="create_service_duration" class="kalendar-form__input kalendar-input" id="duration" placeholder="{{trans('common.duration')}}">
              </div>
          </div>
            
         <div class="kalendar-form__row">
            <div>
              <select name="create_service_status" class="kalendar-form__input kalendar-form__input--service kalendar-input" required>
              <option value="active">Active</option>
              <option value="noactive">No active</option>
            </select>
            </div>
          </div>

        </fieldset>
        <fieldset class="kalendar-form__fieldset">
            <input class="kalendar-form__submit btn btn--red" id="create_new_service" type="submit" value="{{trans('common.save')}}">
        </fieldset>
      </form>
    </div>

  </div>

</div>