<?php
// Function to fade edges of an image
function apply_edge_fade($inputPath, $outputPath, $fadeSide = 'right') {
    $src = imagecreatefrompng($inputPath);
    $w = imagesx($src);
    $h = imagesy($src);
    
    $dst = imagecreatetruecolor($w, $h);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    
    $fadeWidth = 90;
    $fadeBottom = 80;
    
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgba = imagecolorat($src, $x, $y);
            $r = ($rgba >> 16) & 0xFF;
            $g = ($rgba >> 8) & 0xFF;
            $b = $rgba & 0xFF;
            $a = ($rgba >> 24) & 0x7F; // 0 = opaque, 127 = transparent
            
            // Calculate factor (0.0 to 1.0)
            $factor = 1.0;
            
            // Side fade
            if ($fadeSide === 'right') {
                if ($x > ($w - $fadeWidth)) {
                    $dist = $w - $x;
                    $factor *= ($dist / $fadeWidth);
                }
            } elseif ($fadeSide === 'left') {
                if ($x < $fadeWidth) {
                    $dist = $x;
                    $factor *= ($dist / $fadeWidth);
                }
            }
            
            // Bottom fade
            if ($y > ($h - $fadeBottom)) {
                $distY = $h - $y;
                $factor *= ($distY / $fadeBottom);
            }
            
            // Convert factor to alpha
            $newA = 127 - (int)((127 - $a) * $factor);
            if ($newA > 127) $newA = 127;
            if ($newA < 0) $newA = 0;
            
            $col = imagecolorallocatealpha($dst, $r, $g, $b, $newA);
            imagesetpixel($dst, $x, $y, $col);
        }
    }
    
    imagepng($dst, $outputPath);
    imagedestroy($src);
    imagedestroy($dst);
    echo "Faded $fadeSide saved to $outputPath\n";
}

apply_edge_fade('themes/freynix/img/hero_lord_knight_banner.png', 'themes/freynix/img/hero_lord_knight_faded.png', 'right');
apply_edge_fade('themes/freynix/img/hero_high_priest_banner.png', 'themes/freynix/img/hero_high_priest_faded.png', 'left');

