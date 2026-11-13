<?php
$source = 'c:/xampp/htdocs/fluxcp-freynix/themes/dominion/img/dominion-logo.png';
$im = imagecreatefromjpeg($source);
$w = imagesx($im);
$h = imagesy($im);

$out = imagecreatetruecolor($w, $h);
imagealphablending($out, false);
imagesavealpha($out, true);

// Mask array: 0 = unvisited, 1 = background, 2 = border/feather
$mask = array_fill(0, $h, array_fill(0, $w, 0));
$queue = new SplQueue();

// Seed all boundary pixels
for ($x = 0; $x < $w; $x++) {
    $queue->enqueue(array($x, 0));
    $queue->enqueue(array($x, $h - 1));
    $mask[0][$x] = 1;
    $mask[$h - 1][$x] = 1;
}
for ($y = 0; $y < $h; $y++) {
    $queue->enqueue(array(0, $y));
    $queue->enqueue(array($w - 1, $y));
    $mask[$y][0] = 1;
    $mask[$y][$w - 1] = 1;
}

// Flood fill outward background
// The background is dark (< 55 in all channels or max(r,g,b) < 65)
while (!$queue->isEmpty()) {
    list($cx, $cy) = $queue->dequeue();
    $dirs = array(array(-1, 0), array(1, 0), array(0, -1), array(0, 1));
    foreach ($dirs as $d) {
        $nx = $cx + $d[0];
        $ny = $cy + $d[1];
        if ($nx >= 0 && $nx < $w && $ny >= 0 && $ny < $h && $mask[$ny][$nx] === 0) {
            $rgb = imagecolorat($im, $nx, $ny);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            
            // Background is dark vignette: brightness threshold
            $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);
            $maxC = max($r, $g, $b);
            
            // Check if this pixel is dark background
            if ($brightness < 55 && $maxC < 75) {
                $mask[$ny][$nx] = 1;
                $queue->enqueue(array($nx, $ny));
            }
        }
    }
}

// Render with smooth alpha feathering
for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < $w; $x++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        if ($mask[$y][$x] === 1) {
            // Full transparent
            $col = imagecolorallocatealpha($out, 0, 0, 0, 127);
        } else {
            // Check neighbor distance to background for anti-aliased edge
            $bgNeighbors = 0;
            for ($dy = -2; $dy <= 2; $dy++) {
                for ($dx = -2; $dx <= 2; $dx++) {
                    $px = $x + $dx;
                    $py = $y + $dy;
                    if ($px >= 0 && $px < $w && $py >= 0 && $py < $h) {
                        if ($mask[$py][$px] === 1) {
                            $bgNeighbors++;
                        }
                    }
                }
            }

            if ($bgNeighbors > 0) {
                // Feather edge: 25 neighbors max in 5x5
                $alphaRatio = min(1.0, $bgNeighbors / 20.0);
                $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);
                // Lower alpha for brighter glow, higher alpha for dark border
                $alphaVal = (int)round(127 * $alphaRatio * max(0.2, (80 - min(80, $brightness)) / 80));
                $col = imagecolorallocatealpha($out, $r, $g, $b, min(127, max(0, $alphaVal)));
            } else {
                $col = imagecolorallocatealpha($out, $r, $g, $b, 0);
            }
        }
        imagesetpixel($out, $x, $y, $col);
    }
}

$dest = 'c:/xampp/htdocs/fluxcp-freynix/themes/dominion/img/dominion-logo.png';
imagepng($out, $dest, 9);
echo "Successfully converted dominion-logo.png to true 32-bit transparent PNG!\n";

