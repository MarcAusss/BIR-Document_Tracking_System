<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example documents
        $documents = [
            [
                'taxpayer_name' => 'John Doe',
                'taxable_period' => '2023',
                'docket_owner' => 'Jane Smith',
                'document_type' => 'Tax Return',
                'status' => 'pending',
                'RDO' => 'RDO-001',
                'date_received' => now()->subDays(10),
            ],
            [
                'taxpayer_name' => 'Alice Johnson',
                'taxable_period' => '2022',
                'docket_owner' => 'Bob Brown',
                'document_type' => 'Audit Report',
                'status' => 'draft',
                'RDO' => 'RDO-002',
                'date_received' => now()->subDays(20),
            ],
            [
                'taxpayer_name' => 'Charlie Green',
                'taxable_period' => '2021',
                'docket_owner' => 'Diana White',
                'document_type' => 'Notice of Assessment',
                'status' => 'finalized',
                'RDO' => 'RDO-003',
                'date_received' => now()->subDays(30),
            ],
        ];

        // Generate additional documents dynamically
        for ($i = 4; $i <= 20; $i++) {
            $documents[] = [
                'taxpayer_name' => "Taxpayer $i",
                'taxable_period' => '202' . rand(0, 3),
                'docket_owner' => "Owner $i",
                'document_type' => ['Tax Return', 'Audit Report', 'Notice of Assessment'][array_rand(['Tax Return', 'Audit Report', 'Notice of Assessment'])],
                'status' => ['pending', 'draft', 'finalized'][array_rand(['pending', 'draft', 'finalized'])],
                'RDO' => 'RDO-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'date_received' => now()->subDays(rand(1, 60)),
            ];
        }

        // Insert documents into the database
        DB::table('documents')->insert($documents);
    }
}
