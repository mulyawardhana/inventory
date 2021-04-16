@extends('layouts.master')

@section('content')
<title>Data Kategori | MWD</title>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Jenis</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive ">

    	 	@if( Session::get('pesan') !="")
            <div class='alert alert-success'><center><b>{{Session::get('pesan')}}</b></center></div>        
            @endif

            <a class="btn btn-success" href="javascript:void(0)" id="createNewItem"><i class="fa fa-plus"></i> Add</a>
            <br>
            <br>
            <table id="dataTable" class="table table-bordered data-table" cellspacing="0">
                <thead>
                    <tr class="text-dark">
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody  class="text-dark">
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- <div id="tambah" class="modal fade" tabindex="-1" role="dialog"> -->
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
                                <label for="name" class="col-sm-2 control-label">Kategori</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="nama_kategori" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
<!--                             <div class="form-group">
                                <label class="col-sm-3 control-label">descriptions</label>
                                <div class="col-sm-12">
                                    <textarea id="description" name="description" required="" placeholder="Enter descriptions" class="form-control"></textarea>
                                </div>
                            </div> -->
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
        ajax: "{{ route('kategori.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_kategori', name: 'nama_kategori'},
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
      $.get("{{ route('kategori.index') }}" +'/' + id +'/edit', function (data) {
          $('#modelHeading').html("Edit Item");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#name').val(data.nama_kategori);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('kategori.store') }}",
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
            url: "{{ route('kategori.store') }}"+'/'+id,
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