<?php

namespace App\Http\Controllers;

use App\Models\NFCCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class NFCCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = NFCCard::query();

        return Inertia::render('NFC_Card/Index', [
            'nfcCards' => $query->paginate(5),
        ]);
    }


    public function isCardExisting() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|string|max:8|unique:nfc_cards,uid',
            'student_id' => 'required|string|max:7|unique:nfc_cards,student_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Send errors to frontend
                ->withInput();
        }

        // Store the student in the database
        $nfcCard = NFCCard::create([
            'uid' => $request->uid,
            'student_id'  => $request->student_id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(NFCCard $nFCCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NFCCard $nFCCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NFCCard $nFCCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NFCCard $nFCCard)
    {
        //
    }
}
