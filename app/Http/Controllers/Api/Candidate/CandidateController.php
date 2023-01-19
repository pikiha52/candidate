<?php

namespace App\Http\Controllers\Api\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Exception;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * @OA\Get(
     *      path="/candidate/view",
     *      operationId="candidate",
     *      tags={"Candidate"},
     *      security={{"bearer_token":{}}},
     *      summary="Candidate",
     *      description="List all candidate",
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="true"),
     *             @OA\Property(property="user",type="object")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *  )
     */
    public function index()
    {
        $candidates = Candidate::all();
        return response()->json([
            'success' => true,
            'data' => $candidates
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/candidate/add",
     *      operationId="candidateAdd",
     *      tags={"Candidate"},
     *      security={{"bearer_token":{}}},
     *      summary="Candidate",
     *      description="List all candidate",
     *     	@OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      description="name",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="education",
     *                      description="education",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="birthday",
     *                      description="birthday",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="experience",
     *                      description="experience",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="last_position",
     *                      description="last_position",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="applied_position",
     *                      description="applied_position",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="skils",
     *                      description="skils",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="email",
     *                      description="email",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="phone",
     *                      description="phone",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="resume",
     *                      description="resume",
     *                      type="file",
     *                   ),
     *               ),
     *           ),
     *       ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="true"),
     *             @OA\Property(property="user",type="object")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *  )
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'education' => 'required',
                'birthday' => 'required',
                'experience' => 'required',
                'last_position' => 'required',
                'applied_position' => 'required',
                'skils' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'resume' => 'required|mimes:pdf|max:10000'
            ]);

            $candidate = new Candidate();
            $candidate->name = $request->name;
            $candidate->education = $request->education;
            $candidate->birthday = $request->birthday;
            $candidate->experience = $request->experience;
            $candidate->last_position = $request->last_position;
            $candidate->applied_position = $request->applied_position;
            $candidate->skils = $request->skils;
            $candidate->email = $request->email;
            $candidate->phone = $request->phone;

            $resume = $request->file('resume');
            $fileName = $resume->hashName();
            if ($resume != null) {
                $resume->storeAs('public/resume', $fileName);
            }

            $candidate->resume = $fileName;
            $candidate->save();

            return response()->json([
                'success' => true,
                'data' => $candidate
            ], 200);

        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'message' => $err->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/candidate/read/{id}",
     *      operationId="candidateRead",
     *      tags={"Candidate"},
     *      security={{"bearer_token":{}}},
     *      summary="Candidate",
     *      description="List one candidate by id",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="true"),
     *             @OA\Property(property="user",type="object")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *  )
     */
    public function show($id)
    {
        $candidate = Candidate::find($id);
        $data = [];

        if ($candidate) {
            $data = $candidate;
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/candidate/edit/{id}",
     *      operationId="candidateEdit",
     *      tags={"Candidate"},
     *      security={{"bearer_token":{}}},
     *      summary="Candidate",
     *      description="Edit candidate",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *    @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      description="name",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="education",
     *                      description="education",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="birthday",
     *                      description="birthday",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="experience",
     *                      description="experience",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="last_position",
     *                      description="last_position",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="applied_position",
     *                      description="applied_position",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="skils",
     *                      description="skils",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="email",
     *                      description="email",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="phone",
     *                      description="phone",
     *                      type="string",
     *                   ),
     *                  @OA\Property(
     *                      property="resume",
     *                      description="resume",
     *                      type="file",
     *                   ),
     *               ),
     *           ),
     *       ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="true"),
     *             @OA\Property(property="user",type="object")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *  )
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'education' => 'required',
                'birthday' => 'required',
                'experience' => 'required',
                'last_position' => 'required',
                'applied_position' => 'required',
                'skils' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            $candidate = Candidate::find($id);
            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'candidate not found'
                ], 400);
            }

            $candidate->name = $request->name;
            $candidate->education = $request->education;
            $candidate->birthday = $request->birthday;
            $candidate->experience = $request->experience;
            $candidate->last_position = $request->last_position;
            $candidate->applied_position = $request->applied_position;
            $candidate->skils = $request->skils;
            $candidate->email = $request->email;
            $candidate->phone = $request->phone;

            $resume = $request->file('resume');
            if ($resume != null) {
                $fileName = $resume->hashName();
                $resume->storeAs('public/resume', $fileName);
                $candidate->resume = $fileName;
            }

            $candidate->save();

            return response()->json([
                'success' => true,
                'data' => $candidate
            ], 200);

        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'message' => $err->getMessage()
            ], 200);
        }
    }

    /**
     * @OA\Delete(
     *      path="/candidate/delete/{id}",
     *      operationId="candidateDelete",
     *      tags={"Candidate"},
     *      security={{"bearer_token":{}}},
     *      summary="Candidate",
     *      description="Delete one candidate",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="true"),
     *             @OA\Property(property="user",type="object")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *  )
     */
    public function delete($id)
    {
        $candidate = Candidate::find($id);
        if (!$candidate) {
            return response()->json([
                'success' => false,
                'message' => 'candidate not found'
            ], 400);
        }

        $candidate->delete();

        return response()->json([
            'success' => true,
            'message' => 'candidate success to delete'
        ], 200);

    }
}
