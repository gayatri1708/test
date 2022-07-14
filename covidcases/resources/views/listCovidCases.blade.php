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
        <h1>State Wise List of Covid Cases in India</h1>
        <div class="col-lg-12">
            <div class="table-responsive"> 
                <table class="table_width table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>State</th>
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
    </div>
</div>
   
</body>
   
<script type="text/javascript">
 
  $(function () {
    
    var table = $('.data-table').DataTable({
        
        serverSide: true,
        processing:true,
        responsive :true,
        "ajax": '/covid/state/fetchData',
        
        "columns": [
            { "data": "DT_RowIndex" },
            { 
                "data": "states",
                "render": function(data, type, row, meta){
                    var stateParam = encodeURIComponent(data); 
                    var url = "{{url('covid/district/list')}}"+'/'+stateParam;
                    console.log(url);
                    return '<a href= '+url+'>' + data + '</a>';
                    return data;
                }
            }, 
            { "data": "confirmedCount" },
            { "data": "recoveredCount" },
            { "data": "deceasedCount" }
        ]
    
    });
    
  });
</script>
</html>