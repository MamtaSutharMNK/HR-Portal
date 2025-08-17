<?php 
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IssueCategory;
use App\Models\IssueType;

class IssueCategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            //  Admin 
            1 => [
                'Facility & Infrastructure' => [
                    'AC/Lighting/Fan Not Working',
                    'Electrical Issue',
                    'Furniture Request/Repair',
                    'Meeting Room Booking',
                    'Facility Cleaning Request',
                    'Drinking Water Supply Issue',
                    'Pest Control Request',
                ],
                'Stationery & Supplies' => [
                    'New Stationery Request',
                    'Office Supplies Refill',
                    'Printer Paper/Ink Request',
                    'Pantry Item Request',
                ],
                'Access & ID Cards' => [
                    'New ID Card Request',
                    'Lost ID Card - Reissue Request',
                    'Access Card Issue',
                    'Access to Restricted Area',
                ],
                'Workstation & Seating' => [
                    'Seating Allocation/Change Request',
                    'Desk Repair Request',
                    'New Workstation Setup',
                    'Monitor/Keyboard/Chair Request',
                ],
                'Housekeeping & Hygiene' => [
                    'Restroom Cleaning Issue',
                    'Deep Cleaning Request',
                    'Sanitization Request',
                    'Dustbin Not Cleared',
                ],
                'Visitor Management' => [
                    'Visitor Entry Approval',
                    'Visitor Pass Request',
                    'Guest Reception Assistance',
                ],
                'Others / Miscellaneous' => [
                    'General Admin Query',
                    'Feedback/Suggestions',
                    'Escalation Request',
                ],
            ],

            // HR 
            2 => [
                'Leave & Attendance' => [
                    'Unable to Apply Leave',
                    'Leave Balance Incorrect',
                    'Leave Request Not Approved',
                    'Attendance Regularization Request',
                ],
                'Payroll & Salary' => [
                    'Salary Not Credited',
                    'Incorrect Salary Payment',
                    'Payslip Request',
                    'Income Tax / Form 16 Query',
                ],
                'Recruitment & Onboarding' => [
                    'Document Submission Issue',
                    'Onboarding Delay',
                    'Interview Feedback Pending',
                ],
                'Policy Clarification' => [
                    'Leave Policy Clarification',
                    'Work From Home Policy',
                    'HR Policy General Query',
                ],
                'Employee Exit & F&F' => [
                    'Resignation Process',
                    'Full & Final Settlement Delay',
                    'Exit Interview Schedule',
                ],
            ],
            // IT
            3 => [
                'Hardware Issues' => [
                    'Laptop Not Working',
                    'Monitor Not Turning On',
                    'Keyboard/Mouse Issue',
                    'System Heating Problem',
                ],
                'Software & Access' => [
                    'Email Access Request',
                    'Software Installation',
                    'VPN Access Issue',
                    'Application Login Failure',
                ],
                'Network & Connectivity' => [
                    'No Internet Connection',
                    'WiFi Not Working',
                    'Slow Network Speed',
                ],
                'Asset Management' => [
                    'IT Asset Allocation',
                    'Asset Return',
                    'New Hardware Request',
                ],
                'Data & Backup' => [
                    'Data Recovery Request',
                    'Cloud Backup Failed',
                    'Drive Access Issue',
                ],
                'Printer & Scanner Support' => [
                    'Printer Not Responding',
                    'Scanner Error',
                    'Paper Jam Issue',
                ],
            ],
        ];

        // 🔁 Loop through departments and create categories/types
        foreach ($data as $departmentId => $categories) {
            foreach ($categories as $categoryName => $types) {
                $category = IssueCategory::create([
                    'department_id' => $departmentId,
                    'name' => $categoryName,
                ]);

                foreach ($types as $typeName) {
                    IssueType::create([
                        'issue_category_id' => $category->id,
                        'name' => $typeName,
                    ]);
                }
            }
        }
    }
}