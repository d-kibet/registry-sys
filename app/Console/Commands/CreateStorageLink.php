<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:link-manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually create storage link without using symlink or exec functions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $target = storage_path('app/public');
        $link = public_path('storage');

        // Check if target directory exists
        if (!File::isDirectory($target)) {
            File::makeDirectory($target, 0755, true);
            $this->info("Created storage directory: {$target}");
        }

        // Check if link already exists
        if (File::exists($link)) {
            if (is_link($link)) {
                $this->info('Storage link already exists!');
                return 0;
            }

            // If it's a directory, check if it's the right one
            if (File::isDirectory($link)) {
                $this->warn('A storage directory already exists at public/storage');
                $this->info('Skipping link creation.');
                return 0;
            }

            $this->error('A file named "storage" already exists in public directory!');
            return 1;
        }

        // Try to create symbolic link
        try {
            if (function_exists('symlink')) {
                if (@symlink($target, $link)) {
                    $this->info('Storage link created successfully using symlink()!');
                    return 0;
                }
            }
        } catch (\Exception $e) {
            $this->warn('symlink() failed: ' . $e->getMessage());
        }

        // Try exec as fallback
        if (function_exists('exec')) {
            try {
                $command = 'ln -s ' . escapeshellarg($target) . ' ' . escapeshellarg($link);
                @exec($command, $output, $returnCode);

                if ($returnCode === 0 && File::exists($link)) {
                    $this->info('Storage link created successfully using exec()!');
                    return 0;
                }
            } catch (\Exception $e) {
                $this->warn('exec() failed: ' . $e->getMessage());
            }
        }

        // If both methods failed, provide instructions
        $this->error('Unable to create symbolic link automatically.');
        $this->newLine();
        $this->warn('Both symlink() and exec() functions are disabled or failed.');
        $this->newLine();
        $this->info('SOLUTION 1: Create symbolic link manually via SSH/Terminal:');
        $this->line('  ln -s ' . $target . ' ' . $link);
        $this->newLine();
        $this->info('SOLUTION 2: Use cPanel File Manager:');
        $this->line('  1. Go to File Manager');
        $this->line('  2. Navigate to public_html/public (or your public folder)');
        $this->line('  3. Create a symbolic link named "storage" pointing to "../storage/app/public"');
        $this->newLine();
        $this->info('SOLUTION 3: Files are served via routes (already configured)');
        $this->line('  Your application is configured to serve files without symlinks!');
        $this->line('  Files are accessible via: /storage-file/{path}');

        return 1;
    }
}
