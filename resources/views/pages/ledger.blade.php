@extends('layouts.app')

@section('content')

    <div class="container" style="font-family: sans-serif">
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
            <div class="col-md-8 col-md-offset-2">
                <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                    <thead>
                    @if(!isset($paginate))
                        <tr>
                            <td colspan="6" style="text-align: center"><h4>{{strtoupper($month)}}</h4></td>
                        </tr>
                    @endif
                    <tr>
                        <th style="text-align: center">id</th>
                        <th style="text-align: center">item</th>
                        <th style="text-align: center">category</th>
                        <th style="text-align: center">quantity</th>
                        <th style="text-align: center">person</th>
                        <th style="text-align: center">date</th>
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
                            @endif
                            @if(isset($totals))
                                <tr>
                                    <td colspan="5" style="text-align: right">Issue cost</td>
                                    <td colspan="1">Rs {{$totals['issue_total']}}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align: right">restock cost</td>
                                    <td colspan="1">Rs {{$totals['restock_total']}}</td>
                                </tr>
                            @endif
                            @if(isset($paginate))
                                <tr>
                                    <td colspan="6" align="center">{{$data->links()}}</td>
                                </tr>
                            @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection