{{--               
@extends('layouts.app')
@section('head')
<title>sessions</title>
@endsection
@section('content')
--}}
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Group Room Maffia</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <h1>Sessions</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal" title="Add Category">Add</button>
                <div class="table">
                <table class="table table-bordered table-striped table-hover table-fixed">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Limit </th>
                            <th> Sort number </th>
                            <th> Parent Category </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($sessions))
                        <p>There are no sessions</p>
                        @else
                        @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->MdhUsername }}</td>
                            <td>{{ $session->JSESSIONID }}</td>
                            <td>{{ $session->sortnumber }}</td>
                            <td><a href="{{ action('KronoxSessionController@delete', $session->id) }}">
                            <button type="button" class="btn btn-info btn-sm" title="Up">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"/>
                            </button></a></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $sessions->render() !!} </div>
                </div>
            </div>
        </div>
    </body>
</html>
