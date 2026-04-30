<template>
    <div class="dart-container">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.catalogTable.filters"
                    :items_data="catalogs.data"
                    :total="catalogs.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.catalogTable.page"
                    :table_data="this.catalogTable.table_data"
                    title="Каталоги"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="() => { this.catalog_id = 0; this.createCatalogWindow = true, this.createWindow.title = this.createTitle}"> Создать каталог </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="createCatalogWindow"
            @cancel="cancel"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-catalog-component :store_id="this.store_id" :catalog_id="this.catalog_id"></create-catalog-component>
        </customModal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "@/components/admin/main/table/v-table.vue";
import Axios from "axios";
import customModal from "@/shared/ui/Modal.vue";
import CreateCatalogComponent from "@/components/admin/integration/store/remain-catalog/CreateComponent.vue";

export default {
    name: "Catalogs",
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
            catalog_id: 0,
            createCatalogWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать каталог",
            updateTitle: "Редактировать каталог",
            confirm: null,
            toast: null,
            catalogTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "Наименование",
                        placeholder: "Наименование",
                        type: "text",
                    }
                },
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
                    parent_guid: {
                        label: 'GUID родителя',
                        type: 'text',
                    },
                    active: {
                        label: 'Активен',
                        type: 'boolean',
                        sort: true,
                    },
                    published: {
                        label: 'Опубликован',
                        type: 'boolean',
                        sort: true,
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
            'getCatalogs'
        ]),
        filter (data) {
            data.storeId = this.store_id
            this.getCatalogs(data)
        },
        paginate (data) {
            this.catalogTable.page = data.page
            data.storeId = this.store_id
            this.getCatalogs(data)
        },
        editElem(data){
            this.catalog_id = data.id
            this.createWindow.title = this.updateTitle
            this.createCatalogWindow = true
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить точку продаж - ${data.name}?`,
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
                    return this.$api.base.delete(`/api/integration/store/${this.store_id}/catalog/${data.id}`)
                        .then((response) => {
                            this.catalogTable.page = 1
                            this.getCatalogs({
                                storeId: this.store_id,
                                page: this.catalogTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.storeTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getCatalogs({
                                    storeId: this.store_id,
                                    page: this.catalogTable.page,
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
        this.getCatalogs({
            storeId: this.store_id,
            page: this.catalogTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        customModal, CreateCatalogComponent,
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "catalogs"
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
