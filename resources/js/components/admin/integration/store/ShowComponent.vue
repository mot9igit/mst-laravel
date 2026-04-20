<template>
    <div class="dart-container">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.storeTable.filters"
                    :items_data="stores.data"
                    :total="stores.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.storeTable.page"
                    :table_data="this.storeTable.table_data"
                    title="Точки продаж"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <a href="/adm/store/create" class="btn btn-primary"> Создать точку продаж </a>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "../../../admin/main/table/v-table.vue";
import Axios from "axios";

export default {
    name: "Store",
    props: {
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
            confirm: null,
            toast: null,
            storeTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "Наименование",
                        placeholder: "Наименование, адрес",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    thumb_url: {
                        label: 'Изображение',
                        type: 'image',
                    },
                    name: {
                        label: 'Наименование',
                        type: 'text',
                    },
                    active: {
                        label: 'Активна',
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
            'getStores'
        ]),
        filter (data) {
            this.getStores(data)
        },
        paginate (data) {
            this.storeTable.page = data.page
            this.getStores(data)
        },
        editElem(data){
            window.location.href = '/adm/store/' + data.id
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
                    return this.$api.base.delete(`/api/integration/store/${data.id}`)
                        .then((response) => {
                            this.storeTable.page = 1
                            this.getStores({
                                page: this.storeTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.storeTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getStores({
                                    page: this.storeTable.page,
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
        this.getStores({
            page: this.storeTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "stores"
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
