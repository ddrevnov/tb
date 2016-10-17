<div id="tab-7" class="tab-content is-active">
    <table class="table table--striped" id="services-table">
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
            <?php $i = 1 ?>
            @foreach ($servicesList as $service)
            <tr data-service-id="{{$service->id}}" class="service">
                <td>{{$i}}</td>
                <td class="service_name">{{$service->service_name}}</td>
                <td class="service_category_name">{{$service->category_name}}</td>
                <td><span class="service_price">{{$service->price}}</span> EUR</td>
                <td class="service_duration">
                    <?php
                    $h = floor($service->duration / 60);
                    $m = $service->duration%60;
                    if($h != 0)
                        printf ("%d h:%02d min", $h, $m);
                    else
                        printf ("%02d min", $m);
                    ?>
                </td>
                <td class="service_status">{{$service->service_status ? 'Activ' : 'Not Activ'}}</td>
                <td>
                    <a href="#" class="delete-service">
                        <i class="i">
                            {!! file_get_contents(asset('images/svg/rubbish-bin.svg')) !!}
                        </i>
                    </a>
                </td>
            </tr>
            <?php $i++ ?>
            @endforeach
        </tbody>
    </table>

    <div class="admin-edit-button" id="open-service-remodal">
        <a href="#" class="btn btn--red">Create new Service</a>
    </div>
</div>