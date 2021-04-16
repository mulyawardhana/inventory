@extends('layouts.master')

@section('content')
<title>Data Supplier | MWD</title>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Jenis</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
    	 	@if( Session::get('pesan') !="")
            <div class='alert alert-success'><center><b>{{Session::get('pesan')}}</b></center></div>        
            @endif
            @if(count($errors) > 0)
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
             <a class="btn btn-success" href="javascript:void(0)" id="createNewItem"><i class="fa fa-plus"></i> Add</a>
            <br>
            <br>
            <table id="dataTable" class="table table-bordered data-table" cellspacing="0">
                <thead>
                    <tr class="text-dark">
                        <th>No</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>No Wa</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody  class="text-dark">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
            
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm" name="ItemForm" class="form-horizontal">
                           <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Kode Supplier</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="kode_supplier" name="kode_supplier" placeholder="Enter Name" value="{{$kode_supplier}}" maxlength="50" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Supplier</label>
                                <div class="col-sm-12">
                                    <textarea id="nama_supplier" name="nama_supplier" required=""  class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No Wa</label>
                                <div class="col-sm-12">
                                    <textarea id="no_wa" name="no_wa" required=""  class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                             <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan
                             </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>
       </div>
     </div>
   </div>
 </div>
</body>
</div>
<script type="text/javascript">
 $(function () {
     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('supplier.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_supplier', name: 'kode_supplier'},
            {data: 'nama_supplier', name: 'nama_supplier'},
            {data: 'no_wa', name: 'no_wa'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     $('#createNewItem').click(function () {
        $('#saveBtn').val("create-Item");
        $('#id').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New Item");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editItem', function () {
      var id = $(this).data('id');
      $.get("{{ route('supplier.index') }}" +'/' + id +'/edit', function (data) {
          $('#modelHeading').html("Edit Item");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#nama_supplier').val(data.nama_supplier);
          $('#kode_supplier').val(data.kode_supplier);
          $('#no_wa').val(data.no_wa);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('supplier.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#ItemForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteItem', function () {
     
        var id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('supplier.store') }}"+'/'+id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
 });
</script>

@endsection