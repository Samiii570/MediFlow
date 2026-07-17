<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription - {{ $prescription->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px; }
        .header { border-bottom: 3px solid #0d9488; padding-bottom: 20px; margin-bottom: 30px; }
        .hospital-name { font-size: 28px; font-weight: bold; color: #0d9488; }
        .hospital-address { color: #666; font-size: 14px; margin-top: 5px; }
        .prescription-title { text-align: center; font-size: 22px; font-weight: bold; color: #0d9488; margin: 25px 0; text-transform: uppercase; letter-spacing: 2px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-box { background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid #0d9488; }
        .info-label { font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 5px; }
        .info-value { font-size: 16px; font-weight: 600; color: #1e293b; }
        .section-title { font-size: 16px; font-weight: bold; color: #0d9488; margin: 25px 0 15px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0; }
        .diagnosis { background: #f0fdfa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #0d9488; color: white; padding: 12px; text-align: left; font-size: 14px; }
        td { padding: 12px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        tr:nth-child(even) { background: #f8fafc; }
        .notes { background: #fffbeb; padding: 15px; border-radius: 8px; margin-top: 20px; border-left: 4px solid #f59e0b; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; }
        .signature-box { text-align: center; }
        .signature-line { width: 200px; border-top: 1px solid #333; margin-top: 60px; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="hospital-name">MediFlow Hospital</div>
            <div class="hospital-address">123 Healthcare Avenue, Medical District, MD 12345 | Phone: (555) 123-4567</div>
        </div>

        <div class="prescription-title">Prescription</div>

        @php
            $patient = $prescription->appointment->patient;
            $doctor = $prescription->appointment->doctor;
        @endphp

        <div class="info-grid">
            <div class="info-box">
                <div class="info-label">Patient Name</div>
                <div class="info-value">{{ $patient->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Blood Group / Gender</div>
                <div class="info-value">{{ $patient->blood_group ?? 'N/A' }} / {{ ucfirst($patient->gender ?? 'N/A') }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Doctor</div>
                <div class="info-value">Dr. {{ $doctor->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $doctor->department->name ?? 'N/A' }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Date</div>
                <div class="info-value">{{ $prescription->created_at->format('M d, Y') }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Prescription #</div>
                <div class="info-value">RX-{{ str_pad($prescription->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        <div class="section-title">Diagnosis</div>
        <div class="diagnosis">
            {{ $prescription->diagnosis ?? 'No diagnosis recorded' }}
        </div>

        <div class="section-title">Medicines</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine Name</th>
                    <th>Dosage</th>
                    <th>Duration</th>
                    <th>Frequency</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->medicines as $i => $medicine)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $medicine->medicine_name }}</td>
                    <td>{{ $medicine->pivot->dosage ?? '-' }}</td>
                    <td>{{ $medicine->pivot->duration ?? '-' }}</td>
                    <td>{{ $medicine->pivot->frequency ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($prescription->notes)
        <div class="notes">
            <strong>Notes:</strong> {{ $prescription->notes }}
        </div>
        @endif

        <div class="footer">
            <div class="signature-box">
                <div class="signature-line">Patient's Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Doctor's Signature</div>
            </div>
        </div>
    </div>
</body>
</html>
