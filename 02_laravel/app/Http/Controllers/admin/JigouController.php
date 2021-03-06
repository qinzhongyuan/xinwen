<?php 
namespace App\Http\Controllers\admin;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadsController;
use App\Http\Requests;
use DB;
class JigouController extends BaseController
{
	public function getIndex()
	{
		$arr = DB::table('p2p_jigou')->get();
		return view('/admin/jigou/index',['arr'=>$arr]);
	}
	public function postAdd(Request $request)
	{	
      
        $lpic =   UploadsController::uploads($request,'pic');
         if($lpic == '上传文件不符合要求'){
          return back()->with('error','上传文件不符合要求');
        }

        if($lpic=='上传文件不符合要求(图片要小于2MB)'){
          return back()->with('error','上传文件不符合要求(图片要小于2MB)');
        }

		// var_dump($lpic);
        $src = DB::table('p2p_jigou')->insert(['lpic'=>$lpic]);
        // dd($src);
        if(!$src){
        return	back()->with('error','图片数据添加失败');
        }
        	return redirect('/admin/jigou/index');


	}

	public function getDel(Request $request)
	{
		$id = $request->only('id');
    //拼接删除文件public中的文件路径
      $sre1 = DB::table('p2p_jigou')->where('id',$id)->first();
      $file = $sre1->lpic;
      $path = base_path($file);
      $src =  explode('/',$path);
      $src[0] = $src[0].'public';
      $unlinkpic = implode('\\',$src);
        unlink($unlinkpic);
        $sre = DB::table('p2p_jigou')->where('id','=',$id)->delete();
		if($sre){
			return 1;
		}else{
			return 2;
		}
	}



}
 ?>