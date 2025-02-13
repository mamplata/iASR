<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use Carbon\Carbon;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $actions = ['ADD', 'UPDATE', 'DELETE', 'LOGIN'];
        $users = ['admin', 'moderator', 'user1', 'user2', 'guest'];

        $logs = [];

        for ($i = 1; $i <= 10; $i++) {
            $action = $actions[array_rand($actions)];
            $user = $users[array_rand($users)];
            $timestamp = Carbon::now()->subMinutes(rand(1, 1000));

            $change = match ($action) {
                'ADD' => json_encode(['added' => ['field' . $i => 'value' . $i, 'extra' => 'data' . $i]]),
                'UPDATE' => json_encode(['before' => ['status' => 'Pending'], 'after' => ['status' => 'Approved']]),
                'DELETE' => json_encode(['deleted' => ['record' . $i => 'data' . $i]]),
                'LOGIN' => json_encode(['status' => 'Success']),
                default => json_encode([])
            };

            $content = match ($action) {
                'ADD' => json_encode(['message' => 'New record added', 'id' => $i, 'status' => 'Active']),
                'UPDATE' => json_encode(['message' => 'Record updated', 'id' => $i, 'status' => 'Updated']),
                'DELETE' => json_encode(['message' => 'Record deleted', 'id' => $i]),
                'LOGIN' => json_encode(['message' => 'User logged in', 'username' => $user]),
                default => json_encode([])
            };

            $logs[] = [
                'action' => $action,
                'change' => $change,
                'content' => $content,
                'user' => $user,
                'timestamp' => $timestamp,
            ];
        }

        AuditLog::insert($logs);
    }
}
