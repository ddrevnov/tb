@extends('layouts.layoutAdmin')
@section('content')
<section class="admin-settings director-main">
    <h1 class="director-content__heading heading heading__h1">{{trans('common.slider')}}
        <a class="director-tarife__btn btn btn--plus" href="/office/slider2"><i></i>{{trans('common.add')}}</a>
    </h1>

    <div class="director-content">

        <div class="block">

            <table class="table table--striped">

                <tr>
                    <th>{{trans('common.nr')}}:</th>
                    <th>{{trans('common.name')}}</th>
                    <th>{{trans('common.status')}}</th>
                    <th></th>
                </tr>
                <?php $i = 1?>
                @foreach($slidersList as $slide)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$slide->slide_name}}</td>                        
                    <td>{{{($slide->slide_status == 1) ? 'Activ' : 'Not Activ'}}}</td>
                    <td data-slide-id="{{$slide->id}}">

                        <a href="/office/slideedit?id={{$slide->id}}" class="edit-slide">
                            <i class="i">
                                {!! file_get_contents(asset('images/svg/pencil.svg')) !!}
                            </i>
                        </a>

                        <a href="/office/slideremove?id={{$slide->id}}" class="delete-slide">
                            <i class="i">
                                {!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
                            </i>
                        </a>

                    </td>
                </tr>
                    <?php $i++?>
                @endforeach

            </table>

        </div>

    </div>

</section>
@stop
