    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сброс пароля</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #131317; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
<div style="display: none; max-height: 0; overflow: hidden;">
    Сброс пароля для MachineStore
</div>

<div style="max-width: 600px; margin: 0 auto; padding: 24px; background-color: #131317;">
    <div style="text-align: center; margin-bottom: 32px;">
        <h1 style="margin: 0 0 24px 0; font-size: 30px; color: #ffffff; font-weight: 700;">MachineStore</h1>
        <h2 style="margin: 0 0 16px 0; font-size: 20px; color: #ffffff; font-weight: 700;">Сброс пароля</h2>
        <p style="margin: 0 0 16px 0; font-size: 16px; color: #ffffff; line-height: 1.5;">
            Мы получили запрос на сброс пароля для вашего аккаунта MachineStore. Для установки нового пароля перейдите по ссылке ниже:
        </p>

        <div style="margin: 24px 0 16px 0;">
            <a href="{{ $domain }}/new-password?token={{ $token }}"
               style="display: inline-block; background-color: #253ECE; color: #ffffff; padding: 12px 24px; border-radius: 9999px; text-decoration: none; font-size: 14px; font-weight: 500; text-align: center;">
                Сбросить пароль
            </a>
        </div>

        <p style="margin: 24px 0 0 0; font-size: 16px; color: #ffffff; line-height: 1.5;">
            Ссылка действительна в течение 1 часа. Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.
        </p>
    </div>

    <div style="text-align: center; margin-top: 32px;">
        <p style="margin: 0 0 8px 0; color: #9ca3af; font-size: 14px;">
            Если кнопка не работает, скопируйте и вставьте следующую ссылку в браузер:
        </p>
        <p style="margin: 8px 0 0 0; color: #5074d6; font-size: 14px; word-break: break-all;">
            {{ $domain }}/new-password?token={{ $token }}
        </p>
    </div>

    <div style="text-align: center; margin-top: 32px;">
        <p style="margin: 0; color: #9ca3af; font-size: 14px;">
            Если у вас есть вопросы или вы столкнулись с трудностями, не стесняйтесь обращаться в
            нашу службу поддержки по адресу
            <a href="mailto:machineStore.sup@mail.ru" style="color: #5074d6; text-decoration: underline;">help@MachineStore</a>
        </p>
    </div>
</div>
</body>
</html>
