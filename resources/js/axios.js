/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const api = axios.create({
    baseURL: '/api',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

// api.interceptors.response.use(
// (response) => response,
// (error) => {
//     const status = error.response?.status;
//     let message = 'Произошла неизвестная ошибка';
//
//     if (error.response) {
//         const errorData = error.response.data;
//         if(status === 401){
//             window.location.href = "/login"
//         }else {
//             if (status === 422 && errorData.errors) {
//                 // Валидационные ошибки Laravel
//                 message = Object.values(errorData.errors).flat().join(', ');
//             } else if (errorData.message) {
//                 message = errorData.message;
//             }
//         }
//     } else if (error.request) {
//         message = 'Нет ответа от сервера. Проверьте подключение к интернету.';
//     }
//
//     notificationService.error(message);
//
//     return Promise.reject(error);
// });

export default api;
