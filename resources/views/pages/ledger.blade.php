@extends('layouts.app')

@section('content')

    <div class="container" style="font-family: sans-serif; margin-bottom: 50px">
        @if(isset($months))
            <div class="row" style="margin-bottom: 30px">
                <div class="col-md-2">
                    <form action="/set/year" class="form-inline">
                        <label for="year">Year: </label>
                        <select name="year" id="year" class="form-control" onchange='if(this.value != 0) { this.form.submit(); }'>
                            @for($i = 2016; $i <= intval(date('Y')); $i++)
                                @if($i == intval(session('summary_year')))
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                @else
                                    <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                        </select>
                    </form>
                </div>

                <div class="col-md-10  hidden-print" align="center">
                    <div class="btn-group" role="group">
                        @foreach($months as $m)
                            <a href="/ledger?month={{$loop->iteration}}&year={{session('summary_year')}}" type="button" class="btn btn-primary">{{$m}}</a>
                        @endforeach
                            <a href="/view/all?year={{session('summary_year')}}" type="button" class="btn btn-danger">{{session('summary_year')}}</a>
                    </div>
                </div>
            </div>
            <hr>
        @endif
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <table class="table dataTable" id="ledger" style="-webkit-filter: drop-shadow(1px 2px 2px gray); margin: 2px; background-color: #fffffe">
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
                                <tr>
                                    <td>{{$line->id}}</td>
                                    <td><a href="/item/show/{{$line->id_item}}">{{$line->item_name}}</a></td>
                                    <td><kbd>{{$line->cat_name}}</kbd></td>
                                    @if($line->in == true)
                                        <td class="bg-success">+ {{$line->quantity}} {{$line->uom}}</td>
                                    @else
                                        <td class="bg-danger">- {{$line->quantity}} {{$line->uom}}</td>
                                    @endif
                                    <td>{{$line->person}}</td>
                                    <td>{{date('d M Y',strtotime($line->date_time))}}</td>
                                    <td><button class="btn btn-default" onclick="pop('/ledger/view?id={{$line->id}}','{{$line->id}}')">View</button></td>
                                </tr>
                                @endforeach
                            @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
            <table class="table">
                @if(isset($totals))
                    <tr>
                        <td  style="text-align: right"><h4>Issuance cost</h4></td>
                        <td  style="color: #c7254e"><h4>Rs {{$totals['issue_total']}}</h4></td>
                    </tr>
                    <tr>
                        <td  style="text-align: right"><h4>Purchase cost</h4></td>
                        <td  style="color: #559756"><h4>Rs {{$totals['restock_total']}}</h4></td>
                    </tr>
                @endif
            </table>
        </div>

    </div>
    <script type="text/javascript">

        $(document).ready(function () {
            var table = $('#ledger').DataTable({
                responsive: true,
                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                "lengthMenu": [[20, 50, 75, -1], [20, 50, 75, "All"]],
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fal fa-clone"></i>',
                        titleAttr: 'Copy'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fal fa-file-excel"></i>',
                        titleAttr: 'Excel'
                    }
                ]
            });
            table.buttons().container()
                .appendTo('#ledger_wrapper .col-md-6:eq(0)');
        });


        function pop(url, name) {
            var newwindow = window.open(url, name, 'height=700,width=700');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }
    </script>

@endsection