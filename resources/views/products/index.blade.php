@extends('layouts.app')
@section('table')
    <div class="container">
        <div calss="row">
            <a href="{{ route('products.create') }}" class="btn btn-success">{{ __('Add Products')  }}</a>
        </div>
        <div class="row">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="productTable" class="table table-hover dataTable no-footer" role="grid" aria-describedby="dataTable_info">
                                        <thead>
                                        <tr>

                                            <th tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                                aria-label=": activate to sort column ascending">
                                                <input type="checkbox" class="select_all">
                                            </th>
                                            <th>{{ __('name') }}</th>
                                            <th>{{ __('price') }}</th>
                                            <th>{{ __('slug') }}</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Single delete modal--}}
        <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="{{ __('close') }}"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><i
                                class="voyager-trash"></i> {{ __('Delete') }}
                            {{ __('Product') }}</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="#" id="delete_form" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                   value="{{ __('Confirm') }}">
                        </form>
                        <button type="button" class="btn btn-default pull-right"
                                data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
@endsection

@push('scripts')
    <!-- DataTables -->
    <script>
        var url = '{{ route('products.ajax') }}';
        var columns = [
            {

                data: 'id', orderable: false, searchable: false, "render": function (id) {
                    return `<input type="checkbox" name="row_id" id="checkbox_${id}" value="${id}">`;
                }
            },
            {data: 'name', name: '  name'},
            {data: 'price', name: 'price'},
            {data: 'slug', name: 'slug'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ];
        var del = '{{ route('product.destroy', ['id' => '__id']) }}';

        var dom = "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3 datatable-button'B> >" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>";
        var length = [[10, 25, 50, 100, 500,-1], [10, 25, 50, 100, 500,'All']];

        $('#productTable').DataTable({
            "order": [[ 1, "desc" ]],
            processing: true,
            serverSide: true,
            "lengthMenu": length,
            dom: dom,
            "aaSorting": [],
            "bDestroy": true,
            "pagingType": "full_numbers",
            ajax: {
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    table : true
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if(jqXHR['status'] == 401){
                        window.location.href =jqXHR['responseJSON']['redirect'];
                    }

                }
            },
            columns: columns,
            fnServerParams: function(data) {
                data['order'].forEach(function(items, index) {
                    data['order'][index]['column'] = data['columns'][items.column]['data'];
                });
            }
        });

        $(document).ready(function(){
            var deleteFormAction;
            $('#productTable').on('click', '.delete', function (e)
            {
                $('#delete_form')[0].action = '{{ route('product.destroy', ['id' => '__id']) }}'.replace('__id', $(this).data('id'));
                $('#delete_modal').modal('show');
            });
        })
    </script>
@endpush
