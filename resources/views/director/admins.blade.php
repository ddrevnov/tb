@extends('layouts.layoutDirector')
@section('content')
    @include('remodals.profil_admin_remodal')
    <section class="director-main">
        <h1 class="director-content__heading heading heading__h1">Dienstleister
            <a class="director-tarife__btn btn btn--plus" href="/backend/admin_create"><i></i>Hinzufügen</a>
        </h1>
        <div class="director-content">
            <div class="block">
                <ul class="block__nav">
                    <li data-tab="tab-1" class="block__item is-active">Dienstleister</li>
                    <li data-tab="tab-2" class="block__item">Dienstleister NEW</li>
                </ul>

                <div data-tab-id="tab-1" class="tab-content is-active">
                    <table class="table table--striped" id="admins-table">
                        <thead>
                        <tr>
                            <th>Nr:</th>
                            <th>Name</th>
                            <th>Vorname</th>
                            <th>E-Mail</th>
                            <th>Kunde seit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1 + (($admins->currentPage() - 1) * $admins->perPage())?>
                        @foreach($admins as $admin)
                            <tr onclick="document.location = '{{ route ('admin_info', $admin->id)}}'">
                                <td>{{$i}}</td>
                                <td>{{$admin->firstname}}</td>
                                <td>{{$admin->lastname}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->created_at->format('d-m-Y')}}</td>
                            </tr>
                            <?php $i++?>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $admins->render() !!}
                </div>

                <div data-tab-id="tab-2" class="tab-content">
                    <table class="table table--striped" id="admins-table2">
                        <thead>
                        <tr>
                            <th>Nr:</th>
                            <th>Name</th>
                            <th>Vorname</th>
                            <th>Telefon</th>
                            <th>E-Mail</th>
                            <th>Kunde seit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1?>
                        @foreach($admins_new as $admin)
                            <tr onclick="document.location = '{{ route ('admin_info_new', $admin->id)}}'">
                                <td>{{$i}}</td>
                                <td>{{$admin->firstname}}</td>
                                <td>{{$admin->lastname}}</td>
                                <td>{{$admin->mobile}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->created_at->format('d-m-Y')}}</td>
                            </tr>
                            <?php $i++?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop