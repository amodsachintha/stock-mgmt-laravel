@extends('layouts.app')
@section('content')
    <div class="container" style="font-family: sans-serif">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(isset($item))
                    @if($item->quantity < $item->low)
                        <div class="alert alert-danger" align="center" style="-webkit-filter: drop-shadow(1px 2px 2px #a70e00);">
                            @elseif($item->quantity < $item->medium)
                                <div class="alert alert-warning" align="center" style="-webkit-filter: drop-shadow(1px 2px 2px #bc8700);">
                                    @else
                                        <div class="alert alert-success" align="center" style="-webkit-filter: drop-shadow(1px 2px 2px #096c15);">
                                            @endif
                                            <h4>{{$item->name}}</h4>
                                            <h4>{{$item->quantity}} {{$item->uom}}</h4>
                                        </div>


                                        <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                                            <tr>
                                                <td>ID:</td>
                                                <td colspan="2"><strong>{{$item->id}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Name:</td>
                                                <td colspan="2"><strong>{{$item->name}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Unit Price:</td>
                                                <td colspan="2"><strong>Rs. {{$item->unit_price}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Quantity:</td>
                                                <td colspan="2"><strong>{{$item->quantity}} {{$item->uom}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Category:</td>
                                                <td colspan="2"><strong>{{$item->cat}}</strong></td>
                                            </tr>
                                            @if(isset($item->description))
                                                <tr>
                                                    <td>Description:</td>
                                                    <td colspan="2"><strong>{{$item->description}}</strong></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Low threshold value:</td>
                                                <td colspan="2">
                                                    <div class="input-group" style="width: 30%">
                                                        <input type="number" value="{{$item->low}}" id="low_t" class="form-control" aria-describedby="basic-addon2">
                                                        <span class="input-group-addon" id="basic-addon2">{{$item->uom}}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Medium threshold value:</td>
                                                <td colspan="2">
                                                    <div class="input-group" style="width: 30%">
                                                        <input type="number" value="{{$item->medium}}" id="med_t" class="form-control" aria-describedby="basic-addon3">
                                                        <span class="input-group-addon" id="basic-addon3">{{$item->uom}}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr align="center">
                                                <td align="right">
                                                    <button class="btn btn-primary" onclick="if(confirm('Are you sure?')) updateItem();">Update</button>
                                                </td>
                                                <td align="center">
                                                    <button class="btn btn-success">Restock</button>
                                                </td>
                                                <td align="left">
                                                    <button class="btn btn-danger" onclick="if(confirm('Are you sure?')) deleteItem();">Delete</button>
                                                </td>
                                            </tr>
                                        </table>
                                    @endif
                                </div>
                        </div>
                        <div class="row" style="margin-top: 20px">
                            <div class="col-md-8 col-md-offset-2">
                                @if(isset($ledgerRecs))
                                    <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                                        <thead>
                                        <tr>
                                            <th colspan="5" style="text-align:center">Ledger Records for {{$item->name}}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center">ledger id</th>
                                            <th style="text-align: center">category</th>
                                            <th style="text-align: center">quantity</th>
                                            <th style="text-align: center">person</th>
                                            <th style="text-align: center">date</th>
                                        </tr>
                                        </thead>
                                        <tbody style="text-align: center">
                                        @foreach($ledgerRecs as $line)
                                            @if($line->in == true)
                                                <tr class="bg-success">
                                            @else
                                                <tr class="bg-danger">
                                                    @endif
                                                    <td><a href="#" onclick="pop('/ledger/view?id={{$line->id}}','{{$line->id}}')">{{$line->id}}</a></td>
                                                    <td>{{$line->cat_name}}</td>
                                                    @if($line->in == true)
                                                        <td>+ {{$line->quantity}} {{$line->uom}}</td>
                                                    @else
                                                        <td>- {{$line->quantity}} {{$line->uom}}</td>
                                                    @endif
                                                    <td>{{$line->person}}</td>
                                                    <td>{{date('d M Y',strtotime($line->date_time))}}</td>
                                                </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
            </div>
            <div class="hidden-print" align="center" style="margin-top: 15px">
                @if(isset($_SERVER['HTTP_REFERER']))
                    <a href="{{$_SERVER['HTTP_REFERER']}}" class="btn btn-default">Back</a>
                @endif
            </div>
        </div>
        <script type="text/javascript">
            function updateItem() {
                var low = document.getElementById('low_t').value;
                var medium = document.getElementById('med_t').value;
                var item_id = '{{$item->id}}';

                var ajax = new XMLHttpRequest();
                ajax.open('POST', '/item/update', true);
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.onload = function (ev) {
                    var list = JSON.parse(ajax.responseText);
                    console.log(list);
                    if (list['status'] === 'ok') {
                        alert('Item updated successfully!');
                        window.location.reload(true);
                    }
                    else {
                        alert('Update Failed!');
                    }

                };
                ajax.send('low=' + low + '&med=' + medium + '&item_id=' + item_id + '&_token={{csrf_token()}}');
            }

            function deleteItem() {
                var item_id = '{{$item->id}}';

                var ajax = new XMLHttpRequest();
                ajax.open('POST', '/item/delete', true);
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.onload = function (ev) {
                    var list = JSON.parse(ajax.responseText);
                    console.log(list);
                    if (list['status'] === 'ok') {
                        alert('Item Deleted successfully!');
                        window.close();
                    }
                    else {
                        alert('Delete Failed!');
                    }

                };
                ajax.send('item_id=' + item_id + '&_token={{csrf_token()}}');
            }

            function pop(url, name) {
                var newwindow = window.open(url, name, 'height=800,width=700');
                if (window.focus) {
                    newwindow.focus()
                }
                return false;
            }
        </script>

@endsection