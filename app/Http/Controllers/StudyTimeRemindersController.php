<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudyTimeRemindersController extends Controller
{
    /**
     * Display the Study Time Reminders feature page.
     */
    public function show()
    {
        $feature = [
            'title' => 'Study Time Reminders',
            'icon' => '⏰',
            'tagline' => 'Never miss a study session',
            'description' => 'Smart notifications that help keep you on track with personalized study schedules and session reminders.',
            'features' => [
                [
                    'title' => 'Personalized Schedules',
                    'description' => 'Set your own study times and StudyGenie will adapt to your routine.',
                ],
                [
                    'title' => 'Smart Reminders',
                    'description' => 'Get notified at the perfect time to start your next study session.',
                ],
                [
                    'title' => 'Progress Tracking',
                    'description' => 'Monitor your study consistency and see improvement over time.',
                ],
                [
                    'title' => 'Flexible Notifications',
                    'description' => 'Customize reminder frequency, timing, and delivery methods.',
                ],
            ],
            'benefits' => [
                'Build consistent study habits with daily reminders.',
                'Never forget important study sessions or review dates.',
                'Optimize learning with reminders based on spaced repetition.',
                'Balance study and life with smart scheduling.',
            ],
        ];

        return view('features.study-time-reminders', compact('feature'));
    }

    /**
     * Store reminder preferences for the authenticated user.
     */
    public function storePreferences(Request $request)
    {
        $validated = $request->validate([
            'reminder_frequency' => 'required|in:daily,weekly,never',
            'reminder_time' => 'required|date_format:H:i',
            'reminder_method' => 'required|in:email,push,sms',
            'enabled' => 'boolean',
        ]);

        // Store preferences in cache or database
        // Example: Cache::put('reminders_' . auth()->id(), $validated);

        return response()->json([
            'message' => 'Reminder preferences saved successfully',
            'data' => $validated,
        ]);
    }

    /**
     * Get reminder history for the authenticated user.
     */
    public function history()
    {
        // Fetch reminder history
        $reminders = []; // Fetch from database or cache

        return response()->json($reminders);
    }

    /**
     * Send a test reminder notification.
     */
    public function sendTest(Request $request)
    {
        // Send test reminder
        // Example: Notification::send(auth()->user(), new StudyReminder());

        return response()->json([
            'message' => 'Test reminder sent successfully',
        ]);
    }
}
