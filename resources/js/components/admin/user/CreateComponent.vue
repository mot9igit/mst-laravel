<template>
    <div>
        <vForm
            title="Редактирование пользователя"
            submit_text="Редактирование пользователя"
            method="post"
            mode="update"
            :form_url="'/api/users/' + userid"
            redirect_url="/adm/users/"
            :form_data="this.formData"
            :form_values="this.form"
        />
    </div>
</template>

<script>
import vForm from '../main/form/v-form.vue';
import {mapActions, mapGetters} from "vuex";
import Dropzone from "dropzone";

export default {
    name: "CreateUserComponent",
    props: {
        userid: {
            type: String,
            default: "0"
        }
    },
    components: {
        vForm
    },
    data() {
        return {
            form: {

            },
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
    mounted(){
        const reqData = {
            userid: this.userid
        }
        this.getUser(reqData).then(() => {
            this.form.name = this.userData.name;
            this.form.email = this.userData.email;
            this.form.fullname = this.userData.fullname;
            this.form.image = this.userData.image;
            this.form.avatar = this.userData.avatar;
            this.form.phone = this.userData.phone;
            this.form.active = Boolean(this.userData.active);
            this.form.sudo = Boolean(this.userData.sudo);
        })
    },
    methods: {
        ...mapActions([
            'getUser'
        ])
    },
    computed: {
        ...mapGetters([
            'userData'
        ])
    }
}
</script>

<style scoped>

</style>
