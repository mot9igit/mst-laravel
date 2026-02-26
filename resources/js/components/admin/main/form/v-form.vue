<template>
    <form @submit.prevent="submit()" :method="this.method" autocomplete="off">
        <div class="card-header">
            <div class="card-title" v-if="this.title">{{ this.title }}</div>
            <slot name="header"></slot>
        </div>
        <div class="card-body">
            <div class="dart_container">
                <div class="row" v-for="row in form_data">
                    <div v-for="grid in row.grids" :class="grid.class? grid.class : 'd-col-24'">
                        <div v-for="(field, key) in grid.fields" class="mb-3">
                            <div class="" v-if="field.type == 'text'">
                                <FloatLabel variant="on">
                                    <InputText :name="key" :id="key" v-model="form[key]" autocomplete="off"/>
                                    <label :for="key">{{ field.label }}</label>
                                </FloatLabel>
                                <div v-if="field.description" class="form-text">
                                    {{ field.description }}
                                </div>
                                <div v-if="errors[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                            </div>
                            <div class="" v-if="field.type == 'password'">
                                <FloatLabel variant="on">
                                    <Password :name="key" :id="key" v-model="form[key]" autocomplete="new-password"/>
                                    <label :for="key">{{ field.label }}</label>
                                </FloatLabel>
                                <div v-if="field.description" class="form-text">
                                    {{ field.description }}
                                </div>
                                <div v-if="errors[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                            </div>
                            <div class="" v-if="field.type == 'checkbox'">
                                <div class="flex items-center">
                                    <Checkbox v-model="form[key]" :inputId="key" :name="key" :id="key" binary/>
                                    <label :for="key"> {{ field.label }} </label>
                                </div>
                                <div v-if="field.description" class="form-text">
                                    {{ field.description }}
                                </div>
                                <div v-if="errors[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                            </div>
                            <div class="" v-if="field.type == 'textarea'">
                                <FloatLabel variant="on">
                                    <Textarea class="p-inputtext p-component" :name="key" :id="key" v-model="form[key]" style="width: 100%;resize: none" />
                                    <label for="on_label">{{ field.label }}</label>
                                </FloatLabel>
                                <div v-if="field.description" class="form-text">
                                    {{ field.description }}
                                </div>
                                <div v-if="errors[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                            </div>
                            <div class="" v-if="field.type == 'richtext'">
                                <label :for="key" class="form-label">{{ field.label }}</label>
                                <QuillEditor theme="snow" toolbar="full"/>
                                <div v-if="errors[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
        <div class="card-footer">
            <button class="btn btn-primary" type="button" disabled v-if="loading">
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">Загрузка...</span>
            </button>
            <button type="submit" class="btn btn-success" v-else>{{ submit_text? submit_text : 'Отправить' }}</button>
        </div>
    </form>
</template>
<script>
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Checkbox from "primevue/checkbox";
import Password from 'primevue/password';
import { VueEditor, Quill } from "vue2-editor";


export default {
    name: "vForm",
    components: {
        FloatLabel,
        InputText,
        VueEditor,
        Checkbox,
        Password
    },
    props: {
        // данные формы, включая layout по дефолтной сетке (x24grid)
        form_data: {
            type: Array,
            default: () => {
                return [];
            },
        },
        // заголовок формы
        title: {
            type: String,
            default: null,
        },
        // надпись на кнопке
        submit_text: {
            type: String,
            default: null,
        },
        // URL куда отправить данные
        form_url: {
            type: String,
            default: null,
        },
        // Редирект, если все хорошо
        redirect_url: {
            type: String,
            default: null,
        }
    },
    data() {
        return {
            loading: false,
            content: "",
            form: {},
            errors: {}
        }
    },
    mounted(){
        console.log(this.form_data)
    },
    methods: {
        submit(){
            this.loading = true
            axios.post(this.form_url, this.form)
                .then(res => {
                    if(this.redirect_url){
                        window.location.href = this.redirect_url;
                    }
                })
                .catch((error) => {
                    this.errors = error.response?.data?.errors
                    this.loading = false
                });
        }
    }
}
</script>

<style lang="scss">
    .ql-toolbar.ql-snow{
        border-radius: 6px 6px 0 0;
    }
    .ql-container{
        border-radius: 0 0 6px 6px;
    }
    .ql-editor{
        background: #fff;
    }
    .p-checkbox + label{
        margin-left: 10px;
    }
    .flex{
        display: flex;
    }
    .items-center{
        align-items: center;
    }
</style>
