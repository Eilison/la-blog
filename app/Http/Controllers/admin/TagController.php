<?php

namespace App\Http\Controllers\admin;

use App\Posts;
use App\tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获得用户
        $user = Auth::user();
        //频道用户是否是管理员
        if($user->hasRole('admin')){
            $tag = tag::paginate(10);
            return view('tag.tag',['tag' => $tag]);
        }else{
            $user_id = Auth::id();
            $tag = tag::where('user_id','=',$user_id) -> paginate(10);
            return view('tag.tag',['tag' => $tag]);
        }



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tag.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $tags = new tag();
        $user_id = Auth::id();
        $tag = $request -> input('tag');

        $tags -> user_id = $user_id;
        $tags -> name = $tag;

        if ($tags -> save()){
            $arr = ['status' => 1,'msg' => "新增成功"];
            return json_encode($arr);
        }else{
            $arr = ['status' => 0,'msg' => "新增失败"];
            return json_encode($arr);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$name = tag::findOrFail($id)->name;
		$post = Posts::where('tag_id','=',$id)->paginate(10);
		return view('tag.show',['name'=>$name,'posts'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tag = tag::findOrFail($id);
        return view('tag.editor') -> with(['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $tag = tag::findOrFail($id);
        if($tag -> name == $request -> input('tag')){
            $arr = ['status' => 0,'msg' => "更新失败，该标签未被更改"];
            return json_encode($arr);
        }else{
            $tag -> name = $request -> input('tag');

            if($tag -> save()){
                $arr = ['status' => 1,'msg' => "更新成功"];
                return json_encode($arr);
            }else{
                $arr = ['status' => 0,'msg' => "跟新失败"];
                return json_encode($arr);
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        if(Posts::where('tag_id','=',$id)->count() != 0){
            $array = ['status' => 0,'msg' => "删除失败,该标签下有文章不能被删除"];
            return json_encode($array);
        }else{
            $tag = tag::findOrFail($id);
            if ($tag -> delete()){
                $array = ['status' => 1,'msg' => "删除成功"];
                return json_encode($array);
        }

        }
    }
}
