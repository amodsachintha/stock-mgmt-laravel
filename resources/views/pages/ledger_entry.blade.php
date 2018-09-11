@extends('layouts.app')
@section('content')
    <div class="container" style="font-family: sans-serif; color: black">
        @if($entry->in == 0)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-danger" style="-webkit-filter: drop-shadow(1px 2px 2px #c7254e);">
                        <h2>Issuance of Items: <kbd>ID {{$entry->id}}</kbd></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                        <tr>
                            <td>Entry ID:</td>
                            <td>{{$entry->id}}</td>
                        </tr>
                        <tr>
                            <td>Item:</td>
                            <td>{{$entry->item_name}} at Rs. {{ $entry->price}} /= each</td>
                        </tr>
                        <tr>
                            <td>Category:</td>
                            <td>{{$entry->cat}}</td>
                        </tr>
                        <tr style="background-color: #ef8b83">
                            <td>Quantity:</td>
                            <td>-{{$entry->quantity}} {{$entry->uom}}</td>
                        </tr>
                        <tr style="background-color: #ef8b83">
                            <td>Total:</td>
                            <td>Rs. {{$entry->quantity * $entry->price}}</td>
                        </tr>
                        <tr>
                            <td>Person:</td>
                            <td>{{$entry->person}}</td>
                        </tr>
                        @if(isset($entry->purpose))
                            <tr>
                                <td>Purpose:</td>
                                <td>{{$entry->purpose}}</td>
                            </tr>
                        @endif
                        @if(isset($entry->approved_by))
                            <tr>
                                <td>Approved By:</td>
                                <td>{{$entry->approved_by}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>Date:</td>
                            <td>{{date('d M Y H:m A',strtotime($entry->date_time))}}</td>
                        </tr>
                    </table>
                </div>
            </div>

        @else
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-success" style="-webkit-filter: drop-shadow(1px 2px 2px #0d7d1e);">
                        <h2>Item Restock: <kbd>ID {{$entry->id}}</kbd></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
                        <tr>
                            <td>Entry ID:</td>
                            <td>{{$entry->id}}</td>
                        </tr>
                        @if(isset($entry->reciept_no))
                            <tr>
                                <td>Reciept No:</td>
                                <td>{{$entry->reciept_no}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>Item:</td>
                            <td>{{$entry->item_name}} at Rs. {{ $entry->price}} /= each</td>
                        </tr>
                        <tr>
                            <td>Category:</td>
                            <td>{{$entry->cat}}</td>
                        </tr>
                        <tr style="background-color: #7bcb7c">
                            <td>Quantity:</td>
                            <td>+{{$entry->quantity}} {{$entry->uom}}</td>
                        </tr>
                        <tr style="background-color: #7bcb7c">
                            <td>Total:</td>
                            <td>Rs. {{$entry->quantity * $entry->price}}</td>
                        </tr>
                        <tr>
                            <td>Person:</td>
                            <td>{{$entry->person}}</td>
                        </tr>
                        @if(isset($entry->purpose))
                            <tr>
                                <td>Purpose:</td>
                                <td>{{$entry->purpose}}</td>
                            </tr>
                        @endif
                        @if(isset($entry->approved_by))
                            <tr>
                                <td>Approved By:</td>
                                <td>{{$entry->approved_by}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>Date:</td>
                            <td>{{date('d M Y H:m A',strtotime($entry->date_time))}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif
        <div class="row" align="center" style="margin-top: 10px">
            <button onclick="window.close()" class="btn btn-danger hidden-print"><code>X</code> Close</button>
        </div>

    </div>
@endsection