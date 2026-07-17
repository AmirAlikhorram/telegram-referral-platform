<!DOCTYPE html>
<html lang="fa" dir="rtl">
@if(session('success'))
    <div class="alert alert-success shadow-sm">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Telegram Referral Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          rel="stylesheet">

    <style>

        body{

            background:#f4f6f9;

            font-family:tahoma;

        }

        .sidebar{

            width:260px;

            position:fixed;

            right:0;

            top:0;

            bottom:0;

            background:#1f2937;

            color:white;

            padding:25px;

        }

        .sidebar h3{

            margin-bottom:35px;

            text-align:center;

            font-size:22px;

            font-weight:bold;

        }

        .sidebar a{

            display:block;

            color:white;

            text-decoration:none;

            padding:14px;

            border-radius:10px;

            margin-bottom:8px;

            transition:.2s;

        }

        .sidebar a:hover{

            background:#2563eb;

        }

        .content{

            margin-right:280px;

            padding:30px;

        }

        .topbar{

            background:white;

            padding:20px;

            border-radius:15px;

            box-shadow:0 5px 20px rgba(0,0,0,.08);

            margin-bottom:30px;

        }

        .card{

            border:none;

            border-radius:18px;

            box-shadow:0 10px 30px rgba(0,0,0,.08);

            transition:.2s;

        }

        .card:hover{

            transform:translateY(-5px);

        }

        .stat-icon{

            font-size:42px;

            opacity:.15;

            position:absolute;

            left:20px;

            top:15px;

        }

        .stat-card{

            position:relative;

            overflow:hidden;

            padding:10px;

        }

        table{

            background:white;

        }

    </style>

</head>

<body>

<div class="sidebar">

    <h3>
        Telegram Admin
    </h3>

    <a href="{{ route('admin.dashboard') }}">
        <i class="fa fa-chart-line"></i>
        داشبورد
    </a>

    <a href="{{ route('admin.users.index') }}">
        <i class="fa fa-users"></i>
        کاربران
    </a>

    <a href="{{ route('admin.referrals.index') }}">
        <i class="fa fa-user-plus"></i>
        دعوت‌ها
    </a>

    <a href="{{ route('admin.withdrawals.index') }}">
        <i class="fa fa-wallet"></i>
        برداشت‌ها
    </a>

    <a href="{{ route('admin.settings.index') }}">
        <i class="fa fa-gear"></i>
        تنظیمات
    </a>

    <a href="{{ route('admin.broadcasts.index') }}">
        <i class="fa fa-bullhorn"></i>
        پیام همگانی
    </a>

</div>

<div class="content">

    <div class="topbar">

        <div class="d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                پنل مدیریت ربات تلگرام

            </h4>

            <span class="badge bg-success">

                آنلاین

            </span>

        </div>

    </div>

    @yield('content')

</div>

</body>

</html>
