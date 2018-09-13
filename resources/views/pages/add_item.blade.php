@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-info" align="center">
                    <h3>Add new Item</h3>
                </div>
            </div>
        </div>
        @if(isset($error))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-danger" align="center">
                        <p>{{$error}}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="/item/add" method="POST">
                    <div class="form-group">
                        <label>Item name</label>
                        <input class="form-control" type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="id_category" class="form-control" required>
                            @foreach($cats as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Unit of Measure (UOM)</label>
                        <input type="text" name="uom" class="form-control" list="uoms" required>
                        <datalist id="uoms">
                            @foreach($uoms as $uom)
                                <option>{{$uom->name}}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="form-group">
                        <label>Unit Price</label>
                        <input class="form-control" type="text" name="unit_price" required>
                    </div>

                    <div class="form-group">
                        <label>Low level</label>
                        <input class="form-control" type="number" name="low" min="1" value="10" required>
                    </div>

                    <div class="form-group">
                        <label>Medium level</label>
                        <input class="form-control" type="number" name="medium" min="1" value="30" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input class="form-control" type="text" name="description">
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