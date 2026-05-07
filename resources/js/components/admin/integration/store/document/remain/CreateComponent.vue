<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            :form_data="this.formData"
            :form_values="this.form"
            @close="close()"
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
    name: "CreateDocumentRemainComponent",
    emits: [
        'close'
    ],
    props: {
        document_id: {
            type: Number,
            default: 0
        },
        id: {
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
        if(this.id > 0) {
            const reqData = {
                id: this.id,
            }
            this.getDocRemain(reqData).then(() => {
                this.form.doc_id = this.id;
                this.form.remain_id = this.docRemain.remain_id;
                this.form.guid = this.docRemain.guid;
                this.form.type = this.docRemain.type;
                this.form.article = this.docRemain.article;
                this.form.count = this.docRemain.count;
                this.form.price = this.docRemain.price;
                this.form.description = this.docRemain.description;
                this.form.properties = this.docRemain.properties;
            })
        }
        this.form.doc_id = this.doc_id
        this.form.remain_id = this.remain_id
    },
    methods: {
        ...mapActions([
            'getDocRemain'
        ]),
        close(){
            this.$emit('close')
        }
    },
    computed: {
        ...mapGetters([
            'docRemain'
        ]),
        formUrl() {
            if (Number(this.id) > 0) {
                return `/api/integration/store/document/remain/${this.id}`;
            } else {
                return `/api/integration/store/document/remain`;
            }
        },
        headerForm() {
            if (Number(this.id) > 0) {
                return 'Редактировать номенклатуру';
            } else {
                return 'Создать номенклатуру';
            }
        },
        submitText() {
            if(Number(this.id) > 0){
                return 'Редактировать номенклатуру';
            }else{
                return 'Создать номенклатуру';
            }
        },
        mode() {
            if(Number(this.id) > 0){
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
                        type: {
                            type: 'autocomplete',
                            value: '',
                            dropdown: true,
                            optionLabel: 'type',
                            label: "Тип",
                            searchType: 'custom',
                            searchUrl: `/api/enums/StoreDocRemainType/`
                        },
                        remain_id: {
                            type: 'autocomplete',
                            value: '',
                            dropdown: true,
                            optionLabel: 'remain',
                            label: "Номенклатура",
                            searchType: 'custom',
                            searchUrl: `/api/integration/store/${this.store_id}/remain`
                        },
                        guid: {
                            type: 'text',
                            label: "GUID",
                            value: ''
                        },
                        article: {
                            type: 'text',
                            label: "Артикль",
                            value: ''
                        },
                        description: {
                            type: 'textarea',
                            label: "Описание",
                            value: ''
                        }
                    }
                }]
            }];
        },
    }
}
</script>
<style lang="scss">

</style>
