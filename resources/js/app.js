/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import store from './store';
import 'vue-final-modal/style.css';
import 'primeicons/primeicons.css';

// import App from './App.vue'
import VueCookies from 'vue-cookies'
// import { createYmaps } from '@/vue-yandex-maps'
// import { version } from '../package'
// import router from './router'
// import store from './store'
import ApiPlugin from './shared/api'
import LoadPlugin from './shared/api/load'
import PrimeVue from 'primevue/config'
import { definePreset } from '@primeuix/themes'
import Aura from '@primeuix/themes/aura'
import ConfirmationService from 'primevue/confirmationservice'
import ToastService from 'primevue/toastservice'
import PrimeButton from 'primevue/button'
import mdiVue from 'mdi-vue/v3'
import {
    mdiClose,
    mdiEye,
    mdiEyeClosed,
    mdiCheckCircleOutline,
    mdiSortAscending,
    mdiSortDescending,
    mdiSort,
} from '@mdi/js'
import { createVfm } from 'vue-final-modal'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

const vfm = createVfm()

const MyPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: 'rgba(249,44,13,1)',
            100: 'rgba(249,44,13,1)',
            200: 'rgba(249,44,13,1)',
            300: 'rgba(249,44,13,1)',
            400: 'rgba(249,44,13,1)',
            500: 'rgba(249,44,13,1)',
            600: 'rgba(249,44,13,1)',
            700: 'rgba(249,44,13,1)',
            800: 'rgba(249,44,13,1)',
            900: 'rgba(249,44,13,1)',
            950: 'rgba(249,44,13,1)',
        },
        colorScheme: {
            dark: {
                surface: {
                    0: '#282828',
                    50: '{zinc.50}',
                    100: '{zinc.100}',
                    200: '#282828',
                    300: '{zinc.300}',
                    400: '{zinc.400}',
                    500: '{zinc.500}',
                    600: '{zinc.600}',
                    700: '#dedede',
                    800: '#ffffff',
                    900: '#ffffff',
                    950: '#ffffff',
                },
            },
        },
    },
})

app.use(PrimeVue, {
    theme: {
        preset: MyPreset,
    },
    ripple: true,
    locale: {
        startsWith: 'Начинается с',
        contains: 'Содержит',
        notContains: 'Не содержит',
        endsWith: 'Заканчивается',
        equals: 'Равно',
        notEquals: 'Не равно',
        noFilter: 'Нет фильтра',
        filter: 'Фильтр',
        lt: 'Меньше чем',
        lte: 'Меньше чем или равно',
        gt: 'Более чем',
        gte: 'Более чем или равно',
        dateIs: 'Дата равна',
        dateIsNot: 'Дата не равна',
        dateBefore: 'Дата до',
        dateAfter: 'Дата после',
        custom: 'Пользовательский',
        clear: 'Очистить',
        apply: 'Принять',
        matchAll: 'Сопоставить все',
        matchAny: 'Совпадение с любым',
        addRule: 'Добавить правило',
        removeRule: 'Удалить правило',
        accept: 'Да',
        reject: 'Нет',
        choose: 'Выбрать',
        upload: 'Загрузить',
        cancel: 'Отмена',
        completed: 'Завершено',
        pending: 'В ожидании',
        dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
        dayNamesShort: ['Вск', 'Пнд', 'Втр', 'Срд', 'Чтв', 'Птн', 'Сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        monthNames: [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ],
        monthNamesShort: [
            'Янв',
            'Фев',
            'Мар',
            'Апр',
            'Май',
            'Июн',
            'Июл',
            'Авг',
            'Сен',
            'Окт',
            'Ноя',
            'Дек',
        ],
        chooseYear: 'Выбрать год',
        chooseMonth: 'Выбрать месяц',
        chooseDate: 'Выбрать дату',
        prevDecade: 'Предыдущее десятилетие',
        nextDecade: 'Следующее десятилетие',
        prevYear: 'Предыдущий год',
        nextYear: 'Следующий год',
        prevMonth: 'Предыдущий месяц',
        nextMonth: 'Следующий месяц',
        prevHour: 'Предыдущий час',
        nextHour: 'Следующий час',
        prevMinute: 'Предыдущая минута',
        nextMinute: 'Следующая минута',
        prevSecond: 'Предыдущая секунда',
        nextSecond: 'Следующая секунда',
        am: 'до полудня',
        pm: 'после полудня',
        today: 'Сегодня',
        weekHeader: 'Нед.',
        firstDayOfWeek: 1,
        dateFormat: 'dd.mm.yy',
        weak: 'Простой',
        medium: 'Нормальный',
        strong: 'Хороший',
        passwordPrompt: 'Введите пароль',
        emptyFilterMessage: 'Результатов не найдено',
        searchMessage: '{0} результатов доступно',
        selectionMessage: '{0} элементов выбрано',
        emptySelectionMessage: 'Нет выбранного элемента',
        emptySearchMessage: 'Результатов не найдено',
        emptyMessage: 'Нет доступных вариантов',
        aria: {
            trueLabel: 'Верно',
            falseLabel: 'Неверно',
            nullLabel: 'Не выбран',
            star: '1 звезда',
            stars: '{star} звёзд',
            selectAll: 'Выбраны все элементы',
            unselectAll: 'Все элементы не выбраны',
            close: 'Закрыть',
            previous: 'Предыдущий',
            next: 'Следующий',
            navigation: 'Навигация',
            scrollTop: 'Прокрутить в начало',
            moveTop: 'Переместить в начало',
            moveUp: 'Переместить вверх',
            moveDown: 'Переместить вниз',
            moveBottom: 'Переместить в конец',
            moveToTarget: 'Переместить в приёмник',
            moveToSource: 'Переместить в источник',
            moveAllToTarget: 'Переместить всё в приёмник',
            moveAllToSource: 'Переместить всё в источник',
            pageLabel: '{page}',
            firstPageLabel: 'Первая страница',
            lastPageLabel: 'Последняя страница',
            nextPageLabel: 'Следующая страница',
            previousPageLabel: 'Предыдущая страница',
            rowsPerPageLabel: 'Строк на странице',
            jumpToPageDropdownLabel: 'Перейти к раскрывающемуся списку страниц',
            jumpToPageInputLabel: 'Перейти к вводу страницы',
            selectRow: 'Выбрана строка',
            unselectRow: 'Строка не выбрана',
            expandRow: 'Строка развёрнута',
            collapseRow: 'Строка свёрнута',
            showFilterMenu: 'Показать меню фильтра',
            hideFilterMenu: 'Скрыть меню фильтра',
            filterOperator: 'Оператор фильтра',
            filterConstraint: 'Ограничение фильтра',
            editRow: 'Редактирование строки',
            saveEdit: 'Сохранить правку',
            cancelEdit: 'Отменить правку',
            listView: 'В виде списка',
            gridView: 'В виде сетки',
            slide: 'Слайд',
            slideNumber: '{slideNumber}',
            zoomImage: 'Увеличить изображение',
            zoomIn: 'Увеличить',
            zoomOut: 'Уменьшить',
            rotateRight: 'Повернуть вправо',
            rotateLeft: 'Повернуть влево',
        },
    },
})
app.use(ApiPlugin)
app.use(LoadPlugin)
app.use(store);
app.use(ToastService)
app.use(ConfirmationService)
// app.use(
//     createYmaps({
//         apikey: '7270e707-f1a7-4397-a1d7-0c545cf0b735',
//     }),
// )
app.use(vfm)
app.use(VueCookies, { expires: '7d' })
app.use(mdiVue, {
    icons: {
        mdiClose,
        mdiCheckCircleOutline,
        mdiEye,
        mdiEyeClosed,
        mdiSort,
        mdiSortAscending,
        mdiSortDescending,
    },
})

import ExampleComponent from './components/ExampleComponent.vue';
import SignInPage from './pages/sign-in/index.vue';
import ProfileFormComponent from './components/admin/profile/form.vue';
import ShowUserComponent from './components/admin/user/ShowComponent.vue';
import CreateUserComponent from './components/admin/user/CreateComponent.vue';

app.component('example-component', ExampleComponent);
app.component('sign-in-page', SignInPage);
app.component("profile-form-component", ProfileFormComponent);
app.component("show-user-component", ShowUserComponent);
app.component("create-user-component", CreateUserComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
