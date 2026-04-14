import axios from 'axios'

const instance = axios.create({
    baseURL: '/',
    withCridentials: true,
    timeout: 10000,
    headers: {
        accept: 'application/json',
    },
})

// Перехватчик запросов
instance.interceptors.request.use(
    (config) => {
        // Добавляем CSRF‑токен, если есть
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (token) {
            config.headers['X-CSRF-TOKEN'] = token;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

// Перехватчик ответов — основная обработка ошибок
instance.interceptors.response.use(
    (response) => response,
    (error) => {
        const {status} = error.response || {};

        // Глобальный обработчик ошибок
        if (window.errorHandler) {
            window.errorHandler.handle(error);
        }

        return Promise.reject(error);
    }
);

export default instance
