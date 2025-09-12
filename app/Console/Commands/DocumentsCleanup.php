<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use App\Models\DocumentLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DocumentsCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * --days: how old (in days) the rejected documents must be to be deleted (default 30)
     * --force: skip interactive confirmation (useful in CI / cron)
     */
    protected $signature = 'documents:cleanup {--days=30} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete rejected documents older than N days (default 30) and remove files from storage';

    public function handle()
    {
        $days = (int) $this->option('days');
        $force = $this->option('force');

        $threshold = now()->subDays($days);
        $this->info("Searching rejected documents older than {$days} days (before {$threshold->toDateTimeString()})...");

        $query = Document::where('status', 'rejected')
                         ->where('updated_at', '<', $threshold);

        $count = $query->count();

        if ($count === 0) {
            $this->info('No rejected documents found that are older than the threshold.');
            return 0;
        }

        $this->info("Found {$count} document(s) to delete.");

        if (!$force) {
            if (!$this->confirm('Do you really want to delete these documents?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $deleted = 0;

        foreach ($query->cursor() as $doc) {
            try {
                $path = $doc->filename; // storage path

                if ($path && Storage::exists($path)) {
                    Storage::delete($path);
                    $this->info("Deleted file: {$path}");
                } else {
                    $this->warn("File not found on disk or filename empty for document id {$doc->id}");
                }

                // Try logging the deletion
                try {
                    DocumentLog::create([
                        'document_id' => $doc->id,
                        'action' => 'auto-delete',
                        'performed_by' => null, // system
                    ]);
                } catch (\Throwable $e) {
                    Log::warning("Could not create DocumentLog for doc {$doc->id}: {$e->getMessage()}");
                }

                $doc->delete();
                $deleted++;
            } catch (\Throwable $e) {
                Log::error("Failed to delete document id {$doc->id}: {$e->getMessage()}");
                $this->error("Failed to delete document id {$doc->id} — see log for details.");
            }
        }

        $this->info("Cleanup finished. Deleted {$deleted} document(s).");
        return 0;
    }
}
