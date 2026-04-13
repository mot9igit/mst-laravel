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
import vForm from "../../main/form/v-form.vue";
export default {
    name: "LinkUserComponent",
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
                        user_id: {
                            type: 'autocomplete',
                            label: "Пользователь",
                            value: '',
                            dropdown: true,
                            optionLabel: 'email',
                            searchType: 'custom',
                            searchUrl: `/api/users`
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
            return `/api/integration/organization/${this.org_id}/user`;
        },
        headerForm() {
            return 'Привязать пользователя';
        },
        submitText() {
            return 'Привязать пользователя';
        },
        mode() {
            return 'create';
        },
    }
}
</script>
