<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;

class GeneratePwaIcons extends Command
{
    protected $signature = 'pwa:generate-icons';
    protected $description = 'Generate PWA icons';

    public function handle()
    {
        $sizes = [192, 512];

        foreach ($sizes as $size) {
            $this->info("Generating {$size}x{$size} icon...");

            // Create a new image with gradient-like effect
            $img = Image::canvas($size, $size);

            // Create gradient background (UDA Yellow to Green)
            for ($y = 0; $y < $size; $y++) {
                $ratio = $y / $size;
                // Interpolate between yellow (#F7C821) and green (#179847)
                $r = (int)(247 * (1 - $ratio) + 23 * $ratio);
                $g = (int)(200 * (1 - $ratio) + 152 * $ratio);
                $b = (int)(33 * (1 - $ratio) + 71 * $ratio);

                $color = sprintf('#%02X%02X%02X', $r, $g, $b);
                $img->rectangle(0, $y, $size, $y + 1, function ($draw) use ($color) {
                    $draw->background($color);
                });
            }

            // Add white circle
            $centerX = $size / 2;
            $centerY = $size / 2;
            $radius = $size * 0.35;

            $img->circle($radius * 2, $centerX, $centerY, function ($draw) {
                $draw->background('#FFFFFF');
                $draw->border(3, '#179847');
            });

            // Save
            $filename = "icon-{$size}x{$size}.png";
            $img->save(public_path($filename));

            $this->info("Created {$filename}");
        }

        $this->info('PWA icons generated successfully!');
        return 0;
    }
}
