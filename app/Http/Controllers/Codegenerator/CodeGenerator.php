<?php

namespace App\Http\Controllers\Codegenerator;

use App\Http\Resources\ProposalResource;
use App\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException ;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;



class CodeGenerator extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            else
            {
                return ProposalResource::collection(Proposal::all());

            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_missing'], $e->getStatusCode());

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            else
            {
                $validator= $this->validate_data($request);
                if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
                }
                $proposal_number = $request->get('proposal_number');
                $proposal_type = $request->get('proposal_type');
                $technical_name = $request->get('technical_name');
                $client_source = $request->get('client_source');
                $sales_name=$user->name;
                //make proposal number four digit
                $proposal_number = str_pad($proposal_number, 4, '0', STR_PAD_LEFT);

                //check to avoid null or empty string
                if(!empty($proposal_type)&&!empty($technical_name)
                    && !empty($proposal_number) &&!empty($client_source)&&!empty($sales_name))
                 {
                    // generate the code
                     $required_data=array($proposal_type ,$technical_name ,$proposal_number ,$client_source , $sales_name);
                     $code=$this->generateCode($required_data ,$proposal_number);
                     $proposal=Proposal::create(array_merge($request->all(), ['generated_code' => $code ,'sales_agent_ID' => $user->id]));
                     return response()->json([compact('proposal')], 200);

                }
                else{
                    return response()->json(['missing parameters'], 400);
                }

            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_missing'], $e->getStatusCode());

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

        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            else
            {

                $Proposal=Proposal::find($id);
                if($Proposal)
                {
                      return new ProposalResource($Proposal);

                }
                else{
                    return response()->json(['error'=>'this user not found'], 400);

                }


            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_missing'], $e->getStatusCode());

        }

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        try {
//
//            if (! $user = JWTAuth::parseToken()->authenticate()) {
//                return response()->json(['user_not_found'], 404);
//            }
//            else
//            {
//                $proposal=Proposal::where("id" , $id)->first();
//                if($proposal->sales_agent_ID != $user->id && !$user->hasRole('admin')){
//                    return response()->json(['you not have permssion to do this action'], 400);
//                }
////                $validator= $this->validate_data($request);
////                if($validator->fails()){
////                    return response()->json($validator->errors()->toJson(), 400);
////                }
//               $any= $request->get('proposal_number');
//                return response()->json(compact('any'), 400);
//
//                $proposal_number = $request->get('proposal_number');
//                $proposal_type = $request->get('proposal_type');
//                $technical_name = $request->get('technical_name');
//                $client_source = $request->get('client_source');
//                $sales_name=$user->name;
//                $proposal_number = str_pad($proposal_number, 4, '0', STR_PAD_LEFT);
//
//                //check to avoid null or empty string
//                if(!empty($proposal_type)&&!empty($technical_name)
//                    && !empty($proposal_number) &&!empty($client_source)&&!empty($sales_name))
//                {
//                    // generate the cod
//                    $required_data=array($proposal_type ,$technical_name ,$proposal_number ,$client_source , $sales_name);
//                    $code=$this->generateCode($required_data ,$proposal_number );
//                    $proposal = Proposal::whereId($id)->
//                    update(array_merge($request->all(), ['generated_code' => $code ,'sales_agent_ID' => $user->id]));
//
//                    return response()->json([compact('proposal')], 200);
//
//                }
//                else{
//                    return response()->json(['missing parameters'], 400);
//                }
//
//
//
//             }
//
//          } catch (TokenExpiredException $e) {
//
//            return response()->json(['token_expired'], $e->getStatusCode());
//
//          } catch (TokenInvalidException $e) {
//
//            return response()->json(['token_invalid'], $e->getStatusCode());
//
//          } catch (JWTException $e) {
//
//            return response()->json(['token_missing'], $e->getStatusCode());
//
//          }
//
//   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            else
            {
                $proposal=Proposal::where("id" , $id)->first();
               if($proposal&&$proposal->sales_agent_ID != $user->id && !$user->hasRole('admin')){
                    return response()->json(['you_not_have_permssion_to_do_this_action'], 400);
               }

               else
               {
                   $proposald=Proposal::where('id',$id)->delete();
                   if($proposald)
                   {
                       return new ProposalResource($proposal);


                   }
                   else
                   {
                       return response()->json(["error"=>"failed_to_delete"], 400);

                   }

               }


            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_missing'], $e->getStatusCode());

        }
    }

// fuction generate the code



function generateCode($required_data ,$proposal_number){

    $code="";
    $counter=0;
    foreach ($required_data as $word)
    {
        $counter++;
        if($counter==3){
            $code .= "-$proposal_number-";
            continue;
        }
        $expr = '/(?<=\s|^)[a-z]/i';
        preg_match_all($expr, $word, $matches);
        // check the client source if is one word  like RECAP will be RE
        if(count($matches[0])==1 && $counter==4)
        {

            $code .= strtoupper(substr($word , 0 , 2));
            continue;

        }
        $code .= strtoupper(implode("",$matches[0]));

    }
     return $code;
    //end function return $code
}



    //validate data
    public function validate_data($request)
    {
        //regex:/(?!^\d+$)^.+$/ this regex match string . does not match any digit alone .

        $validator = Validator::make($request->all(), [
            'proposal_number' => 'required|digits_between:0,5',
            'proposal_type' => 'required|regex:/(?!^\d+$)^.+$/|max:50',
            'technical_name' => 'required|regex:/(?!^\d+$)^.+$/|max:50',
            'client_source' => 'required|regex:/(?!^\d+$)^.+$/|max:50',
            'proposal_date' => 'nullable|date' ,
            'propsal_value' => 'nullable|digits_between:0,',
            'client_name' => 'nullable|regex:/(?!^\d+$)^.+$/',

        ]);
        return $validator;
    }


}
