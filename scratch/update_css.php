<?php
$css = file_get_contents('themes/freynix/css/freynix.css');

// Read the new styles we wrote
$newStyles = file_get_contents('scratch/new_styles.css');

// Find where "/* Monster Showcase Grid */" starts
$pos = strpos($css, '/* Monster Showcase Grid */');
if ($pos !== false) {
    // Cut off everything from /* Monster Showcase Grid */ to the end
    $css = substr($css, 0, $pos);
    // Append the new combined styles (Hero additions + 2-Column World Boss stage)
    $css .= $newStyles;
    file_put_contents('themes/freynix/css/freynix.css', $css);
    echo "Successfully updated themes/freynix/css/freynix.css!\n";
} else {
    echo "Could not find '/* Monster Showcase Grid */' in CSS!\n";
}

