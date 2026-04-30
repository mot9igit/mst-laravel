<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            :redirect_url="'/adm/store/' + this.store_id"
            :form_data="this.formData"
            :form_values="this.form"
        >
            <template #header="{ title }">
                <div></div>
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
import vForm from "@/components/admin/main/form/v-form.vue";
import {mapActions, mapGetters} from "vuex";

export default{
    name: "CreateCatalogComponent",
    props: {
        catalog_id: {
            type: Number,
            default: 0
        },
        store_id: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            form: {},
        }
    },
    components: {
        vForm
    },
    mounted(){
        if(this.catalog_id > 0) {
            const reqData = {
                catalogId: this.catalog_id
            }
            this.getCatalog(reqData).then(() => {
                this.form.name = this.catalog.name;
                this.form.name_alt = this.catalog.name_alt;
                this.form.guid = this.catalog.guid;
                this.form.base_guid = this.catalog.base_guid;
                this.form.parent_guid = this.catalog.parent_guid;
                this.form.parent_id = this.catalog.parent;
                this.form.description = this.catalog.description;
                this.form.active = Boolean(this.catalog.active);
                this.form.published = Boolean(this.catalog.published);
            })
        }
        this.form.catalog_id = this.catalog_id
        this.form.store_id = this.store_id
    },
    methods: {
        ...mapActions([
            'getCatalog'
        ])
    },
    computed: {
        ...mapGetters([
            'catalog'
        ]),
        formUrl() {
            if (Number(this.catalog_id) > 0) {
                return `/api/integration/store/${this.store_id}/catalog/${this.catalog_id}`;
            } else {
                return `/api/integration/store/${this.store_id}/catalog/`;
            }
        },
        headerForm() {
            if (Number(this.catalog_id) > 0) {
                return 'Редактировать каталог';
            } else {
                return 'Создать каталог';
            }
        },
        submitText() {
            if(Number(this.catalog_id) > 0){
                return 'Редактировать каталог';
            }else{
                return 'Создать каталог';
            }
        },
        mode() {
            if(Number(this.catalog_id) > 0){
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
                        name: {
                            type: 'text',
                            label: "Наименование",
                            value: ''
                        },
                        name_alt: {
                            type: 'text',
                            label: "Наименование в системе",
                            value: ''
                        },
                        description: {
                            type: 'textarea',
                            label: "Описание",
                            value: ''
                        }
                    }
                }, {
                    class: "d-col-md-24",
                    wrapClass: 'fieldset',
                    fields: {
                        header: {
                            type: 'header',
                            label: 'Флаги публикации',
                            description: 'На основании этих параметров осуществляется вывод каталога в модуле \'Закупки\'.',
                        },
                        active: {
                            type: 'checkbox',
                            label: "Активен",
                            value: ''
                        },
                        published: {
                            type: 'checkbox',
                            label: "Опубликован",
                            value: ''
                        }
                    }
                }, {
                    class: "d-col-md-24",
                    wrapClass: 'fieldset',
                    fields: {
                        header: {
                            type: 'header',
                            label: 'Идентификаторы'
                        },
                        guid: {
                            type: 'text',
                            label: 'GUID'
                        },
                        base_guid: {
                            type: 'text',
                            label: 'GUID БД'
                        },
                        parent_guid: {
                            type: 'text',
                            label: 'GUID родителя'
                        },
                    }
                }]
            }];
        },
    }
}
</script>
<style lang="scss">

</style>
