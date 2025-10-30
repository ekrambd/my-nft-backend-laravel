<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mint;
use App\Models\Nft;
use Validator;
use DB;

class MintController extends Controller
{
    public function saveMint(Request $request)
    {   
        DB::beginTransaction();
    	try
    	{
    		$validator = Validator::make($request->all(), [
    			'nft_id' => 'required|integer|exists:nfts,id',
                'token_id' => 'required|integer',
                'wallet_address' => 'required|string',
                'mint_price' => 'required|numeric',
                'transaction_hash' => 'required|string|unique:mints',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Please fill all requirement fields', 
                    'data' => $validator->errors()
                ], 422);  
            }

            $mint = Mint::create([
            	'user_id' => user()->id,
            	'nft_id' => $request->nft_id,
            	'token_id' => $request->token_id,
            	'contract_address' => setting()->contract_address,
            	'wallet_address' => $request->wallet_address,
            	'mint_price' => $request->mint_price,
            	'transaction_hash' => $request->transaction_hash,
            	'status' => 'mint',
       			'date' => date('Y-m-d'),
       			'time' => date('h:i:s a'),
            ]);

            $nft = Nft::findorfail($request->nft_id);
            $nft->is_mint = 1;
            $nft->update();

            DB::commit();

            return response()->json(['status'=>true, 'mint_id'=>intval($mint->id), 'token_id'=>intval($request->token_id), 'nft_id'=>intval($request->nft_id), 'message'=>'Successfully you have minted the nft']);

    	}catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function mints(Request $request)
    {
    	try
    	{   
    		$user = user();
    		$query = Mint::query();
    		if($user->role == 'user')
    		{
    			$query->where('user_id',$user->id)->where('status','mint');
    		}
    		if($request->has('token_id'))
    		{
    			$query->where('token_id',$request->token_id);
    		}
    		if($request->has('from_date'))
    		{
    			$query->where('date', '>=', $request->from_date);
    		}
    		if($request->has('to_date'))
    		{
    			$query->where('date', '<=', $request->to_date);
    		}
            $mints = $query->latest()->paginate(10);
            return response()->json($mints);
    	}catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function mintDetails($id)
    {
        try
        {
            $mint = Mint::with('user','nft')->findorfail($id);
            return response()->json(['status'=>true, 'data'=>$mint]);
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
