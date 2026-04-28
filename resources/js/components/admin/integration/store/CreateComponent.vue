<template>
    <div>
        <vForm v-if="this.store_id === 0"
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
    mounted() {
        if (this.store_id > 0){
            const reqData = {
                storeId: this.store_id
            }

            this.getStore(reqData).then(() => {
                this.form.name = this.store.name;
                this.form.name_short = this.store.name_short;
                this.form.description = this.store.description;
                this.form.address = this.store.address;
                this.form.coordinates = this.store.coordinates;
                this.form.city_id = this.store.city;
                this.form.integration_type = this.store.integration_type;
                this.form.version = this.store.version;
                if(this.store.date_api_ping) {
                    this.form.date_api_ping = new Date(this.store.date_api_ping);
                }
                if(this.store.date_remains_update) {
                    this.form.date_remains_update = new Date(this.store.date_remains_update);
                }
                if(this.store.date_docs_update) {
                    this.form.date_docs_update = new Date(this.store.date_docs_update);
                }
                this.form.active = Boolean(this.store.active);
                this.form.marketplace = Boolean(this.store.marketplace);
                this.form.opt_marketplace = Boolean(this.store.opt_marketplace);
                this.form.check_remains = Boolean(this.store.check_remains);
                this.form.check_docs = Boolean(this.store.check_docs);
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
                                defaultValue: 'thumb_url',
                                label: "Изображение"
                            },
                            city_id: {
                                type: 'autocomplete',
                                label: 'Город',
                                value: '',
                                dropdown: true,
                                optionLabel: 'name',
                                searchType: 'custom',
                                searchUrl: `/api/system/geo/city/`
                            },
                            address: {
                                type: 'autocomplete',
                                value: '',
                                label: "Адрес",
                                searchType: "address",
                            },
                            coordinates: {
                                type: 'text',
                                value: '',
                                label: "Координаты для карты"
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
                            marketplace: {
                                type: 'checkbox',
                                value: '',
                                label: "Доступна для розницы"
                            },
                            opt_marketplace: {
                                type: 'checkbox',
                                value: '',
                                label: "Доступна для Закупок"
                            }
                        }
                    }, {
                        class: "d-col-md-24",
                        wrapClass: 'fieldset',
                        fields: {
                            header: {
                                type: 'header',
                                label: 'Флаги слежки за API',
                                description: 'На основании этих параметров осуществляется контроль обмена информации и отключение Точки продаж при потери связи.',
                            },
                            integration_type: {
                                type: 'autocomplete',
                                value: '',
                                dropdown: true,
                                optionLabel: 'name',
                                label: "Тип интеграции",
                                searchType: 'custom',
                                searchUrl: `/api/enums/StoreIntegrationType/`
                            },
                            yml_file: {
                                type: 'text',
                                value: '',
                                label: "Ссылка на YML файл"
                            },
                            check_remains: {
                                type: 'checkbox',
                                value: '',
                                label: "Следить за обменом остатков"
                            },
                            check_docs: {
                                type: 'checkbox',
                                value: '',
                                label: "Следить за обменом документов"
                            }
                        }
                    }, {
                        class: "d-col-md-24",
                        wrapClass: 'fieldset',
                        fields: {
                            header: {
                                type: 'header',
                                label: 'Даты последних обновлений по API',
                                description: 'На основании этих параметров осуществляется контроль обмена информации и отключение Точки продаж при потери связи.',
                            },
                            version: {
                                type: 'text',
                                static: true,
                                value: '',
                                label: "Версия модуля API",
                                description: "Приходит в API запросах"
                            },
                            date_api_ping: {
                                type: 'datetime',
                                static: true,
                                value: '',
                                label: "Дата последней связи по API"
                            },
                            date_remains_update: {
                                type: 'datetime',
                                static: true,
                                value: '',
                                label: "Дата последнего обновления остатков по API"
                            },
                            date_docs_update: {
                                type: 'datetime',
                                static: true,
                                value: '',
                                label: "Дата последнего обновления документов по API"
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
                            city_id: {
                                type: 'autocomplete',
                                label: 'Город',
                                value: '',
                                dropdown: true,
                                optionLabel: 'name',
                                searchType: 'custom',
                                searchUrl: `/api/system/geo/city/`
                            },
                            address: {
                                type: 'autocomplete',
                                value: '',
                                label: "Адрес",
                                searchType: "address",
                            },
                            coordinates: {
                                type: 'text',
                                value: '',
                                label: "Координаты для карты"
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
                            marketplace: {
                                type: 'checkbox',
                                value: '',
                                label: "Доступна для розницы"
                            },
                            opt_marketplace: {
                                type: 'checkbox',
                                value: '',
                                label: "Доступна для Закупок"
                            }
                        }
                    }, {
                        class: "d-col-md-24",
                        wrapClass: 'fieldset',
                        fields: {
                            header: {
                                type: 'header',
                                label: 'Флаги слежки за API',
                                description: 'На основании этих параметров осуществляется контроль обмена информации и отключение Точки продаж при потери связи.',
                            },
                            integration_type: {
                                type: 'select',
                                value: '',
                                label: "Тип интеграции",
                                options: [{
                                        name: "Модуль 1С",
                                        code: 1,
                                    },
                                    {
                                        name: "YML файл",
                                        code: 2,
                                    },
                                    {
                                        name: "Excel файл",
                                        code: 3,
                                    }]
                            },
                            yml_file: {
                                type: 'text',
                                value: '',
                                label: "Ссылка на YML файл"
                            },
                            check_remains: {
                                type: 'checkbox',
                                value: '',
                                label: "Следить за обменом остатков"
                            },
                            check_docs: {
                                type: 'checkbox',
                                value: '',
                                label: "Следить за обменом документов"
                            }
                        }
                    }]
                }];
            }

        }
    }
}
</script>

<style>

</style>
