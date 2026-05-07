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
                        Документ
                    </Tab>
                    <Tab value="1">
                        Номенклатуры
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
                        <show-document-remain-component  :document_id="this.doc_id"></show-document-remain-component>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
    </div>
</template>
<script>
import vForm from "@/components/admin/main/form/v-form.vue";
import {mapActions, mapGetters} from "vuex";
import ShowRemainHistoryComponent from "@/components/admin/integration/store/remain/history/ShowComponent.vue";
import ShowRemainPriceComponent from "@/components/admin/integration/store/remain/price/ShowComponent.vue";
import Tab from "primevue/tab";
import TabPanels from "primevue/tabpanels";
import TabPanel from "primevue/tabpanel";
import Tabs from "primevue/tabs";
import TabList from "primevue/tablist";
import ShowDocumentRemainComponent from "@/components/admin/integration/store/document/remain/ShowComponent.vue";

export default{
    name: "CreateDocumentComponent",
    props: {
        doc_id: {
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
        ShowDocumentRemainComponent,
        vForm,
        Tab,
        TabPanels,
        TabPanel,
        Tabs,
        TabList,
    },
    mounted(){
        if(this.doc_id > 0) {
            const reqData = {
                storeId: this.store_id,
                docId: this.doc_id
            }
            this.getDoc(reqData).then(() => {
                this.form.number = this.doc.number;
                this.form.date = this.doc.date;
                this.form.guid = this.doc.guid;
                this.form.base_guid = this.doc.base_guid;
                this.form.description = this.doc.description;
            })
        }
        this.form.doc_id = this.doc_id
        this.form.store_id = this.store_id
    },
    methods: {
        ...mapActions([
            'getDoc'
        ])
    },
    computed: {
        ...mapGetters([
            'doc'
        ]),
        formUrl() {
            if (Number(this.doc_id) > 0) {
                return `/api/integration/store/document/${this.doc_id}`;
            } else {
                return `/api/integration/store/document`;
            }
        },
        headerForm() {
            if (Number(this.doc_id) > 0) {
                return 'Редактировать документ';
            } else {
                return 'Создать документ';
            }
        },
        submitText() {
            if(Number(this.doc_id) > 0){
                return 'Редактировать документ';
            }else{
                return 'Создать документ';
            }
        },
        mode() {
            if(Number(this.doc_id) > 0){
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
                        number: {
                            type: 'text',
                            label: "Номер документа",
                            value: ''
                        },
                        date: {
                            type: 'datetime',
                            label: "Дата",
                            value: ''
                        },

                        description: {
                            type: 'textarea',
                            label: "Описание",
                            value: ''
                        },
                    },
                },
                {
                    class: "d-col-md-24",
                    wrapClass: 'fieldset',
                    fields: {
                        header: {
                            type: 'header',
                            label: 'Идентификаторы'
                        },
                        guide: {
                            type: 'text',
                            label: 'ID базы',
                            value: ''
                        },
                        guide_id: {
                            type: 'text',
                            label: 'ID документа в базе',
                            value: ''
                        },
                    }
                    }
                ]
            }];
        },
    }
}
</script>
<style lang="scss">

</style>
