<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class ProductDescriptionAgent implements Agent, Conversational
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a professional e-commerce copywriter. '
            . 'Generate compelling, SEO-friendly product descriptions for an online store. '
            . 'Keep descriptions concise (2-3 sentences), highlight key features and benefits, '
            . 'and use persuasive language that drives conversions. '
            . 'Return only the description text, no extra formatting.';
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }
}
