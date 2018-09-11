@extends('layouts.app')
@section('content')
    @if(isset($counts))
        <script src="{{asset('js/Chart.min.js')}}"></script>
        <div class="row">
            <div class="col-md-8 col-md-offset-2" align="center">
                <div id="canvas-holder" style="width: 80%">
                    <canvas id="chart-area"></canvas>
                </div>

            </div>
        </div>

        <script>
            var config = {
                type: 'bar',
                data: {
                    datasets: [{
                        data: [
                            @foreach($counts as $count)
                            {{intval($count['count'])}},
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($counts as $count)
                                '#' + (Math.random() * 0xFFFFFF << 0).toString(16),
                            @endforeach
                        ],
                        label: 'Categories'
                    }],
                    labels: [
                        @foreach($counts as $count)
                            '{{strval($count['category'])}}',
                        @endforeach
                    ]
                },
                options: {
                    responsive: true
                }
            };

            window.onload = function () {
                var ctx = document.getElementById('chart-area').getContext('2d');
                window.myPie = new Chart(ctx, config);
            };
        </script>
    @endif

    <div class="row" style="margin-top: 30px">
        <div class="col-md-4 col-md-offset-4" align="center">
            <div class="form-group">
                <label>Add New Category</label>
                <input class="form-control" type="text" id="category" placeholder="new category..." required>
            </div>
            <button class="btn btn-primary" onclick="if(confirm('Are you sure?')) addNewCategory()">Submit</button>
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