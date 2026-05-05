<template>
    <div class="dart-container">
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.remainTable.filters"
                    :items_data="remains.data"
                    :total="remains.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.remainTable.page"
                    :table_data="this.remainTable.table_data"
                    title="Номенклатура"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="() => { this.remain_id = 0; this.createRemainWindow = true, this.createWindow.title = this.createTitle}"> Создать номенклатуру </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="createRemainWindow"
            @cancel="cancel"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-remain-component :store_id="this.store_id" :remain_id="this.remain_id"></create-remain-component>
        </customModal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import CreateRemainComponent from "@/components/admin/integration/store/remain/CreateComponent.vue";

export default {
    name: "ShowRemain",
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
            remain_id: 0,
            createRemainWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать номенклатуру",
            updateTitle: "Редактировать редактировать номенклатуру",
            confirm: null,
            toast: null,
            remainTable:{
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
                        label: 'Активна',
                        type: 'boolean',
                        sort: true,
                    },
                    published: {
                        label: 'Опубликована',
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
            'getRemains'
        ]),
        filter (data) {
            data.storeId = this.store_id
            this.getRemains(data)
        },
        paginate (data) {
            this.remainTable.page = data.page
            data.storeId = this.store_id
            this.getRemains(data)
        },
        editElem(data){
            this.remain_id = data.id
            this.createWindow.title = this.updateTitle
            this.createRemainWindow = true
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить номенклатуру - ${data.name}?`,
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
                    return this.$api.base.delete(`/api/integration/store/${this.store_id}/remain/${data.id}`)
                        .then((response) => {
                            this.remainTable.page = 1
                            this.getRemains({
                                storeId: this.store_id,
                                page: this.remainTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            // console.log(error)
                            if (error.response.status === 404) {
                                this.remainTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getRemains({
                                    storeId: this.store_id,
                                    page: this.remainTable.page,
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
        this.getRemains({
            storeId: this.store_id,
            page: this.remainTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        customModal,
        CreateRemainComponent,
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "remains"
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
