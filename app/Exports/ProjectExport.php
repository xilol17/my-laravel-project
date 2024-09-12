<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectExport implements FromCollection, WithHeadings
{
    protected $projects;

    public function __construct($projects)
    {
        $this->projects = $projects;
    }

    public function collection()
    {
        // Return the full dataset for each project (customize this based on your fields)
        return $this->projects->map(function ($project) {
            $products = json_decode($project->products, true); // Decode JSON string to array

            return [
                'Project Name' => $project->name,
                'Visit Date' => $project->visitDate ? \Carbon\Carbon::parse($project->visitDate)->format('d-m-Y') : null,
                'Discussion Start Date' => $project->disStartDate ? \Carbon\Carbon::parse($project->disStartDate)->format('d-m-Y') : null,
                'Last Update Date' => $project->lastUpdateDate ? \Carbon\Carbon::parse($project->lastUpdateDate)->format('d-m-Y') : null,
                'turnKey' => $project->turnKey,
                'revenue' => $project->revenue,
                'BDM/PM' => $project->BDMPM,
                'Status' => $project->status,
                'Region' => $project->region,
                'Customer Name' => $project->customerName,
                'Sales Name' => $project->salesName,
                'Products' => is_array($products) ? implode(',', $products) : $products, // Format array to comma-separated string
                'SI' => $project->SI,
                'Win Rate' => $project->winRate . '%',
                'Start Date' => $project->created_at->format('d-m-Y'),
                'SO' => $project->SO,
            ];
        });
    }


    public function headings(): array
    {
        // Customize the headings to match the fields
        return [
            'Project Name',
            'ASSC Visit Date',
            'Discussion Start Date',
            'Last Update Date',
            'Turn Key',
            'Revenue $USD',
            'BDM/PM',
            'Status',
            'Region',
            'Customer',
            'Sales Name',
            'Products',
            'SI',
            'Win Rate',
            'Start Date',
            'SO Number'
        ];
    }
}
