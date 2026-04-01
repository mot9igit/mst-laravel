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
            organizationId: this.orgid
        }
        this.getOrganization(reqData).then(() => {
            this.form.name = this.organization.name;
            this.form.description = this.organization.description;
            this.form.active = Boolean(this.organization.active);
            this.form.verified = Boolean(this.organization.verified);
            this.form.thumb_url = this.organization.thumb_url;
        })
    },
    methods: {
        ...mapActions([
            'getOrganization'
        ])
    },
    computed: {
        ...mapGetters([
            'organization'
        ]),
        formUrl(){
            if (Number(this.orgid) > 0) {
                return '/api/integration/organization/' + this.orgid;
            } else {
                return '/api/integration/organization/';
            }
        },
        headerForm() {
            if (Number(this.orgid) > 0) {
                return 'Редактировать организацию';
            } else {
                return 'Создать организацию';
            }
        },
        submitText(){
            if(Number(this.orgid) > 0){
                return 'Редактировать организацию';
            }else{
                return 'Создать организацию';
            }
        },
        mode(){
            if(Number(this.orgid) > 0){
                return 'update';
            }else{
                return 'create';
            }
        },
        formData(){
            if(Number(this.orgid) > 0){
                return [{
                    grids: [{
                        class: "d-col-md-24",
                        fields: {
                            name: {
                                type: 'text',
                                label: "Наименование",
                                value: ''
                            },
                            image: {
                                type: 'image',
                                value: '',
                                defaultValue: 'thumb_url',
                                label: "Изображение"
                            },
                            description: {
                                type: 'textarea',
                                value: '',
                                label: "Описание"
                            },
                            active: {
                                type: 'checkbox',
                                value: '',
                                label: "Активна"
                            },
                            verified: {
                                type: 'checkbox',
                                value: '',
                                label: "Верифицирована"
                            }
                        }
                    }]
                }];
            }else{
                return [{
                    grids: [{
                        class: "d-col-md-24",
                        fields: {
                            nameHelper: {
                                errorKey: 'name',
                                type: 'autocomplete',
                                value: '',
                                label: "Введите ИНН",
                                searchType: "inn",
                                description: "Выберите организацию из выпадающего списка и все известные данные в форме заполнятся автоматически"
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
                            },
                            active: {
                                type: 'checkbox',
                                value: '',
                                label: "Активна"
                            },
                            verified: {
                                type: 'checkbox',
                                value: '',
                                label: "Верифицирована"
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
                                type: 'autocomplete',
                                value: '',
                                label: "Юридический адрес",
                                searchType: "address",
                            },
                            fact_address: {
                                type: 'autocomplete',
                                value: '',
                                label: "Фактический адрес",
                                searchType: "address",
                            }
                        }
                    }]
                }];
            }

        }
    }
}
</script>

<style scoped>

</style>
