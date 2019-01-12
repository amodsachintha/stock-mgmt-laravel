@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="text-align: center">Category name</th>
                        <th style="text-align: center">No. of items</th>
                        <th style="text-align: center">Total Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($counts as $count)
                        <tr>
                            <td style="text-align: center"><a href="/items/search?search=&category={{$count['cat']}}" class="btn btn-primary btn-sm btn-block">{{$count['cat']}}</a></td>
                            <td style="text-align: center"><span class="label label-info">{{$count['count']}}</span></td>
                            @foreach($totals as $total)
                                @if($count['cat_id'] == $total['cat_id'])
                                    <td style="text-align: center">Rs. {{number_format(doubleval($total['total']),2)}}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row" style="margin-top: 30px">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <div class="panel-title">Add new Category</div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Category</label>
                            <input class="form-control" type="text" id="category" placeholder="new category..." required>
                        </div>
                        <button class="btn btn-primary" onclick="if(confirm('Are you sure?')) addNewCategory()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function addNewCategory() {
            var cat = document.getElementById('category').value;
            if (cat === '' || cat === null) {
                alert('Category name cannot be empty!');
            }
            else {
                var ajax = new XMLHttpRequest();
                ajax.open('POST', '/categories/add', true);
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.onload = function (ev) {
                    var list = JSON.parse(ajax.responseText);
                    if (list['status'] === 'ok') {
                        alert('New Category ' + cat + ' added successfully!');
                        window.location.reload(true);
                    }
                    else {
                        alert('Category ' + cat + ' already exists!');
                    }

                };
                ajax.send('cat=' + cat + '&_token={{csrf_token()}}');
            }
        }
    </script>

@stop