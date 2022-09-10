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
                            <th>{{__('words.description')}}</th>
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



@push('javascript')
    <script type="text/javascript">
        $(function(){
            var table = $('#table_id').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0 , "desc"]
                ],
                ajax: "{{route('dashboard.post.all')}}",
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
                        data: 'smallDesc',
                        name: 'smallDesc',
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