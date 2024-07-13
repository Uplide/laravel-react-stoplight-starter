<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uplide Laravel Starter'e Hoş Geldiniz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        .header {
            background-color: #50b3a2;
            color: #ffffff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }

        .header h1 {
            text-align: center;
            text-transform: uppercase;
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
            background: #ffffff;
            border: #e8491d 1px solid;
            margin-top: 30px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
        }

        .content .code {
            font-size: 18px;
            font-weight: bold;
            background-color: #f9f9f9;
            padding: 10px;
            border: #e8491d 1px solid;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Uplide Laravel Starter'e Hoş Geldiniz!</h1>
    </div>
    <div class="container">
        <div class="content">
            <p>Merhaba,</p>
            <p>{{ $userEmail }} e-posta adresiniz ile Uplide Laravel Starter uygulamasına kayıt olmak için aşağıdaki
                doğrulama
                kodunu kullanabilirsiniz:</p>
            <p class="code">{{ $verifyCode }}</p>
            <p>Herhangi bir sorunuz veya yardıma ihtiyacınız olursa, lütfen bizimle iletişime geçmekten çekinmeyin.</p>
            <p>Teşekkürler,</p>
            <p>Uplide Laravel Starter Ekibi</p>
        </div>
    </div>
</body>

</html>
