@extends('layouts.layoutAdmin')
@section('content')
<section class="admin-slider director-main">
    <h1 class="director-content__heading heading heading__h1">{{trans('common.slider')}}</h1>

    <div class="director-content">
        <h2 class="admin-slider__heading">{{trans('common.slider_name')}}</h2>

        <div class="block sl2">

        <logo-vue></logo-vue>

        <template id="logo-template">
            <div class="logo-block">
                <div class="logo-block__box">
                    <a 
                    @click.prevent.stop="selectFile"
                    class="logo-block__btn btn btn--gray" href="javascript:void(0);">{{trans('common.choose_file')}}</a>

                    <form 
                    class="logo-block__form"
                    id="logoForm"
                     action="/office/slideupload" method="post" enctype="multipart/form-data">
                        <input class="logo-block__input" type="text" name="slide_name" required placeholder="{{trans('common.slider_name')}}">
                        <input
                        @change="readURL($event)" 
                        class="logo-block__file logo-block__file--hide" name="image" type="file" required>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"><br>
                        <div>
                            <label for="logoBlockCheckbox">Activ</label>
                            <input type="checkbox" class="checkbox" id="logoBlockCheckbox" name="slide_status">
                        </div>
                    </form>
                </div>

                <div class="logo-block__slide">
                    <div v-show="showImgPreloader" class="user-info__preloader">`
                        <i></i>
                    </div>
                    <img id="blah" src="/images/content/graficon.jpg" alt="">
                </div>
                <div class="logo-block__checkbox">
                </div>
                <a
                @click.stop.prevent="sendFormSlider"
                class="logo-block__btn btn btn--red" href="javascript:void(0);">{{trans('common.send')}}</a>
            </div>
        </template>

        </div>

    </div>

</section>
@stop