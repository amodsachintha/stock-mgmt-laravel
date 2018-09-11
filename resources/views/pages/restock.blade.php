@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-success">
                    <h3>Restock -> {{$item->name}}</h3>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="/item/restock" method="POST">

                    <div class="form-group">
                        <label>Item ID</label>
                        <input class="form-control" type="text" id="id" name="id" value="{{$item->id}}" disabled>
                        <input type="hidden" name="id_item" value="{{$item->id}}">
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{$item->name}}" disabled>
                        <input type="hidden" name="item_name" value="{{$item->name}}">
                    </div>

                    <input type="hidden" name="id_category" value="{{$item->id_category}}">

                    <div class="form-group">
                        <label>Unit Price (Rs.)</label>
                        <input class="form-control" type="text" value="{{$item->unit_price}}" disabled>
                        <input type="hidden" name="full_quantity" value="{{$item->quantity}}">
                    </div>

                    <div class="form-group">
                        <label>Reciept No.</label>
                        <input class="form-control" type="text" name="reciept_no">
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input class="form-control" type="number" name="quantity" min="1" value="1" required>
                    </div>

                    <div class="form-group">
                        <label>Person</label>
                        <input class="form-control" type="text" name="person" required>
                    </div>

                    <div class="form-group">
                        <label>Approved By</label>
                        <input class="form-control" type="text" name="approved_by">
                    </div>

                    {{csrf_field()}}
                    <div class="form-group" align="center">
                        <input type="submit" class="btn btn-success" value="Submit" style="width: 200px">
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection