@extends('layouts.app')

@section('content')
    <div class="container" style="font-family: sans-serif; margin-bottom: 30px">

        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="margin-bottom: 10px" align="center">
                <form class="form-inline" method="GET" action="/items/search">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search...">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" class="form-control">
                            @foreach($cats as $cat)
                                <option value="{{$cat->name}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="margin-bottom: 10px" align="center">
                @if(isset($_GET['category']) && isset($_GET['search']))
                    @if($_GET['search'] != "")
                        <div class="alert alert-success">
                            <p>Showing results for "<strong>{{$_GET['search']}}</strong>" in <strong>{{$_GET['category']}}</strong></p>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <p>Showing results in <strong>{{$_GET['category']}}</strong></p>
                        </div>
                    @endif
                @endif
            </div>
        </div>


        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    <tr>
                        <th style="text-align: center">id</th>
                        <th style="text-align: center">name</th>
                        <th style="text-align: center">unit price RS</th>
                        <th style="text-align: center">category</th>
                        <th style="text-align: center">quantity</th>
                        <th style="text-align: center">Restock</th>
                        <th style="text-align: center">Issue</th>
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
                                    <td><a href="/item/show/{{$item->id}}" style="color: #1c242a;" >{{$item->name}}</a></td>
                                    <td>{{$item->unit_price}}</td>
                                    <td><kbd>{{$item->cat}}</kbd></td>
                                    <td><code>{{$item->quantity}} {{$item->uom}}</code></td>
                                    <td><button class="btn btn-primary" onclick="pop('/item/restock?id={{$item->id}}','{{$item->name}}')">Restock</button></td>
                                    <td><button class="btn btn-danger" onclick="pop('/item/issue?id={{$item->id}}','{{$item->name}}')">Issue</button></td>
                                </tr>
                                @endforeach
                            @endif
                            @if(!isset($_GET['category']))
                                <tr class="hidden-print">
                                    <td colspan="7" align="center">
                                        {{$items->links()}}
                                    </td>
                                </tr>
                            @endif
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