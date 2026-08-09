<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

class SearchAgent implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are a search query expander. Given a search term, generate related synonyms and keywords to improve search results. Return JSON only.';
    }

    public function messages(): iterable
    {
        return [];
    }

    public function tools(): iterable
    {
        return [];
    }

    public function provider(): Lab|array|string
    {
        return Lab::Gemini;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'keywords' => $schema->string('Comma-separated related keywords including the original term')->max(500),
        ];
    }
}
