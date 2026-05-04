<template>
    <div>
        <vForm
            v-if="this.mode == 'create'"
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
        <div v-else>
            <Tabs value="0" scrollable>
                <TabList>
                    <Tab value="0">
                        Номенклатура
                    </Tab>
                    <Tab value="1">
                        Цены
                    </Tab>
                    <Tab value="2">
                        История изменения
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
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
                    </TabPanel>
                    <TabPanel value="1">
                        <show-remain-price-component :store_id="this.store_id" :remain_id="this.remain_id"></show-remain-price-component>
                    </TabPanel>
                    <TabPanel value="2">
                        История изменения
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
    </div>
</template>
<script>
import vForm from "@/components/admin/main/form/v-form.vue";
import {mapActions, mapGetters} from "vuex";
import ShowRemainPriceComponent from '@/components/admin/integration/store/remain/price/ShowComponent.vue'
import TabList from "primevue/tablist";
import Tabs from "primevue/tabs";
import TabPanel from "primevue/tabpanel";
import TabPanels from "primevue/tabpanels";
import Tab from "primevue/tab";

export default{
    name: "CreateRemainComponent",
    props: {
        remain_id: {
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
        Tab,
        TabPanels,
        TabPanel,
        Tabs,
        TabList,
        vForm,
        ShowRemainPriceComponent
    },
    mounted(){
        if(this.remain_id > 0) {
            const reqData = {
                remainId: this.remain_id
            }
            this.getRemain(reqData).then(() => {
                this.form.name = this.remain.name;
                this.form.catalog_id = this.remain.category;
                this.form.vendor_id = this.remain.vendor;
                this.form.product_id = this.remain.product;
                this.form.description = this.remain.description;
                this.form.tags = this.remain.tags;

                this.form.guid = this.remain.guid;
                this.form.barcode = this.remain.barcode;
                this.form.catalog_guid = this.remain.catalog_guid;
                this.form.parent_id = this.remain.parent;
                this.form.article = this.remain.article;

                this.form.available = this.remain.available;
                this.form.remains = this.remain.remains;
                this.form.reserved = this.remain.reserved;
                this.form.price = this.remain.price;

                this.form.published = Boolean(this.remain.published);
                this.form.brand_manual = Boolean(this.remain.brand_manual);
                this.form.article_manual = Boolean(this.remain.article_manual);
            })
        }
        this.form.remain_id = this.remain_id
        this.form.store_id = this.store_id
    },
    methods: {
        ...mapActions([
            'getRemain'
        ])
    },
    computed: {
        ...mapGetters([
            'remain'
        ]),
        formUrl() {
            if (Number(this.remain_id) > 0) {
                return `/api/integration/store/${this.store_id}/remain/${this.remain_id}`;
            } else {
                return `/api/integration/store/${this.store_id}/remain/`;
            }
        },
        headerForm() {
            if (Number(this.remain_id) > 0) {
                return 'Редактировать номенклатуру';
            } else {
                return 'Создать номенклатуру';
            }
        },
        submitText() {
            if(Number(this.remain_id) > 0){
                return 'Редактировать номенклатуру';
            }else{
                return 'Создать номенклатуру';
            }
        },
        mode() {
            if(Number(this.remain_id) > 0){
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
                        catalog_id: {
                            type: 'autocomplete',
                            label: 'Каталог СИ',
                            value: '',
                            dropdown: true,
                            optionLabel: 'name',
                            searchType: 'custom',
                            searchUrl: `api/integration/store/${this.store_id}/catalog`
                        },
                        status: {
                            type: 'autocomplete',
                            value: '',
                            dropdown: true,
                            optionLabel: 'name',
                            label: "Статус",
                            searchType: 'custom',
                            searchUrl: `/api/enums/StoreRemainStatus/`
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
                            label: 'Наличие',
                        },
                        remains: {
                            type: 'number',
                            fractionDigits: 0,
                            suffix: ' шт.',
                            label: "Остаток",
                            value: ''
                        },
                        reserved: {
                            type: 'number',
                            fractionDigits: 0,
                            suffix: ' шт.',
                            label: "Резерв",
                            value: ''
                        },
                        available: {
                            type: 'number',
                            fractionDigits: 0,
                            suffix: ' шт.',
                            label: "Доступно",
                            value: ''
                        },
                        price: {
                            type: 'number',
                            fractionDigits: 2,
                            suffix: ' ₽',
                            label: "Цена",
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
                        },
                        published: {
                            type: 'checkbox',
                            label: "Опубликован",
                            value: ''
                        },
                        brand_manual: {
                            type: 'checkbox',
                            label: "Бренд установлен вручную",
                            value: ''
                        },
                        article_manual: {
                            type: 'checkbox',
                            label: "Артикул установлен вручную",
                            value: ''
                        }
                    }
                }, {
                    class: "d-col-md-24",
                    wrapClass: 'fieldset',
                    fields: {
                        header: {
                            type: 'header',
                            label: 'Идентификаторы номенклатуры'
                        },
                        guid: {
                            type: 'text',
                            label: 'GUID'
                        },
                        // base_guid: {
                        //     type: 'text',
                        //     label: 'GUID БД'
                        // },
                        catalog_guid: {
                            type: 'text',
                            label: 'GUID родителя'
                        },
                        article: {
                            type: 'text',
                            label: 'Артикул'
                        },
                        barcode: {
                            type: 'text',
                            label: 'Штрихкод'
                        },
                        // TODO: товары
                        vendor_id: {
                            type: 'autocomplete',
                            label: 'Производитель',
                            value: '',
                            dropdown: true,
                            optionLabel: 'name',
                            searchType: 'custom',
                            searchUrl: `/api/product/vendor`
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
