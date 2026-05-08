<template>
    <div class="dart-container">
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.docTable.filters"
                    :items_data="docs.data"
                    :total="docs.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.docTable.page"
                    :table_data="this.docTable.table_data"
                    title="Документ"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="() => { this.doc_id = 0; this.createDocWindow = true, this.createWindow.title = this.createTitle}"> Создать документ </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="createDocWindow"
            @cancel="cancel"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-document-component :store_id="this.store_id" :doc_id="this.doc_id"></create-document-component>
        </customModal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import CreateDocumentComponent from "@/components/admin/integration/store/document/CreateComponent.vue";

export default {
    name: "ShowDoc",
    props: {
        store_id: {
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
            doc_id: 0,
            createDocWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать документ",
            updateTitle: "Редактировать документ",
            confirm: null,
            toast: null,
            docTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "Описание",
                        placeholder: "Описание",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    number: {
                        label: 'Номер',
                        type: 'text',
                    },
                    base_guid: {
                        label: "GUID ID",
                        type: "text",
                    },
                    guid: {
                        label: 'GUID',
                        type: 'text',
                    },
                    date: {
                        label: 'Дата',
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
            'getDocs'
        ]),
        filter (data) {
            data.storeId = this.store_id
            this.getDocs(data)
        },
        paginate (data) {
            this.docTable.page = data.page
            data.storeId = this.store_id
            this.getDocs(data)
        },
        editElem(data){
            this.doc_id = data.id
            this.createWindow.title = this.updateTitle
            this.createDocWindow = true
        },
        deleteElem (data) {
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить документ - ${data.name}?`,
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
                    return this.$api.base.delete(`/api/integration/store-doc/${this.store_id}/${data.id}`)
                        .then((response) => {
                            this.docTable.page = 1
                            this.getDocs({
                                storeId: this.store_id,
                                page: this.docTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.docTable.page = 1
                                this.getDocs({
                                    storeId: this.store_id,
                                    page: this.docTable.page,
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
        this.getDocs({
            storeId: this.store_id,
            page: this.docTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        CreateDocumentComponent,
        customModal,
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "docs"
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
