@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif">

        <div class="row" align="center" style="margin-bottom: 15px">
            <img src="{{asset('img/logo_text.png')}}" width="500">
            <h3 style="margin-top: -10px">තොග කළමනාකරණ පද්ධතිය</h3>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(!is_null($data))
                    @if($data['count'] == 0)
                    <div class="panel panel-success">
                        @else
                            <div class="panel panel-danger">
                        @endif
                        <div class="panel-heading"><i class="fab fa-dropbox"></i> Low Quantity Items</div>
                        <div class="panel-body">
                            @foreach($data['items'] as $item)
                                <div class="alert alert-danger">
                                    <a href="/item/show/{{$item->id}}" class="alert-link">{{$item->name}}</a> | <kbd>{{$item->quantity}} {{$item->uom}}</kbd>
                                </div>
                            @endforeach

                            @if($data['count'] == 0)
                                <div class="alert alert-success">
                                    <h5>No stock critical items in inventory!</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
