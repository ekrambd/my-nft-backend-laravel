<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Nft;

class MintMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {   

        if($request->has('nft_id')){
            $nft_id = $request->nft_id;
            $nft = Nft::find($nft_id);
        } elseif ($request->route('nft')) {
            $nft = $request->route('nft');
        } else {
            $nft = null;
        }

        if($nft)
        {
        	if ($nft->is_mint == 1) {
	            return response()->json([
	                'status' => false,
	                'mint_id' => 0,
	                'nft_id' => $nft->id,
	                'message' => 'NFT has already been minted'
	            ], 400);
	        }
        }

        return $next($request); 
    }
}
