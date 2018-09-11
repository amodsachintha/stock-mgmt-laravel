@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    <tr>
                        <th style="text-align: center">id</th>
                        <th style="text-align: center">name</th>
                        <th style="text-align: center">unit price RS</th>
                        <th style="text-align: center">category</th>
                        <th style="text-align: center">quantity</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center">
                    @if(isset($items))
                        @foreach($items as $item)
                            @if($item->quantity < $item->low)
                                <tr style="background-color: #C0392B; color: white">
                            @elseif($item->quantity < $item->medium)
                                <tr style="background-color: #F1C40F; color:black;">
                            @else
                                <tr style="background-color: #27AE60; color: black">
                                    @endif
                                    <td>{{$item->id}}</td>
                                    <td><a href="#" style="color: #1c242a;" onclick="return pop('/item/show/{{$item->id}}','{{$item->name}}')" >{{$item->name}}</a></td>
                                    <td>{{$item->unit_price}}</td>
                                    <td><kbd>{{$item->cat}}</kbd></td>
                                    <td><code>{{$item->quantity}} {{$item->uom}}</code></td>
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

    <script type="text/javascript">
        function pop(url, name) {
            var newwindow = window.open(url, name, 'height=800,width=700');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }
    </script>
@endsection