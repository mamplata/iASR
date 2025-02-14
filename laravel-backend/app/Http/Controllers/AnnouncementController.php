<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Announcement::query();

        // Filtering by department
        if ($request->has('department') && !empty($request->department)) {
            $query->where('department', $request->department);
        }

        // Filtering by publisher
        if ($request->has('publisher') && !empty($request->publisher)) {
            $query->where('publisher', $request->publisher);
        }

        return Inertia::render('Announcement/Index', [
            'announcements' => $query->paginate(5),
            'filters'       => $request->only(['department', 'publisher']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Announcement/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'department'       => 'required|string',
                'publisher'        => 'required|string',
                'publication_date' => 'required|date',
                'content_type'     => 'required|in:text,image',
                // For text content, headline and body must be provided.
                'headline'         => 'nullable|required_if:content_type,text|string',
                'body'             => 'nullable|required_if:content_type,text|string',
                // For image content, a valid image file is required.
                'image'            => 'nullable|required_if:content_type,image|image',
            ]);

            if ($validator->fails()) {
                // Dump errors for debugging and stop execution.
                var_dump($validator->errors()->all());
                exit;
            }

            // Process the content based on the type.
            if ($request->content_type === 'text') {
                $content = json_encode([
                    'headline' => $request->headline,
                    'body'     => $request->body,
                ]);
            } else {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $content = base64_encode(file_get_contents($image->getRealPath()));
                } else {
                    return back()->withErrors(['image' => 'Image upload failed.']);
                }
            }

            Announcement::create([
                'department'       => $request->department,
                'publisher'        => $request->publisher,
                'content'          => $content,
                'publication_date' => $request->publication_date,
                'content_type' => $request->content_type,
            ]);

            return redirect()->route('announcements')
                ->with('success', 'Announcement created successfully.');
        } catch (\Exception $e) {
            // Optionally log the exception: \Log::error($e);
            return back()->withErrors(['error' => 'An error occurred while creating the announcement.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        // Determine the content type by attempting to decode the content.
        $decoded = json_decode($announcement->content, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            // Content is text.
            $announcement->content_type = 'text';
            $announcement->headline = $decoded['headline'] ?? '';
            $announcement->body = $decoded['body'] ?? '';
        } else {
            // Content is image.
            $announcement->content_type = 'image';
            // Optionally, you might provide a URL or preview mechanism for the image.
            $announcement->image = null;
        }

        return Inertia::render('Announcement/Edit', [
            'announcement' => $announcement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        try {
            $validator = Validator::make($request->all(), [
                'department'       => 'required|string',
                'publisher'        => 'required|string',
                'publication_date' => 'required|date',
                'content_type'     => 'required|in:text,image',
                'headline'         => 'nullable|required_if:content_type,text|string',
                'body'             => 'nullable|required_if:content_type,text|string',
                'image'            => 'nullable|required_if:content_type,image|image',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            // Process content based on type.
            if ($request->content_type === 'text') {
                $content = json_encode([
                    'headline' => $request->headline,
                    'body'     => $request->body,
                ]);
            } else {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $content = base64_encode(file_get_contents($image->getRealPath()));
                } else {
                    // If no new image is provided, keep the existing content.
                    $content = $announcement->content;
                }
            }

            $announcement->update([
                'department'       => $request->department,
                'publisher'        => $request->publisher,
                'content'          => $content,
                'publication_date' => $request->publication_date,
                'content_type' => $request->content_type,
            ]);

            return redirect()->route('announcements')
                ->with('success', 'Announcement updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the announcement.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        try {
            $announcement->delete();
            return redirect()->route('announcements')
                ->with('success', 'Announcement deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while deleting the announcement.']);
        }
    }
}
