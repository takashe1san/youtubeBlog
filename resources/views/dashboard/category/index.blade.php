@extends('dashboard.layouts.layout')
@section('body')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Striped table
                </div>
                <div class="card-block">
                    <table class="table table-striped" id="table_id">
                        <thead>
                            <tr>
                                <th>{{__('words.id')}}</th>
                                <th>{{__('words.title')}}</th>
                                <th>{{__('words.content')}}</th>
                                <th>{{__('words.parent')}}</th>
                                <th>{{__('words.image')}}</th>
                                <th>{{__('words.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal" id="deletemodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{route('dashboard.users.delete')}}" method="post">
            <div class="modal-content">
                @csrf
                {{-- @method('delete') --}}
                <div class="modal-body">
                    <p>{{__('words.sureDelete')}}</p> 
                    <input type="hidden" name="id" id="id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" >{{__('words.delete')}}</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal">{{__('words.close')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('javascript')
    <script type="text/javascript">
        $(function(){
            var table = $('#table_id').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0 , "desc"]
                ],
                ajax: "{{route('dashboard.category.all')}}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false
                    },
                    {
                        data: 'content',
                        name: 'content',
                        defaultContent: '  ',
                        orderable: false
                    },
                    {
                        data: 'parent.title',
                        name: 'parent.title',
                        defaultContent: '  ',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'img',
                        name: 'img',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

        $('#table-id tbody').on('click', '#deleteBtn', function(argument){
            var id = $(this).attr('data-id');
            console.log(id);
            $('#deletemodal #id').val(id);
        })
    </script>
@endpush