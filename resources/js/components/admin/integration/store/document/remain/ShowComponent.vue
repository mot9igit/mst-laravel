<template>
    <div class="dart-container">
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.documentRemainTable.filters"
                    :items_data="docRemains.data"
                    :total="docRemains.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.documentRemainTable.page"
                    :table_data="this.documentRemainTable.table_data"
                    title="Номенклатура документа"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div class="dart-mb-1">
                            <button class="btn btn-primary" @click.prevent="() => { this.price_id = 0; this.createRemainPriceWindow = true, this.createWindow.title = this.createTitle}"> Создать номенклатуру </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="createDocRemainWindow"
            @cancel="cancel"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-document-remain-component @close="close()" :document_id="this.document_id" :id="this.createWindow.id"></create-document-remain-component>
        </customModal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import CreateRemainPriceComponent from "@/components/admin/integration/store/remain/price/CreateComponent.vue";
import CreateDocumentRemainComponent from "@/components/admin/integration/store/document/remain/CreateComponent.vue";

export default {
    name: "ShowDocumentRemainComponent",
    props: {
        document_id: {
            type: Number,
            default: 0,
        },
        pagination_items_per_page: {
            type: Number,
            default: 24,
        },
        pagination_offset: {
            type: Number,
            default: 0,
        }
    },
    data() {
        return {
            createDocRemainWindow: false,
            createWindow: {
                title: "",
                id: 0,
            },
            createTitle: "Создать номенклатуру",
            updateTitle: "Редактировать номенклатуру",
            confirm: null,
            toast: null,
            documentRemainTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {},
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    name: {
                        label: 'Наименование',
                        type: 'text',
                    },
                    guid: {
                        label: 'GUID',
                        type: 'text',
                    },
                    price: {
                        label: 'Цена',
                        type: 'text',
                    },
                    description: {
                        label: 'Описание',
                        type: 'text'
                    },
                    actions: {
                        label: 'Действия',
                        type: 'actions',
                        sort: false,
                        available: {
                            edit: {
                                icon: 'bi bi-pencil',
                                label: 'Редактировать'
                            },
                            delete: {
                                icon: 'bi bi-trash',
                                label: 'Удалить'
                            }
                        }
                    }
                },
            }
        };
    },
    methods: {
        ...mapActions([
            'getDocRemains'
        ]),
        close(){
            this.createDocRemainWindow = false
            this.getDocRemains({
                docId: this.document_id,
                remainId: this.remain_id,
                page: this.documentRemainTable.page,
                perpage: this.pagination_items_per_page
            })
        },
        filter (data) {
            this.documentRemainTable.page = 1
            data.docId = this.document_id
            data.remainId = this.remain_id
            this.getDocRemains(data)
        },
        paginate (data) {
            this.documentRemainTable.page = data.page
            data.docId = this.document_id
            data.remainId = this.remain_id
            this.getDocRemains(data)
        },
        editElem(data){
            this.document_id = data.doc_id
            this.createWindow.title = this.updateTitle
            this.createWindow.id = data.id;
            this.createDocRemainWindow = true
        },
        deleteElem (data) {
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить цену - ${data.name}?`,
                header: 'Подтверждение',
                icon: 'bi bi-exclamation-triangle',
                rejectProps: {
                    label: 'Отмена',
                    severity: 'secondary',
                    outlined: true
                },
                acceptProps: {
                    label: 'Да'
                },
                accept: () => {
                    return this.$api.base.delete(`/api/integration/store/${this.store_id}/remain/${this.remain_id}/price/${data.id}`)
                        .then((response) => {
                            this.documentRemainTable.page = 1
                            this.getRemainPrices({
                                docId: this.document_id,
                                remainId: this.remain_id,
                                page: this.documentRemainTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.documentRemainTable.page = 1
                                this.getRemainPrices({
                                    storeId: this.store_id,
                                    remainId: this.remain_id,
                                    page: this.documentRemainTable.page,
                                    perpage: this.pagination_items_per_page
                                })
                            }
                        })
                },
                reject: () => {
                    this.$toast.add({ severity: 'error', summary: 'Отмена', detail: 'Действие отменено', life: 3000 });
                }
            });
        }
    },
    mounted() {
        this.getDocRemains({
            docId: this.document_id,
            remainId: this.remain_id,
            page: this.documentRemainTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        CreateDocumentRemainComponent,
        customModal,
        CreateRemainPriceComponent,
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "docRemains"
        ])
    },
    watch: {
    },
};
</script>

<style lang="scss">
.img_abs img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
}
</style>
