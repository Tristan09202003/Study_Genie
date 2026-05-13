<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index']);
Route::get('/contact', [LandingController::class, 'contact']);
Route::get('/features', [LandingController::class, 'features']);
Route::get('/features/ai-study-materials', [LandingController::class, 'aiStudyMaterials']);
Route::get('/features/personalized-quizzes', [LandingController::class, 'personalizedQuizzes']);
Route::get('/features/smart-notes', [LandingController::class, 'smartNotes']);
Route::get('/features/flashcard-deck', [LandingController::class, 'flashcardDeck']);
Route::get('/features/mock-exams', [LandingController::class, 'mockExams']);
Route::get('/features/tutor-mode', [LandingController::class, 'tutorMode']);
Route::get('/features/study-time-reminders', [LandingController::class, 'studyTimeReminders']);