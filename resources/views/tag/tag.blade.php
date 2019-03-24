@extends('adminlte::page')

@section('title','标签管理')

@section('content_header')
    <h1>标签列表</h1>
@endsection

@section('content')
    <div class="container">
        <div class="col-md-11 col-lg-11 col-sm-11">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>标签名称</th>
                    <th>文章数</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody id="tag_list">
                    @foreach($tag as $each_tag)
                        <tr id="{{ $each_tag->id }}">
                            <th><a href="{{ route("tags.show",['id'=>$each_tag->id]) }}">{{ $each_tag->name }}</a></th>
                            <th>{{ $each_tag->posts->count() }}</th>
                            <th>
                                <button id="{{ $each_tag->id }}" class="btn-sm btn-danger" type="button" onclick="remove(this.id)">删除</button>
                                <button id="{{ $each_tag->id }}" class="btn-sm btn-success" type="button" onclick="edit(this.id)">编辑</button>
                            </th>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="form-group">
                <button  type="button" onclick="create()"  id="" class="btn-lg btn-success">新增标签</button>
            </div>
        </div>
        {{ $tag->links() }}
    </div>

@endsection

@section('js')
    <script type="text/javascript">

        function remove(id)
        {
            bootbox.confirm("你确定要删除这个标签及其所有文章吗?",function (result) {
                if(result){
                    $.ajax({
                        url:"{{url('admin/tags')}}"+"/"+id,
                        type:"DELETE",
                        dataType: "json",
                        success:function (data) {
                            if (data.status = 1){
                                bootbox.alert(data.msg,function(){
                                    window.location.reload();
                                });
                            }else {
                                bootbox.alert(data.msg,function(){
                                    window.location.reload();
                                });
                            }
                        },
                        error:function (e) {
                            console.log(e);
                        }
                    });
                }
            });
        }
        function edit (id) {
            window.location.href="tags/"+id+"/edit";
        }
        function create() {
            window.location.href="tags/create";
        }
    </script>

@endsection
