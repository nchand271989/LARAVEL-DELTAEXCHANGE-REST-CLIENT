<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnnouncementsHelper
{
    public static function handleAnnouncements($data)
    {
        // Validate response structure
        if (!isset($data['type']) || !isset($data['event']) || !isset($data['timestamp'])) {
            Log::error("Invalid Announcement response", ['data' => $data]);
            return;
        }

        // Extract event details
        $event = $data['event'];
        $timestamp = $data['timestamp'];
        $maintenanceFinishTime = $data['maintenance_finish_time'] ?? null;

        // Insert into the database
        DB::table('announcements')->insert([
            'event' => $event,
            'maintenance_finish_time' => $maintenanceFinishTime,
            'timestamp' => $timestamp,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Stored Announcement: Event - {$event}, Maintenance Finish Time - {$maintenanceFinishTime}");
    }
    
}
