<?php

namespace App\Http\Controllers;

use App\Models\Nft;
use Illuminate\Http\Request;
use Validator;
use Image;

class NftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try
        {   
            $user = user();
            $query = Nft::query();
            if($user->role == 'user')
            {
                $query->where('id',$user->id)->where('is_mint',0);
            }
            if($request->has('search'))
            {
                $search = $request->search;
                $query->where('title', 'LIKE', "%$search%");
            }
            $nfts = $query->latest()->paginate(10);
            return response()->json($nfts);
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:50|unique:nfts',
                'description' => 'required',
                'price' => 'required|numeric',
                'image' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Please fill all requirement fields', 
                    'data' => $validator->errors()
                ], 422);  
            }

            if($request->image)
            {
               $position = strpos($request->image, ';');
               $sub = substr($request->image, 0 ,$position);
               $ext = explode('/', $sub)[1];
               $name = time().user()->id.".".$ext;
               $img = Image::make($request->image);
               $upload_path = 'uploads/nfts/';
               $image_url = $upload_path.$name;
               $img->save($image_url);
            }

            $nft = Nft::create([
                'user_id' => user()->id,
                'title'   => $request->title,
                'description' => $request->description,
                'token_id' => $request->has('token_id')?$request->token_id:null,
                'price' => $request->price,
                'image' => $image_url,
            ]);

            return response()->json(['status'=>true, 'nft_id'=>intval($nft->id), 'message'=>'Successfully a nft has been ']);

        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Nft $nft)
    {
        return response()->json(['status'=>true, 'data'=>$nft]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nft $nft)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nft $nft)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:50|unique:nfts,title,' . $nft->id,
                'description' => 'required',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Please fill all requirement fields', 
                    'data' => $validator->errors()
                ], 422);  
            }

            if($request->image)
            {
               $position = strpos($request->image, ';');
               $sub = substr($request->image, 0 ,$position);
               $ext = explode('/', $sub)[1];
               $name = time().user()->id.".".$ext;
               $img = Image::make($request->image);
               $upload_path = 'uploads/nfts/';
               $image_url = $upload_path.$name;
               $img->save($image_url);
            }else{
                $image_url = $nft->image;
            }

            $nft->title = $request->title;
            $nft->description = $request->description;
            $nft->token_id = $request->has('token_id')?$request->token_id:$nft->token_id;
            $nft->price = $request->price;
            $nft->image = $image_url;
            $nft->update();

            return response()->json(['status'=>true, 'nft_id'=>intval($nft->id), 'message'=>'Successfully the nft has updated']);

        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nft $nft)
    {
        try
        {
            unlink(public_path($nft->image));
            $nft->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully the nft has been deleted']);
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
