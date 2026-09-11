<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\ExportJob;
use Exception;

class ProcessExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exportJobId;
    protected $exportClass;
    protected $filePath;
    protected $isPdf;

    /**
     * Create a new job instance.
     */
    public function __construct($exportJobId, $exportClass, $filePath, $isPdf = false)
    {
        $this->exportJobId = $exportJobId;
        $this->exportClass = $exportClass;
        $this->filePath = $filePath;
        $this->isPdf = $isPdf;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $job = ExportJob::find($this->exportJobId);
        
        if (!$job) {
            return;
        }

        try {
            if ($this->isPdf) {
                // If the exportClass is a DomPDF instance or has a method to save
                // Actually for PDF in ExportController they do $pdf->download().
                // To save, we can do $this->exportClass->save(storage_path('app/public/' . $this->filePath));
                // We'll pass the generated PDF binary content or instance
                file_put_contents(storage_path('app/public/' . $this->filePath), $this->exportClass->output());
            } else {
                // Excel
                Excel::store($this->exportClass, $this->filePath, 'public');
            }

            $job->update([
                'status' => 'completed',
                'file_path' => $this->filePath,
            ]);
        } catch (Exception $e) {
            $job->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
