@extends('layouts.master')

@section('title','Employe')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('public/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}"
          rel="stylesheet">
@endpush

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>All Employe <span class="badge bg-blue">{{ $employes->count() }}</span></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable"
                                   id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
                                <thead>
                                <tr role="row">
                                    <th class="text-center">Sl. No</th>
                                    <th class="text-center">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 100px;">Image</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">address</th>
                                    <th class="text-center">Salary</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">Sl. No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">address</th>
                                    <th class="text-center">Salary</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($employes as $key=>$employe)
                                        <tr>
                                            <td class="text-center">{{$key + 1}}</td>
                                            <td class="text-center">{{$employe->name}}</td>
                                            <td class="text-center"><img src="{{URL::to($employe->image)}}" class="img-responsive" style="height: 80px;"></td>
                                            <td class="text-center">{{$employe->phone}}</td>
                                            <td class="text-center">{{$employe->address}}</td>
                                            <td class="text-center">{{$employe->salary}}</td>
                                            <td class="text-center">
                                                <a href="{{ route('employe.show',$employe->id) }}" class="btn btn-success waves-effect" target="_blank"><i class="material-icons">visibility</i></a>
                                                <a href="{{ route('employe.edit',$employe->id) }}" class="btn btn-primary waves-effect"><i class="material-icons">edit</i></a>
                                                <button class="btn btn-danger waves-effect" onclick="deleteEmploye({{ $employe->id }})"><i class="material-icons">delete</i></button>
                                                <form id="delete-form-{{ $employe->id }}" action="{{ route('employe.destroy',$employe->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
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
    </div>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('public/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('public/backend/js/pages/tables/jquery-datatable.js') }}"></script>

    <script type="text/javascript">
        function deleteEmploye(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure to delete this item',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your Data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
