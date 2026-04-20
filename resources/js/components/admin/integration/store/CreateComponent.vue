<template>
    <div>
        <vForm v-if="this.store_id == 0"
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            redirect_url="/adm/store/"
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
               redirect_url="/adm/store/"
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
    name: "CreateStoreComponent",
    props: {
        store_id: {
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
    mounted() {
        if (this.store_id > 0){
            const reqData = {
                storeId: this.store_id
            }

            this.getStore(reqData).then(() => {
                this.form.name = this.store.name;
                this.form.description = this.store.description;
                this.form.active = Boolean(this.store.active);
                this.form.thumb_url = this.store.thumb_url;
            })
        }
    },
    methods: {
        ...mapActions([
            'getStore'
        ])
    },
    computed: {
        ...mapGetters([
            'store'
        ]),
        formUrl(){
            if (Number(this.store_id) > 0) {
                return '/api/integration/store/' + this.store_id;
            } else {
                return '/api/integration/store/';
            }
        },
        headerForm() {
            if (Number(this.store_id) > 0) {
                return 'Редактировать точку продаж';
            } else {
                return 'Создать точку продаж';
            }
        },
        submitText(){
            if(Number(this.store_id) > 0){
                return 'Редактировать точку продаж';
            }else{
                return 'Создать точку продаж';
            }
        },
        mode(){
            if(Number(this.store_id) > 0){
                return 'update';
            }else{
                return 'create';
            }
        },
        formData(){
            if(Number(this.store_id) > 0){
                return [{
                    grids: [{
                        class: "d-col-md-12",
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
                            name: {
                                type: 'text',
                                value: '',
                                label: "Наименование"
                            },
                            name_short: {
                                type: 'text',
                                value: '',
                                label: "Наименование, краткое"
                            },
                            image: {
                                type: 'image',
                                value: '',
                                label: "Изображение"
                            },
                            address: {
                                type: 'autocomplete',
                                value: '',
                                label: "Адрес",
                                searchType: "address",
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
