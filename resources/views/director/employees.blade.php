@extends('layouts.layoutDirector')
@section('content')
<section class=" director-main">
    <h1 class="director-content__heading heading heading__h1">Mitarbeiter
        <a class="director-tarife__btn btn btn--plus" href="/backend/employee_create"><i></i>Hinzufügen</a>
    </h1>

    <div class="director-content">

        <table class="table table--striped" id="employee-table">
            <thead>
                <tr>
                    <th>Nr:</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Telefon</th>
                    <th>E-Mail</th>
                    <th>Gruppe</th>
                    <th>Status</th>
                </tr>
            </thead>
            <?php $i=1 + (($employees->currentPage()- 1) * $employees->perPage())?>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{$i}}</td>
                    <td><img src="{{ isset($employee->avatarEmployee) ? $employee->avatarEmployee->path : asset('images/default_avatar.png')  }}" alt="" style="width: 48px;height: 48px"></td>
                    <td><a href="/backend/employee_info/{{ $employee->id }}">{{ $employee->name }}</a></td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->group }}</td>
                    <td>{{ $employee->status }}</td>
                </tr>
                <?php $i++?>
                @endforeach
            </tbody>
        </table>
    </div>
    {!! $employees->render() !!}
</section>
@stop