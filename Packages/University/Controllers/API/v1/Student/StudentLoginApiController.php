<?php

namespace Packages\University\Controllers\API\v1\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Packages\University\Models\Student;

class StudentLoginApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'university_no' => ['required', 'exists:students,university_no'],
            'password' => 'required|string',
        ]);

        $student = Student::query()->where('university_no', $validated['university_no'])->first();

        $hashedPassword = $student?->password ?? Hash::make('fake-passw0rd-125AFD');

        if (!$student || !Hash::check($validated['password'], $hashedPassword)) {
            return response()->json(
                [
                    'message' => __('backend.invalid_login_details'),
                ],
                401,
            );
        }

        $student->tokens()->delete();

        $token = $student->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => __('backend.logged_in_successfuly'),
            'data' => [
                'id' => $student->id,
                'name' => $student->full_name,
                'university_no' => $student->university_no,
                'auth_token' => $token,
                'token_type' => 'Bearer',
                'account_type' => 'student',
            ],
        ]);
    }
}
