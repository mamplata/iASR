<?php
namespace App\Http\Controllers;

use App\Models\RFID_Card;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RFIDCardController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->query('search');
        $department = $request->query('department');

        $query = RFID_Card::query();

        if ($search) {
            $query->where('studName', 'like', "%$search%");
        }

        if ($department) {
            $query->where('department', $department);
        }

        return Inertia::render('RFID_Card/Index', [
            'cards' => $query->paginate(5),
            'filters' => [
                'search' => $search,
                'department' => $department
            ],
            'departments' => RFID_Card::distinct()->pluck('department'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('RFID_Card/Create', [
            'departments' => RFID_Card::distinct()->pluck('department'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'uid' => 'required|integer',
            'deviceId' => 'required|integer',
            'studName' => 'required|string',
            'department' => 'required|string',
            'program' => 'required|string',
            'yearLevel' => 'required|string',
        ]);

        RFID_Card::create($request->all());

        return redirect()->route('rfid-card.index')->with('success', 'RFID Card Created');
    }

    public function edit(RFID_Card $rfidCard): Response
    {
        return Inertia::render('RFID_Card/Edit', [
            'card' => $rfidCard,
            'departments' => RFID_Card::distinct()->pluck('department'),
        ]);
    }

    public function update(Request $request, RFID_Card $rfidCard)
    {
        $request->validate([
            'uid' => 'required|integer',
            'deviceId' => 'required|integer',
            'studName' => 'required|string',
            'department' => 'required|string',
            'program' => 'required|string',
            'yearLevel' => 'required|string',
        ]);

        $rfidCard->update($request->all());

        return redirect()->route('rfid-card')->with('success', 'RFID Card Updated');
    }

    public function destroy(RFID_Card $rfidCard)
    {
        $rfidCard->delete();

        return redirect()->route('rfid-card')->with('success', 'RFID Card Deleted');
    }
}
