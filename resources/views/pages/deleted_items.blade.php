@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-hover" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    <tr>
                        <th colspan="6" style="text-align: center"><strong><h3>Deleted Items</h3></strong></th>
                    </tr>
                    <tr>
                        <th style="text-align: center">ID</th>
                        <th style="text-align: center">Name</th>
                        <th style="text-align: center">Unit Price(Rs)</th>
                        <th style="text-align: center">Category</th>
                        {{--<th style="text-align: center">quantity</th>--}}
                        <th style="text-align: center">Deleted On</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center">
                    @if(isset($items))
                        @foreach($items as $item)
                                <tr style="color: black">
                                    <td>{{$item->id}}</td>
                                    <td><a href="/item/show/{{$item->id}}">{{$item->name}}</a></td>
                                    <td>{{number_format($item->unit_price,2)}}</td>
                                    <td><span class="label label-info">{{$item->cat}}</span></td>
                                    {{--<td><code>{{$item->quantity}} {{$item->uom}}</code></td>--}}
                                    <td>{{date('d M Y H:m A',strtotime($item->updated_at))}}</td>
                                </tr>
                                @endforeach
                            @endif

                            <tr class="hidden-print">
                                <td colspan="5" align="center">
                                    {{$items->links()}}
                                </td>
                            </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection