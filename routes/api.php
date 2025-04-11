<?php

use App\Http\Controllers\OpenAIController;
use Illuminate\Support\Facades\Route;

Route::post('/analyze-document', [OpenAIController::class, 'analyzeDocument']);
