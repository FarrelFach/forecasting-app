@extends('layouts.template')
@section('title', 'Data Penjualan')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-2">
                    <a href="{{ route('upload-pjl') }}" class="btn btn-primary">Go to Upload Page</a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>wo</th>
                        <th>invoice</th>
                        <th>Date Oredered</th>
                        <th>client</th>
                        <th>description</th>
                        <th>quantity</th>
                        <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($penjualan as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->wo}}</td>
                        <td>{{$data->invoice}}</td>
                        <td>{{$data->order_date}}</td>
                        <td>{{$data->client}}</td>
                        <td>{{$data->description}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>
                          <a href="{{ route('penjualan.edit', $data->id) }}" class="btn btn-primary mr-1">Edit</a>
                          <form action="{{ route('barang.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
</div>
@endsection
@section('script')
<!-- DataTables  & Plugins -->
<script src="{{asset('AdminLTE')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": [
        {
          extend: 'excelHtml5',
          text: 'Export Excel (Header Only)',
          exportOptions: {
            columns: ':visible',
            modifier: {
              search: 'none',
              order: 'none'
            },
            rows: function (idx, data, node) {
              return false;  // Exclude all data rows, include only header
            },
            title: '',  // Empty title removes unwanted text from the first row
          }
        }
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection