<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutMe;
use Illuminate\Support\Facades\Storage;

class AboutMeController extends Controller
{
    public function index()
    {
        $aboutMe = AboutMe::first();
        return view('about-me.index', compact('aboutMe'));
    }

    public function edit()
    {
        $aboutMe = AboutMe::first();
        return view('about-me.edit', compact('aboutMe'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'student_id' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $aboutMe = AboutMe::first() ?? new AboutMe();
        $aboutMe->name = $data['name'] ?? $aboutMe->name;
        $aboutMe->student_id = $data['student_id'] ?? $aboutMe->student_id;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($aboutMe->image_path && Storage::disk('public')->exists(str_replace('/storage/', '', $aboutMe->image_path))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $aboutMe->image_path));
            }
            $imagePath = $request->file('image')->store('about_me', 'public');
            $aboutMe->image_path = Storage::url($imagePath);
        }

        $aboutMe->save();

        return redirect()->route('about-me.index')->with('success', 'Profile updated successfully!');
    }
}
