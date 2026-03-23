<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            redirect_url="/adm/organization/"
            :form_data="this.formData"
            :form_values="this.form"
        />
    </div>
</template>

<script>
import vForm from '../../main/form/v-form.vue';
import {mapActions, mapGetters} from "vuex";
import Dropzone from "dropzone";

export default {
    name: "CreateOrganizationComponent",
    props: {
        orgid: {
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
        }
    },
    mounted(){
        const reqData = {
            orgid: this.orgid
        }
        // this.getUser(reqData).then(() => {
        //     this.form.name = this.userData.name;
        //     this.form.email = this.userData.email;
        //     this.form.fullname = this.userData.fullname;
        //     this.form.image = this.userData.image;
        //     this.form.avatar = this.userData.avatar;
        //     this.form.phone = this.userData.phone;
        //     this.form.active = Boolean(this.userData.active);
        //     this.form.sudo = Boolean(this.userData.sudo);
        // })
    },
    methods: {
        ...mapActions([
            // 'getUser'
        ])
    },
    computed: {
        ...mapGetters([
            // 'userData'
        ]),
        formUrl(){
            if (Number(this.userid) > 0) {
                return '/api/integration/organization/' + this.orgid;
            } else {
                return '/api/integration/organization/';
            }
        },
        headerForm() {
            if (Number(this.userid) > 0) {
                return 'Редактировать организацию';
            } else {
                return 'Создать организацию';
            }
        },
        submitText(){
            if(Number(this.userid) > 0){
                return 'Редактировать';
            }else{
                return 'Создать';
            }
        },
        mode(){
            if(Number(this.userid) > 0){
                return 'update';
            }else{
                return 'create';
            }
        },
        formData(){
            return [{
                grids: [{
                    class: "d-col-md-24",
                    fields: {
                        nameHelper: {
                            type: 'autocomplete',
                            value: '',
                            label: "Введите ИНН",
                            searchType: "inn",
                            description: "Выберите организацию из выпадающего списка и все известные данные в форме заполнятся"
                        },
                        name: {
                            type: 'hidden',
                            value: ''
                        },
                        image: {
                            type: 'image',
                            value: '',
                            label: "Изображение"
                        },
                        description: {
                            type: 'textarea',
                            value: '',
                            label: "Описание"
                        }
                    }
                },{
                    class: "d-col-md-24",
                    fields: {
                        header: {
                            type: 'header',
                            label: "Реквизиты"
                        },
                        inn: {
                            type: 'text',
                            value: '',
                            label: "ИНН"
                        },
                        ogrn: {
                            type: 'text',
                            value: '',
                            label: "ОГРН"
                        },
                        kpp: {
                            type: 'text',
                            value: '',
                            label: "КПП"
                        },
                        ur_address: {
                            type: 'text',
                            value: '',
                            label: "Юридический адрес"
                        },
                        fact_address: {
                            type: 'text',
                            value: '',
                            label: "Фактический адрес"
                        }
                    }
                }]
            }];
        }
    }
}
</script>

<style scoped>

</style>
