<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\SchoolOrganization;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response; 
use Dompdf\Dompdf;
use Dompdf\Options;
class ReportController extends Controller
{
    public function store(Request $request)
{

    $request->validate([
        'from_organization_id' => 'required',
        'reported_user_id' => 'required|exists:users,id',
        'reporter_id' => 'required|exists:users,id',
        'reasons' => 'nullable|array',
        'other' => 'nullable|string',
    ]);
    try {
    $report = Report::create([
        'from_organization_id' => $request->input('from_organization_id'),
        'reported_user_id' => $request->input('reported_user_id'),
        'reporter_id' => $request->input('reporter_id'),
        'reasons' => implode(', ', $request->input('reasons')),
        'other' => $request->input('other'),
    ]);
} catch (\Exception $e) {
    // Log the error
    Log::error($e->getMessage());

    // Handle the error gracefully
    // You can return a response indicating the failure to save the report
}

    return redirect()->back()->with('success', 'Report submitted successfully.');
}


public function exportReportsPDF($orgId)
{
    $organization = SchoolOrganization::findOrFail($orgId);
    $reports = Report::where('from_organization_id', $organization->id)
        ->with(['reportedUser', 'reporter'])
        ->get();

    // Load the view for the PDF
    $html = view('reports.pdf', compact('organization', 'reports'))->render();

    // Create Dompdf instance
    $dompdf = new Dompdf();

    // Load HTML content
    $dompdf->loadHtml($html);

    // Set options
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $dompdf->setOptions($options);

    // Render PDF
    $dompdf->render();

    // Set filename using the school organization name plus the current datetime
    $filename = $organization->orgname . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

    // Output PDF to browser
    return $dompdf->stream($filename);
}



public function exportReportsCSV($orgId)
{
    $organization = SchoolOrganization::findOrFail($orgId);
    $reports = Report::where('from_organization_id', $organization->id)
        ->with(['reportedUser', 'reporter'])
        ->get();

    // Define CSV headers
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=reports.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    // Define CSV data
    $callback = function () use ($reports) {
        $file = fopen('php://output', 'w');

        // CSV header row
        fputcsv($file, [
            'ID',
            'Reported User ID',
            'Reported User Name',
            'Reporter ID',
            'Reporter Name',
            'Reasons',
            'Other',
            'Reported On'
        ]);

        // CSV data rows
        foreach ($reports as $report) {
            fputcsv($file, [
                $report->id,
                $report->reportedUser->studentid,
                $report->reportedUser->firstname . ' ' . $report->reportedUser->middlename . ' ' . $report->reportedUser->lastname,
                $report->reporter->studentid,
                $report->reporter->firstname . ' ' . $report->reporter->middlename . ' ' . $report->reporter->lastname,
                $report->reasons,
                $report->other,
                $report->created_at
            ]);
        }

        fclose($file);
    };

    // Return CSV file as response
    return Response::stream($callback, 200, $headers);
}
}
