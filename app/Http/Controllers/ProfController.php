<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ProfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::all();
        return view('admin.profile.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_lengkap' => 'required|string|max:55',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:55',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'alamat' => 'nullable|string|max:250',
        ]);

        $name = null;
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $path = $image->store('public/image');
            $name = basename($path);
        }

        Profile::create([
            'nama_lengkap' => $request->nama_lengkap,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'description' => $request->description,
            'picture' => $name,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('profiles.index')->with('success', 'Data berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Profile::findOrFail($id);
        return view('admin.profile.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);

        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_lengkap' => 'nullable|string|max:55',
            'alamat' => 'nullable|string|max:250',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|string|email|max:55',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        if ($request->hasFile('picture')) {
            if ($profile->picture) {
                Storage::delete('public/image/' . $profile->picture);
            }
            $image = $request->file('picture');
            $path = $image->store('public/image');
            $profile->picture = basename($path);
        }

        $profile->update([
            'nama_lengkap' => $request->nama_lengkap ?? $profile->nama_lengkap,
            'alamat' => $request->alamat ?? $profile->alamat,
            'no_telepon' => $request->no_telepon ?? $profile->no_telepon,
            'email' => $request->email ?? $profile->email,
            'description' => $request->description ?? $profile->description,
            'facebook' => $request->facebook ?? $profile->facebook,
            'twitter' => $request->twitter ?? $profile->twitter,
            'linkedin' => $request->linkedin ?? $profile->linkedin,
            'instagram' => $request->instagram ?? $profile->instagram,
        ]);

        return redirect()->route('profiles.index')->with('success', 'Update Profile berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        if ($profile->picture) {
            Storage::delete('public/image/' . $profile->picture);
        }

        $profile->forceDelete();
        return redirect()->route('profiles.index')->with('success', 'Delete Berhasil');
    }

    /**
     * Soft delete the specified resource.
     */
    public function softDelete(string $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Data berhasil dihapus sementara');
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus($id): JsonResponse
    {
        // Set status of all profiles to 0 except the specified one
        Profile::where('id', '!=', $id)->update(['status' => 0]);

        // Update status of the specified profile to 1
        $profile = Profile::findOrFail($id);
        $profile->status = 1;
        $profile->save();

        return response()->json(['success' => 'Status berhasil diperbarui.']);
    }

    public function recycle()
    {

        $profiles = Profile::onlyTrashed()->paginate(15);
        return view('admin.profile.recycle', compact('profiles'));
    }

    public function restore($id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        $profile->restore();

        return redirect()->route('profiles.index')->with('success', 'Data berhasil di Restore');
    }
}
