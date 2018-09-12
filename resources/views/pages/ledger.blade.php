@extends('layouts.app')

@section('content')

    <div class="container" style="font-family: sans-serif; margin-bottom: 50px">
        @if(isset($months))
            <div class="row" style="margin-bottom: 20px">
                <div class="col-md-10 col-md-offset-1" align="center">
                    <div class="btn-group" role="group">
                        @foreach($months as $m)
                            <a href="/ledger?month={{$loop->iteration}}" type="button" class="btn btn-primary">{{$m}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    @if(!isset($paginate))
                        <tr>
                            <td colspan="7" style="text-align: center"><h4>{{strtoupper($month)}}</h4></td>
                        </tr>
                    @endif
                    <tr>
                        <th style="text-align: center">id</th>
                        <th style="text-align: center">item</th>
                        <th style="text-align: center">category</th>
                        <th style="text-align: center">quantity</th>
                        <th style="text-align: center">person</th>
                        <th style="text-align: center">date</th>
                        <th style="text-align: center"> </th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center">
                    @if(isset($data))
                        @foreach($data as $line)
                            @if($line->in == true)
                                <tr class="bg-success">
                            @else
                                <tr class="bg-danger">
                                    @endif
                                    <td>{{$line->id}}</td>
                                    <td><a href="/item/show/{{$line->id_item}}">{{$line->item_name}}</a></td>
                                    <td><kbd>{{$line->cat_name}}</kbd></td>
                                    @if($line->in == true)
                                        <td>+ {{$line->quantity}} {{$line->uom}}</td>
                                    @else
                                        <td>- {{$line->quantity}} {{$line->uom}}</td>
                                    @endif
                                    <td>{{$line->person}}</td>
                                    <td>{{date('d M Y',strtotime($line->date_time))}}</td>
                                    <td><button class="btn btn-default" onclick="pop('/ledger/view?id={{$line->id}}','{{$line->id}}')">View</button></td>
                                </tr>
                                @endforeach
                            @endif
                            @if(isset($totals))
                                <tr>
                                    <td colspan="6" style="text-align: right"><h4>Issuance cost</h4></td>
                                    <td colspan="1" style="color: #c7254e"><h4>Rs {{$totals['issue_total']}}</h4></td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: right"><h4>Restock cost</h4></td>
                                    <td colspan="1" style="color: #559756"><h4>Rs {{$totals['restock_total']}}</h4></td>
                                </tr>
                            @endif
                            @if(isset($paginate))
                                <tr>
                                    <td colspan="7" align="center">{{$data->links()}}</td>
                                </tr>
                            @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function pop(url, name) {
            var newwindow = window.open(url, name, 'height=700,width=700');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }
    </script>

@endsection