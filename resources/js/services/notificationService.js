import { createToaster } from "@meforma/vue-toaster";

export class NotificationService {
    constructor() {
        this.toaster = createToaster({
            position: "top-right",
            duration: 5000,
        });
    }
    success(message, data) {
        if(data?.message){
            message = data?.message
        }
        this.toaster.success(message);
    }

    error(message, data) {
        if(data?.message){
            message = data?.message
        }
        this.toaster.error(message);
    }

    warn(message, data) {
        if(data?.message){
            message = data?.message
        }
        this.toaster.warning(message);
    }

    info(message, data) {
        if(data?.message){
            message = data?.message
        }
        this.toaster.info(message);
    }
}

// Экспортируем синглтон
export const notificationService = new NotificationService();
