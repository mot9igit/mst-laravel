<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            :redirect_url="'/adm/organization/' + this.org_id"
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

export default {
    name: "LinkStoreComponent",
    components: {
        vForm
    },
    props: {
        org_id: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            formData: [{
                grids: [{
                    class: "d-col-md-12",
                    fields: {
                        store_id: {
                            type: 'autocomplete',
                            label: "Точка продаж",
                            value: '',
                            dropdown: true,
                            optionLabel: 'name',
                            searchType: 'custom',
                            searchUrl: `/api/integration/store`
                        },
                        dropshipping: {
                            type: 'checkbox',
                            value: '',
                            label: "Дропшиппинг"
                        },
                        description: {
                            type: 'textarea',
                            value: '',
                            label: "Описание"
                        }
                    }
                }]
            }],
            form: {},
        }
    },
    mounted(){
        this.form.org_id = this.org_id
    },
    computed: {
        formUrl() {
            return `/api/integration/organization/${this.org_id}/store`;
        },
        headerForm() {
            return 'Привязать точку продаж';
        },
        submitText() {
            return 'Привязать точку продаж';
        },
        mode() {
            return 'create';
        },
    }
}
</script>
