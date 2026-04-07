<template>
    <div>
        <vForm v-if="this.requisite_id == 0"
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            :redirect_url="'/adm/organization/' + this.org_id"
            :form_data="this.formData"
            :form_values="this.form"
        />
        <vForm v-else
               body_class=""
               :title="this.headerForm"
               :submit_text="this.submitText"
               method="post"
               :mode="this.mode"
               :form_url="this.formUrl"
               :redirect_url="'/adm/organization/' + this.org_id"
               :form_data="this.formData"
               :form_values="this.form"
        >
            <template #header="{ title }">
                <div class="dart-mt-1"></div>
            </template>
            <template #footer="{ submit_text, loading }">
                <button class="btn btn-primary" type="button" disabled v-if="loading">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Загрузка...</span>
                </button>
                <button type="submit" class="btn btn-success" v-else>{{ submit_text? submit_text : 'Отправить' }}</button>
            </template>
        </vForm>
    </div>
</template>

<script>
import vForm from '../../main/form/v-form.vue';
import {mapActions, mapGetters} from "vuex";
import Dropzone from "dropzone";

export default {
    name: "CreateOrganizationRequisiteComponent",
    props: {
        org_id: {
            type: Number,
            default: 0
        },
        requisite_id: {
            type: Number,
            default: 0
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
        if(this.requisite_id > 0) {
            const reqData = {
                requisite_id: this.requisite_id,
                org_id: this.org_id
            }
            this.getRequisite(reqData).then(() => {
                this.form.name = this.requisite.name;
                this.form.inn = this.requisite.inn;
                this.form.ogrn = this.requisite.ogrn;
                this.form.kpp = this.requisite.kpp;
                this.form.ur_address = this.requisite.ur_address;
                this.form.fact_address = this.requisite.fact_address;
                this.form.description = this.requisite.description;
            })
        }
        this.form.org_id = this.org_id
    },
    methods: {
        ...mapActions([
            'getRequisite'
        ])
    },
    computed: {
        ...mapGetters([
            'requisite'
        ]),
        formUrl(){
            if (Number(this.requisite_id) > 0) {
                return '/api/integration/requisite/' + this.requisite_id;
            } else {
                return '/api/integration/requisite/';
            }
        },
        headerForm() {
            if (Number(this.requisite_id) > 0) {
                return 'Редактировать реквизиты';
            } else {
                return 'Создать реквизиты';
            }
        },
        submitText(){
            if(Number(this.requisite_id) > 0){
                return 'Редактировать реквизиты';
            }else{
                return 'Создать реквизиты';
            }
        },
        mode(){
            if(Number(this.requisite_id) > 0){
                return 'update';
            }else{
                return 'create';
            }
        },
        formData(){
            if(Number(this.requisite_id) > 0){
                return [{
                    grids: [{
                        class: "d-col-md-12",
                        fields: {
                            name: {
                                type: 'text',
                                label: "Наименование",
                                value: ''
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
