import { createToaster } from "@meforma/vue-toaster";

export class NotificationService {
    constructor() {
        this.toaster = createToaster({
            position: "top-right",
            duration: 5000,
        });
    }
    success(message, title = 'Успех') {
        this.toaster.success(message);
    }

    error(message, title = 'Ошибка') {
        this.toaster.error(message);
    }

    warn(message, title = 'Предупреждение') {
        this.toaster.warning(message);
    }

    info(message, title = 'Информация') {
        this.toaster.info(message);
    }
}

// Экспортируем синглтон
export const notificationService = new NotificationService();
