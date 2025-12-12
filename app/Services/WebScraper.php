<?php

namespace App\Services;

use App\DataTransferObjects\PageMetadata;
use Illuminate\Support\Facades\Http;

class WebScraper
{
    /**
     * Extract page metadata (title, description) in a single HTTP request
     */
    public function extractMetadata(string $url): PageMetadata
    {
        $metadata = [
            'title' => null,
            'description' => null,
        ];

        try {

            $response = Http::timeout(5)
                ->withOptions(['stream' => true])
                ->get($url);

            $body = $response->getBody();
            $buffer = '';

            while (! $body->eof()) {
                $buffer .= $body->read(1024);

                // Extract title if not found yet
                if ($metadata['title'] === null && stripos($buffer, '</title>') !== false) {
                    if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $buffer, $matches)) {
                        $metadata['title'] = trim(html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    }
                }

                // Extract og:description if not found yet
                if ($metadata['description'] === null && stripos($buffer, 'og:description') !== false) {
                    if (preg_match('/<meta[^>]*property=["\']og:description["\'][^>]*content=["\'](.*?)["\']/is', $buffer, $matches)) {
                        $metadata['description'] = trim(html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    }
                }

                // Stop if everything found or reached </head>
                if (($metadata['title'] !== null && $metadata['description'] !== null) || stripos($buffer, '</head>') !== false) {
                    break;
                }

                // Safety limit: stop after 20KB (head is usually smaller)
                if (strlen($buffer) > 20480) {
                    break;
                }
            }

            $body->close();

            // Final extraction attempt if we haven't found everything
            if ($metadata['title'] === null && preg_match('/<title[^>]*>(.*?)<\/title>/is', $buffer, $matches)) {
                $metadata['title'] = trim(html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }

            if ($metadata['description'] === null && preg_match('/<meta[^>]*property=["\']og:description["\'][^>]*content=["\'](.*?)["\']/is', $buffer, $matches)) {
                $metadata['description'] = trim(html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            }

        } catch (\Exception $e) {
            report($e);
        }

        return new PageMetadata(
            title: $metadata['title'],
            description: $metadata['description'],
        );
    }
}
