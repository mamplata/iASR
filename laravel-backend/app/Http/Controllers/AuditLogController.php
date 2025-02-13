<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use Inertia\Inertia;

class AuditLogController extends Controller
{

    public function index(Request $request)
    {
        $query = AuditLog::query();

        // Filtering by action
        if ($request->has('action') && !empty($request->action)) {
            $query->where('action', $request->action);
        }

        // Filtering by user
        if ($request->has('user') && !empty($request->user)) {
            $query->where('user', $request->user);
        }

        return Inertia::render('Audit_Logs/Index', [
            'auditLogs' => $query->paginate(5),
            'filters' => $request->only(['action', 'user']),
        ]);
    }
}
