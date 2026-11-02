<?php
/**
 * HTML Sanitizer for FluxCP CMS content
 */
class Flux_Sanitizer {
    /**
     * Sanitizes rich text HTML content
     */
    public static function sanitizeHtml($html) {
        if (empty($html)) return '';

        // Strip dangerous tags completely
        $dangerousTags = array('script', 'style', 'link', 'object', 'embed', 'applet', 'meta', 'base');
        foreach ($dangerousTags as $tag) {
            $html = preg_replace('#<'.$tag.'[^>]*>.*?</'.$tag.'>#is', '', $html);
            $html = preg_replace('#<'.$tag.'[^>]*/>#is', '', $html);
        }

        // Remove dangerous event attributes (onload, onclick, onerror, onmouseover, etc.)
        $html = preg_replace('/\s*on[a-z]+\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/i', '', $html);

        // Remove javascript: and data: pseudo-protocols in href and src
        $html = preg_replace('/\s*(href|src)\s*=\s*(["\'])\s*(javascript|vbscript|data):.*?\2/i', ' $1="#"', $html);

        return $html;
    }

    /**
     * Sanitizes slug strings (URL paths)
     */
    public static function sanitizeSlug($slug) {
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/[^a-z0-9_\-\/]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
}
?>

