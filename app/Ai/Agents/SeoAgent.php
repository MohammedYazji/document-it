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

class SeoAgent implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are an expert SEO content writer. Write in a clear, engaging style.';
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
            'title' => $schema->string('SEO title')->max(60),
            'description' => $schema->string('Meta description')->max(160),
            'keywords' => $schema->string('Comma-separated SEO keywords')->max(255),
            'summary' => $schema->string('Brief post excerpt')->max(200),
        ];
    }
}
