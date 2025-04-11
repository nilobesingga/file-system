<?php

namespace App\Http\Controllers;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;
use OpenAI;
class OpenAIController extends Controller
{
    public function index()
    {
        return view('openai.index');
    }
    public function analyzeDocument(Request $request)
    {
        dd('test');
        $request->validate([
            'document' => 'required|file|mimes:pdf', // max 5MB
        ]);

        // Store uploaded file temporarily
        $file = $request->file('document');
        $path = $file->store('documents', 'public');
        // Extract text from PDF
        $parser = new Parser();
        $pdf = $parser->parseFile(public_path("storage/{$path}"));
        $text = $pdf->getText();

        // Optional: Truncate text if it's too long
        $text = substr($text, 0, 8000); // GPT-4 limit safety

        // Call OpenAI
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant that summarizes and analyzes documents.'],
                ['role' => 'user', 'content' => "Analyze this document:\n\n" . $text],
            ],
        ]);
        dd($response);
        $result = $response->choices[0]->message->content;
        // $analysis = $response['choices'][0]['message']['content'];
        // dd($text);
        return response()->json([
            'analysis' => $analysis,
            // 'analysis' => $text,
        ]);
    }
    public function show($id)
    {
        // Logic to show a specific OpenAI response
        return view('openai.show', ['id' => $id]);
    }
    public function edit($id)
    {
        // Logic to edit a specific OpenAI response
        return view('openai.edit', ['id' => $id]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'prompt' => 'required|string|max:255',
        ]);

        // Logic to update the OpenAI response
        return redirect()->route('openai.show', ['id' => $id])->with('success', 'Response updated successfully.');
    }
    public function destroy($id)
    {
        // Logic to delete a specific OpenAI response
        return redirect()->route('openai.index')->with('success', 'Response deleted successfully.');
    }
}
