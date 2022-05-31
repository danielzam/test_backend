<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class JobOfferController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $offers = JobOffer::all();
        foreach ($offers as $offer) {
            $offer->associate_users = User::select(
                'users.id', 'users.name', 'users.email', 'dt.name as DNI', 'users.document_number'
            )
                ->whereIn('users.id', json_decode($offer->associate_users))
                ->join('document_types as dt', 'users.document_type_id', '=', 'dt.id')
                ->get();
        }

        return response()->json([
            'code'      => 200,
            'offers'    => $offers
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_name'        => 'required|string',
            'associate_users'   => 'required',
            'status'            => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'      => 400,
                'errors'    => $validator->errors()
            ]);
        }

        JobOffer::create($validator->validate());

        return response()->json([
            'code'  => 200,
            'msg'   => 'Oferta registrada con éxito!'
        ]);
    }
}
