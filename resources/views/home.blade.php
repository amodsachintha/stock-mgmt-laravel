@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif">

        <div class="row" align="center" style="margin-bottom: 15px">
            <img src="{{asset('img/logo_text.png')}}" width="500">
            <h3 style="margin-top: -10px">තොග කළමනාකරණ පද්ධතිය</h3>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(isset($items))
                    <div class="panel panel-danger">
                        <div class="panel-heading">Low Quantity Items</div>
                        <div class="panel-body">
                            @foreach($items as $item)
                                <div class="alert alert-danger">
                                    <a href="/item/show/{{$item->id}}" class="alert-link">{{$item->name}}</a> | <kbd>{{$item->quantity}} {{$item->uom}}</kbd>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
