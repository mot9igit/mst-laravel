class ErrorHandler {
    handle(error) {
        const { response, request, message } = error;

        if (response) {
            // Сервер вернул ошибку (4xx, 5xx)
            this.handleServerError(response);
        } else if (request) {
            // Запрос был отправлен, но нет ответа (проблемы сети)
            this.handleNetworkError();
        } else {
            // Проблема с настройкой запроса
            this.handleRequestError(message);
        }
    }

    handleServerError(response) {
        const { status, data } = response;

        switch (status) {
            case 401:
                this.showNotification('Требуется авторизация', 'error', data);
                break;
            case 403:
                this.showNotification('Доступ запрещён', 'error', data);
                break;
            case 404:
                this.showNotification('Ресурс не найден', 'warning');
                break;
            case 422:
                // Валидационные ошибки
                if (data.errors) {
                    Object.values(data.errors).forEach(errors => {
                        errors.forEach(msg => this.showNotification(msg, 'error'));
                    });
                }
                break;
            case 500:
                this.showNotification("Внутренняя ошибка сервера. <br/>Наша команда уже работает над восстановлением работоспособности!", 'error');
                break;
            default:
                // Отправка на сервер
                this.showNotification(`Ошибка ${status}: ${data.message || 'Неизвестная ошибка'}`, 'error');
        }
    }

    handleNetworkError() {
        this.showNotification('Проблемы с подключением к серверу', 'error');
    }

    handleRequestError(message) {
        this.showNotification(`Ошибка запроса: ${message}`, 'error');
    }

    showNotification(message, type = 'error', data = {}) {
        // Используем глобальное свойство $notify, если доступно
        if (window.$notify) {
            window.$notify.error(message, data);
        } else {
            alert(`${type.toUpperCase()}: ${message}`);
        }
    }
}

export default new ErrorHandler();
