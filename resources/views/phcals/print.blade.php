<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHCALS Certificate - {{ auth()->user()->name }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; padding: 50px; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #000; padding-bottom: 20px; }
        .content { margin-top: 30px; }
        .footer { margin-top: 60px; }
        .bold { font-weight: bold; }
        .disclaimer { margin-top: 50px; border-top: 1px dashed #ccc; padding-top: 10px; font-size: 0.85rem; color: #666; font-style: italic; }
        @media print {
            .no-print { display: none; }
            body { padding: 20px; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="cursor:pointer; padding: 8px 15px;">Click to Print</button>
    </div>

    <div class="header">
        <h3>ASSISTANT MEDICAL OFFICER SERVICES BRANCH<br>MINISTRY OF HEALTH MALAYSIA</h3>
    </div>

    <div class="content">
        <p>Date: <span class="bold">{{ date('d F Y', strtotime($result->attempt_date)) }}</span></p>

        <p>To whom it may concern,</p>

        <p class="bold" style="text-decoration: underline;">PHCALS COMPETENCY EXAMINATION RESULT (SET {{ $result->set_id }})</p>

        <p>Please be informed that the following candidate has completed the online PHCALS Competency Examination:</p>

        <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
            <tr><td width="150" style="padding: 5px 0;">NAME</td><td>: <span class="bold">{{ strtoupper(auth()->user()->name) }}</span></td></tr>
            <tr><td style="padding: 5px 0;">IC NUMBER</td><td>: <span class="bold">{{ auth()->user()->ic_number }}</span></td></tr>
            <tr><td style="padding: 5px 0;">SCORE</td><td>: <span class="bold">{{ $result->score }}%</span></td></tr>
            <tr><td style="padding: 5px 0;">STATUS</td><td>: <span class="bold" style="color: green;">{{ $result->status }}</span></td></tr>
        </table>

        <p>Congratulations on your achievement. This result demonstrates your competency level in Pre-Hospital Care and Ambulance Life Support (PHCALS) management.</p>
        
        <p>Thank you.</p>
    </div>

    <div class="footer">
        <p>"BERKHIDMAT UNTUK NEGARA"</p>
        <p>Regards:</p>
        <br><br>
        <p class="bold">(DR. LEONG)</p>
        <p>Emergency Medicine Specialist</p>

        <div class="disclaimer">
            This is a computer-generated document and no signature is required.<br>
            <i>Dokumen ini merupakan cetakan daripada komputer dan tidak memerlukan tandatangan.</i>
        </div>
    </div>
</body>
</html>