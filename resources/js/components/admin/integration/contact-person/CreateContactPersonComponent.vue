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
    name: "CreateContactPersonComponent",
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
                    class: "d-col-md-24",
                    fields: {
                        name: {
                            type: 'text',
                            label: "Имя",
                            value: '',
                            dropdown: false,
                        },
                        phone: {
                            type: 'text',
                            label: "Телефон",
                            value: '',
                            dropdown: false,
                        },
                        email: {
                            type: 'text',
                            label: 'Email',
                            value: '',
                            dropdown: false,
                        },
                        description: {
                            type: 'textarea',
                            label: 'Описание',
                            value: '',
                            dropdown: false,
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
            return `/api/integration/contact-person`;
        },
        headerForm() {
            return 'Создать контактное лицо';
        },
        submitText() {
            return 'Создать контактное лицо';
        },
        mode() {
            return 'create';
        },
    }
}
</script>
