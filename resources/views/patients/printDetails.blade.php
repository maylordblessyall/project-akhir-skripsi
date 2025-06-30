<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details - Print</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        .container {
            width: 100%;
            max-width: 800px; 
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2, h3 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        h1 { 
            font-size: 24pt; 
            border-top: 2px solid #4CAF50;
            border-bottom: 2px solid #4CAF50;
            padding: 10px 0;
        }

        h2, h3 {
            font-size: 18pt;
            color: #0056b3;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px; 
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        }

        .card-header {
            background-color: #e9f5f9; 
            color: #333; 
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 15px;
        }

        .card-body p {
            margin-bottom: 5px; 
        }

        .card-body strong {
            display: inline-block;
            width: 150px; 
            font-weight: bold;
        }

        .list-group {
            padding-left: 0;
            margin-bottom: 0;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px; 
        }

      
        @media print {
            body {
                font-size: 11pt; 
                -webkit-print-color-adjust: exact; 
            }

           
            .no-print {
                display: none;
            }

            
            .list-group-item {
                page-break-inside: avoid;
            }

            .medical-records-header {
                page-break-after: avoid; 
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>RUMAH SAKIT ADVENT</h1>
        <h2>Patient Details</h2>

        <div class="card">
            <div class="card-header"> <strong>Patient Information</strong></div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $patient->id }}</p>
                <p><strong>Name:</strong> {{ $patient->full_name }}</p>
                <p><strong>NIK:</strong> {{ $patient->nik }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth }}</p>
                <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                <p><strong>Address:</strong> {{ $patient->address }}</p>
                <p><strong>Phone Number:</strong> {{ $patient->phone_number }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
            </div>
        </div>

        <h3 class="medical-records-header">Medical Records</h3>

        @if ($medicalRecords->isEmpty())
            <p>No medical records found for this patient.</p>
        @else
            <ul class="list-group" id="medical-records-list"> 
                @foreach ($medicalRecords as $record)
                <li class="list-group-item">
                    <p><strong>Date Recorded:</strong> {{ $record->date_recorded }}</p>
                    <p><strong>ID Appointment:</strong> {{ $record->id_appointment }}</p>
                    <p><strong>Subjective:</strong> {{ $record->subjective }}</p>
                    <p><strong>Objective:</strong> {{ $record->objective }}</p>
                    <p><strong>Assessment:</strong> {{ $record->assessment }}</p>
                    <p><strong>Plan:</strong> {{ $record->plan }}</p>
                </li>
                @endforeach
            </ul>
        @endif
    </div>

</body>
</html>