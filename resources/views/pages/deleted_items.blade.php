@extends('layouts.app')
@section('content')
    <div class="container" style="font-family: sans-serif">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-hover" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    <tr>
                        <th colspan="6" style="text-align: center"><strong><h3>Deleted Items</h3></strong></th>
                    </tr>
                    <tr>
                        <th style="text-align: center">id</th>
                        <th style="text-align: center">name</th>
                        <th style="text-align: center">unit price RS</th>
                        <th style="text-align: center">category</th>
                        <th style="text-align: center">quantity</th>
                        <th style="text-align: center">deleted on</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center">
                    @if(isset($items))
                        @foreach($items as $item)
                                <tr style="color: black">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->unit_price}}</td>
                                    <td><kbd>{{$item->cat}}</kbd></td>
                                    <td><code>{{$item->quantity}} {{$item->uom}}</code></td>
                                    <td>{{date('d M Y H:m A',strtotime($item->updated_at))}}</td>
                                </tr>
                                @endforeach
                            @endif

                            <tr class="hidden-print">
                                <td colspan="6" align="center">
                                    {{$items->links()}}
                                </td>
                            </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection