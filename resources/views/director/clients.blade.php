@extends('layouts.layoutDirector')
@section('content')
<section class="director-kunden director-main">
    <h1 class="director-content__heading heading heading__h1">Kunden</h1>

    <div class="director-content">

        <table class="table table--striped" id="clients-table">
            <thead>
                <tr><th>Nr:</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Telefon</th>
                    <th>E-Mail</th>
                    <th>Geburstag</th>
                    <th>Kunde seit</th>
                </tr>
            </thead>
            <?php $i = 1 + (($clients_list->currentPage() - 1) * $clients_list->perPage())?>
            <tbody>
                @foreach($clients_list as $client)
                    <tr onclick="document.location = '{{ route ('d_client_info', $client->id)}}'" style="cursor: pointer">
                    <td>{{$i}}</td>
                    <td>{{$client->first_name}}</td>
                    <td>{{$client->last_name}}</td>
                    <td>{{$client->telephone}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->birthday}}</td>
                    <td>{{$client->created_at}}</td>
                </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>
        </table>

    </div>
    {!! $clients_list->render() !!}
</section>
@stop