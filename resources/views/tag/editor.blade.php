@extends('adminlte::page')

@section('title','编辑标签')

@section('content_header')
    <h1>编辑标签</h1>
@endsection

@section('content')
    <form class="form-horizontal" method="post"  id="post-form" role="form" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="form-group col-md-8 col-lg-8">
            <label for="title">标签</label>
            <div class="row">
                <div class="col-sm-8 col-md-8">
                    <input type="text" class="form-control" name="tag" id="tag" onchange="changeValue(this)" placeholder="标签"  value="{{ $tag -> name }}"/>
                    <datalist id="tag_list">
                    </datalist>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button  type="button" onclick="tag_update(this.id)"  id="{{$tag -> id}}" class="btn-lg btn-success">更新</button>
        </div>
    </form>
@endsection

@section('js')

    <script type="text/javascript">
        $(function() {
            editor = editormd("editormd", {
                path:"{{ asset('editormd/lib') }}"+"/",
                height: 800,
                syncScrolling: "single",
                toolbarAutoFixed: false,
                saveHTMLToTextarea: false,
            });
        });

        function changeValue(obj){
            $(obj).attr("value",$(obj).val());
        }
        
        function tag_update(id) {
            bootbox.confirm("你确定要更新这个标签吗?",function (result){
                if (result){
                    $.ajax({
                        url:"{{url('admin/tags')}}"+"/"+id,
                        type:"PUT",
                        data:$("form").serialize(),
                        dataType: "json",
                        success:function (data) {
                            if (data.status = 1){
                                bootbox.alert(data.msg,function(){
                                    window.location.href = "{{ route('tags.index') }}";
                                });
                            }else {
                                bootbox.alert(data.msg,function(){
                                    window.location.reload();
                                });
                            }
                        },
                        error:function (e) {
                            bootbox.alert("更新失败");
                        }
                    });
                }

            });
        }
        $("#post-form").bootstrapValidator({
            message: '这个值没有被验证',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields:{
                tag:{
                    validators:{
                        notEmpty:{
                            message:"文章标签不能为空"
                        }
                    }
                }
            }
        });

    </script>

@endsection
