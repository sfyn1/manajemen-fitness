<!DOCTYPE html>
<html>
<head>
    <title>Kartu Member - {{ $user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: 85.60mm 53.98mm; /* Ukuran CR80 (ID Card) */
        }
        
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            /* Latar belakang SOLID (Bukan Gradient) agar muncul di PDF */
            background-color: #3454d1; 
            -webkit-print-color-adjust: exact;
        }

        .card-container {
            width: 85.60mm;
            height: 53.98mm;
            position: relative;
            /* Pastikan warna background tercetak */
            background-color: #3454d1; 
        }

        /* Watermark Pattern Sederhana */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            color: rgba(255, 255, 255, 0.05);
            font-weight: bold;
            z-index: 0;
            white-space: nowrap;
        }

        table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            z-index: 2;
            position: relative;
        }

        td {
            vertical-align: middle;
            padding: 10px;
        }

        .left-col {
            width: 30%;
            text-align: center;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .right-col {
            width: 70%;
            padding-left: 15px;
            color: #ffffff; /* Paksa teks jadi putih */
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid white;
            background: #fff;
            margin-bottom: 5px;
        }

        .qr-box {
            background: white;
            padding: 4px;
            border-radius: 4px;
            display: inline-block;
        }

        .title {
            font-size: 10px;
            letter-spacing: 2px;
            opacity: 0.8;
            margin-bottom: 2px;
            text-transform: uppercase;
            color: #eeeeee;
        }

        .gym-name {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .member-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
            color: #ffffff;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            padding-bottom: 2px;
            display: inline-block;
        }

        .info {
            font-size: 9px;
            line-height: 1.4;
            color: #f0f0f0;
        }

        .badge {
            background-color: #ffffff;
            color: #3454d1;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="watermark">GINTUNG FITNESS</div>
        
        <table>
            <tr>
                <td class="left-col">
                    <img src="{{ public_path('template/assets/images/avatar/1.png') }}" class="avatar">
                    
                    <div class="qr-box">
                        <img src="data:image/svg+xml;base64, {{ base64_encode(QrCode::format('svg')->size(70)->generate($user->member->id)) }}" width="70" height="70">
                    </div>
                </td>
                <td class="right-col">
                    <div class="title">Member Card</div>
                    <div class="gym-name">GINTUNG FITNESS</div>
                    
                    <div class="member-name">{{ Str::limit($user->name, 20) }}</div>
                    
                    <div style="margin-bottom: 5px;">
                        <span class="badge">{{ ucfirst($user->role) }}</span>
                    </div>

                    <div class="info">
                        ID: <strong>#{{ sprintf('%05d', $user->member->id) }}</strong><br>
                        Exp: {{ date('d M Y', strtotime($user->member->expiry_date)) }}<br>
                        HP: {{ $user->member->phone_number }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>