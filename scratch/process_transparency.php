<?php
function make_white_transparent($inputPath, $outputPath) {
    $src = imagecreatefrompng($inputPath);
    $w = imagesx($src);
    $h = imagesy($src);
    
    // Create truecolor with alpha
    $dst = imagecreatetruecolor($w, $h);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    
    // Fill with transparent
    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefill($dst, 0, 0, $transparent);
    
    // Flood fill algorithm to find all connected background pixels from perimeter
    $visited = array_fill(0, $w, array_fill(0, $h, false));
    $queue = [];
    
    // Enqueue all perimeter pixels that are near white
    for ($x = 0; $x < $w; $x++) {
        $queue[] = [$x, 0];
        $queue[] = [$x, $h - 1];
    }
    for ($y = 0; $y < $h; $y++) {
        $queue[] = [0, $y];
        $queue[] = [$w - 1, $y];
    }
    
    // Process queue with BFS
    $head = 0;
    while ($head < count($queue)) {
        list($cx, $cy) = $queue[$head++];
        if ($visited[$cx][$cy]) continue;
        
        $rgba = imagecolorat($src, $cx, $cy);
        $r = ($rgba >> 16) & 0xFF;
        $g = ($rgba >> 8) & 0xFF;
        $b = $rgba & 0xFF;
        
        // Is it background? White threshold (e.g. all > 238)
        if ($r >= 238 && $g >= 238 && $b >= 238) {
            $visited[$cx][$cy] = true;
            
            // Add neighbors
            $neighbors = [
                [$cx + 1, $cy], [$cx - 1, $cy],
                [$cx, $cy + 1], [$cx, $cy - 1]
            ];
            foreach ($neighbors as $n) {
                $nx = $n[0];
                $ny = $n[1];
                if ($nx >= 0 && $nx < $w && $ny >= 0 && $ny < $h && !$visited[$nx][$ny]) {
                    $queue[] = [$nx, $ny];
                }
            }
        }
    }
    
    // Now render pixels into dst
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgba = imagecolorat($src, $x, $y);
            $r = ($rgba >> 16) & 0xFF;
            $g = ($rgba >> 8) & 0xFF;
            $b = $rgba & 0xFF;
            
            if ($visited[$x][$y]) {
                // Background pixel is 100% transparent
                imagesetpixel($dst, $x, $y, $transparent);
            } else {
                // Check if neighboring a visited pixel for anti-aliasing edge blend
                $isEdge = false;
                if ($x > 0 && $visited[$x-1][$y]) $isEdge = true;
                elseif ($x < $w-1 && $visited[$x+1][$y]) $isEdge = true;
                elseif ($y > 0 && $visited[$x][$y-1]) $isEdge = true;
                elseif ($y < $h-1 && $visited[$x][$y+1]) $isEdge = true;
                
                if ($isEdge && $r > 220 && $g > 220 && $b > 220) {
                    // Soften boundary edge
                    $alpha = (int)((($r + $g + $b) / 3 - 220) / 35 * 110);
                    if ($alpha > 120) $alpha = 120;
                    $col = imagecolorallocatealpha($dst, $r, $g, $b, $alpha);
                    imagesetpixel($dst, $x, $y, $col);
                } else {
                    $col = imagecolorallocatealpha($dst, $r, $g, $b, 0);
                    imagesetpixel($dst, $x, $y, $col);
                }
            }
        }
    }
    
    imagepng($dst, $outputPath);
    imagedestroy($src);
    imagedestroy($dst);
    echo "Saved transparent render to $outputPath\n";
}

make_white_transparent('scratch/hero_lord_knight_trans.png', 'themes/freynix/img/hero_lord_knight_clean.png');
make_white_transparent('scratch/hero_high_priest_trans.png', 'themes/freynix/img/hero_high_priest_clean.png');

