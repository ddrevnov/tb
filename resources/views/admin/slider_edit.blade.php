@extends('layouts.layoutAdmin')
@section('content')
<section class="admin-slider director-main">
    <h1 class="director-content__heading heading heading__h1">{{trans('common.slider')}}</h1>

    <div class="director-content">
        <h2 class="admin-slider__heading">{{trans('common.slider_name')}}</h2>

        <div class="block">

            <div class="logo-block">
                <div>
                    <a class="logo-block__btn btn btn--gray" href="#">{{trans('common.choose_file')}}</a>
                </div>

                <form action="/office/slideupload" method="post" enctype="multipart/form-data">
                    <label for="slide_name_input">Slide Name</label><br>
                    <input type="text" name="slide_name" required="" id="slide_name_input" value="{{$slideInfo->slide_name}}"><br>
                    <input name="image" type="file">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"><br>
                    <input type="hidden" name="slide_edit_id" value="{{$slideInfo->id}}">
                    <label for="logoBlockCheckbox">Activ</label>
                    <input type="checkbox" class="checkbox" id="logoBlockCheckbox" name="slide_status" {{$slideInfo->slide_status == 1 ? 'checked' : ''}}>
                    <input type="submit" value="{{trans('common.send')}}"/>
                </form>

                <div class="logo-block__img">
                    <img src="/images/sliders/{{$slideInfo->admin_id . '/' . $slideInfo->image}}" alt="">
                </div>
                <div class="logo-block__edit"></div>
                <div class="logo-block__checkbox">
                </div>
                <a class="logo-block__btn btn btn--red" href="#">{{trans('common.send')}}</a>
            </div>

        </div>

    </div>

</section>
@stop