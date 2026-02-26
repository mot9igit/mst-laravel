<template>
    <div>
        <vForm
            title="Создание нового пользователя"
            submit_text="Создать пользователя"
            method="post"
            form_url="/api/users/"
            redirect_url="/adm/users/"
            :form_data="this.formData"
        />
    </div>
</template>

<script>
import vForm from '../main/form/v-form.vue';

export default {
    name: "CreateUserComponent",
    components: {
        vForm
    },
    data() {
        return {
            // 1 уровень - строка, 2 уровень сетка, 3 уровень - поле
            formData: [{
                grids: [{
                    class: "d-col-md-24",
                    fields: {
                        name: {
                            type: 'text',
                            value: '',
                            label: "Логин"
                        },
                        email: {
                            type: 'text',
                            value: '',
                            label: "E-mail"
                        },
                        password: {
                            type: 'password',
                            value: '',
                            label: "Пароль"
                        },
                        confirm_password: {
                            type: 'password',
                            value: '',
                            label: "Повторите пароль"
                        },
                        fullname: {
                            type: 'text',
                            value: '',
                            label: "Ф. И. О."
                        },
                        phone: {
                            type: 'text',
                            value: '',
                            label: "Телефон"
                        },
                        active: {
                            type: 'checkbox',
                            value: '',
                            label: "Активный"
                        },
                        sudo: {
                            type: 'checkbox',
                            value: '',
                            label: "Доступ в панель администратора"
                        }
                    }
                },{
                    class: "d-col-md-24",
                    fields: {
                        description: {
                            type: 'textarea',
                            value: '',
                            label: "Описание"
                        }
                    }
                }]
            }]
        }
    },
    methods: {
        addCategory(){
            axios.post('/api/product/category', this.form)
                .then(res => {
                    window.location.href = "/adm/products/categories/";
                })
                .catch((error) => {
                    this.errors = error.response?.data?.errors
                });
        }
    }
}
</script>

<style scoped>

</style>
