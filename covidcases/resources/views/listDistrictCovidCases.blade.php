<!DOCTYPE html>
<html>
<head>
    <title>List of Covid Cases in India</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
    
<div class="container">
    <div class="row">
        <a href="{{url('covid/state/list')}}">States</a>
        <h1>District Wise List of Covid Cases in India</h1>
        <table class="table_width table table-bordered district-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>District</th>
                    <th>Confirmed</th>
                    <th>Recovered</th>
                    <th>Deceased</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
   
</body>
   
<script type="text/javascript">
 
  $(function () {

    var state = '{!! $state !!}';
    var district = $('.district-table').DataTable({
        
        serverSide: true,
        processing:true,
        "ajax": "/covid/district/fetchData/"+state,
        
        "columns": [
            { "data": "DT_RowIndex" },
            { "data": "district" },
            { "data": "confirmedCount" },
            { "data": "recoveredCount" },
            { "data": "deceasedCount" }
        ]
    
    });
    
  });
</script>
</html>