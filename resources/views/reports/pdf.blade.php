<!DOCTYPE html>
<html>
<head>
    <title>Reports PDF</title>
    <style>
        /* Add your custom styles for the PDF here */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reports</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Reported User's ID</th>
                <th>Reported User's Name</th>
                <th>Reporter's ID</th>
                <th>Reporter's Name</th>
                <th>Reasons</th>
                <th>Other</th>
                <th>Reported on</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr>
                <td>{{ $report->id }}</td>
                <td>{{ $report->reportedUser->studentid }}</td>
                <td>{{ $report->reportedUser->firstname }} {{ $report->reportedUser->middlename }} {{ $report->reportedUser->lastname }}</td>
                <td>{{ $report->reporter->studentid }}</td>
                <td>{{ $report->reporter->firstname }} {{ $report->reporter->middlename }} {{ $report->reporter->lastname }}</td>
                <td>{{ $report->reasons }}</td>
                <td>{{ $report->other }}</td>
                <td>{{ $report->created_at->format('F j, Y, g:i a') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
