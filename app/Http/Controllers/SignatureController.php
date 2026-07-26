<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SignatureController extends Controller
{
    /**
     * Save digital canvas signature for logged in user.
     */
    public function saveSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $base64Image = $request->signature_data;

        // Strip data:image/png;base64, header if present
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // png, jpg, etc.

            if (!in_array($type, ['png', 'jpg', 'jpeg', 'webp'])) {
                return response()->json(['status' => 'error', 'message' => 'Invalid image format.'], 422);
            }

            $imageData = base64_decode($base64Image);

            if ($imageData === false) {
                return response()->json(['status' => 'error', 'message' => 'Base64 decode failed.'], 422);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid base64 signature format.'], 422);
        }

        // Target directory: public/uploads/signatures
        $destinationPath = public_path('uploads/signatures');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Delete previous signature if exists
        if ($user->signature && File::exists(public_path($user->signature))) {
            File::delete(public_path($user->signature));
        }

        $fileName = 'signature_user_' . $user->id . '_' . time() . '.png';
        $relativeFilePath = 'uploads/signatures/' . $fileName;

        File::put($destinationPath . '/' . $fileName, $imageData);

        // Save to user model
        $user->signature = $relativeFilePath;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Digital Signature saved successfully!',
            'signature_path' => asset($relativeFilePath),
        ]);
    }
}
