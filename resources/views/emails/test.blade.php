<!DOCTYPE html>
<html>
<head>
    <title>Тест SMTP</title>
</head>
<body>
<h1>Привет, {{ $data['name'] }}!</h1>
<p>Это тестовое письмо для проверки SMTP‑настроек.</p>
<p><strong>Время отправки:</strong> {{ now()->format('d.m.Y H:i:s') }}</p>
</body>
</html>
