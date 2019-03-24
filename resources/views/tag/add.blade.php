@extends('adminlte::page')

@section('title','新增标签')

@section('content_header')
    <h1>新增标签</h1>
@endsection

@section('content')
    <form class="form-horizontal" method="post"  id="post-form" role="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group col-md-8 col-lg-8">
            <label for="title">文章标签</label>
            <div class="row">
                <div class="col-sm-8 col-md-8">
                    <input type="text" class="form-control" name="tag" id="tag" list="tag_list" placeholder="文章标签"/>
                    <datalist id="tag_list">
                    </datalist>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button  type="button" onclick="tag_create()"  id="ajax" class="btn-lg btn-success">新增</button>
        </div>
    </form>
@endsection

@section('js')

    <script type="text/javascript">
        $(function() {
            add = editormd("addmd", {
                path:"{{ asset('addmd/lib') }}"+"/",
                height: 800,
                syncScrolling: "single",
                toolbarAutoFixed: false,
                saveHTMLToTextarea: false,
            });
        });
        function tag_create(){
            $.ajax({
                url:"{{ route('tags.store') }}",
                data:$("form").serialize(),
                type:"POST",
                dataType:"text",
                success:function (data) {
                    bootbox.alert("文章标签新增成功",function(){
                        window.location.href=" {{ route('tags.index') }}";
                    });
                },
                error:function(e){
                    bootbox.alert("发布失败");
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