@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row" style="font-family: sans-serif">
            <div class="col-md-6 col-md-offset-3">
                <table class="table table-hover" style="-webkit-filter: drop-shadow(1px 2px 2px gray); background-color: #fffffe">
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
                            <td style="text-align: center"><a href="/items/search?search=&category={{$count['cat']}}">{{$count['cat']}}</a></td>
                            <td style="text-align: center">{{$count['count']}}</td>
                            @foreach($totals as $total)
                                @if($count['cat_id'] == $total['cat_id'])
                                    <td style="text-align: center">Rs. {{number_format(doubleval($total['total']),2)}}</td>
                                @endif
                            @endforeach
                            @el

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row" style="margin-top: 30px">
            <div class="col-md-4 col-md-offset-4" align="center">
                <div class="form-group">
                    <label>Add New Category</label>
                    <input class="form-control" type="text" id="category" placeholder="new category..." required>
                </div>
                <button class="btn btn-primary" onclick="if(confirm('Are you sure?')) addNewCategory()">Submit</button>
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