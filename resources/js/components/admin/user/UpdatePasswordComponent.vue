<template>
    <div>
        <vForm
            title="Редактирование пароля"
            submit_text="Обновить пароль"
            method="patch"
            mode="update"
            :form_url="'/api/users/' + userid + '/change-password'"
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
    name: "UpdatePasswordUserComponent",
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
            form: {},
            // 1 уровень - строка, 2 уровень сетка, 3 уровень - поле
            formData: [{
                grids: [{
                    class: "d-col-md-24",
                    fields: {
                        current_password: {
                            type: 'password',
                            value: '',
                            label: "Текущий пароль"
                        },
                        new_password: {
                            type: 'password',
                            value: '',
                            label: "Пароль"
                        },
                        new_password_confirmation: {
                            type: 'password',
                            value: '',
                            label: "Повторите пароль"
                        },
                    }
                }]
            }]
        }
    },
    mounted(){
        const reqData = {
            userid: this.userid
        }
    }
}
</script>

<style scoped>

</style>
