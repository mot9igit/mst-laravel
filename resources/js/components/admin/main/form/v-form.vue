<template>
    <form @submit.prevent="submit()" :method="this.method" autocomplete="off">
        <Toast />
        <div>
            <slot name="header" :title="this.title">
                <div class="card-header">
                    <div class="card-title" v-if="this.title">{{ this.title }}</div>
                </div>
            </slot>
        </div>
        <div :class="this.body_class">
            <div class="dart_container">
                <div class="row" v-for="row in form_data">
                    <div v-for="grid in row.grids" :class="grid.class? grid.class : 'd-col-24'">
                        <div v-for="(field, key) in grid.fields" class="mb-3">
                            <div class="" v-if="field.type == 'header'">
                                <h3>{{ field.label }}</h3>
                            </div>
                            <div class="" v-if="field.type == 'hidden'">
                                <input name="key" v-model="form[key]" type="hidden">
                            </div>
                            <div v-if="field.type == 'image'">
                                <label class="dart-simple-label" :for="'form_image_' + key">Изображение</label>
                                <div class="img_abs dart-mb-1" v-if="this.form[field.defaultValue]">
                                    <img :src="this.form[field.defaultValue]" alt="">
                                </div>

                                <FileUpload :id="'form_image_' + key" name="image[]" url="/api/upload" :auto="true" @before-send="beforeFileSend($event)" @upload="onAdvancedUpload($event)" :multiple="false" accept="image/*" :maxFileSize="2097152">
                                    <template #empty>
                                        <span>Перенесите файл в эту область для загрузки.</span>
                                    </template>
                                </FileUpload>
                                <div v-if="errors?.[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                                <div v-if="errors?.[field.errorKey]">
                                    <div class="text-danger" v-for="obj in errors[field.errorKey]">{{ obj }}</div>
                                </div>
                            </div>
                            <div class="" v-if="field.type == 'autocomplete'">
                                <FloatLabel variant="on">
                                    <AutoComplete :name="key" :id="key" v-model="form[key]" :dropdown="field.dropdown || false" :optionLabel="field.optionLabel || 'value'" :suggestions="items[key]" @complete="($event) => search($event, field, key)" @option-select="($event) => autocompleteSelect($event, field, key)" @dropdown-click="($event) => dropdownClick($event, field, key)" autocomplete="off"/>
                                    <label :for="key">{{ field.label }}</label>
                                </FloatLabel>
                                <div v-if="field.description" class="form-text">
                                    {{ field.description }}
                                </div>
                                <div v-if="errors?.[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                                <div v-if="errors?.[field.errorKey]">
                                    <div class="text-danger" v-for="obj in errors[field.errorKey]">{{ obj }}</div>
                                </div>
                            </div>
                            <div class="" v-if="field.type == 'text'">
                                <FloatLabel variant="on">
                                    <InputText :name="key" :id="key" v-model="form[key]" autocomplete="off"/>
                                    <label :for="key">{{ field.label }}</label>
                                </FloatLabel>
                                <div v-if="field.description" class="form-text">
                                    {{ field.description }}
                                </div>
                                <div v-if="errors?.[key]">
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
                                <div v-if="errors?.[key]">
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
                                <div v-if="errors?.[key]">
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
                                <div v-if="errors?.[key]">
                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>
                                </div>
                            </div>
<!--                            <div class="" v-if="field.type == 'richtext'">-->
<!--                                <label :for="key" class="form-label">{{ field.label }}</label>-->
<!--                                <QuillEditor theme="snow" toolbar="full"/>-->
<!--                                <div v-if="errors?.[key]">-->
<!--                                    <div class="text-danger" v-for="obj in errors[key]">{{ obj }}</div>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
        <div>
            <slot name="footer" :submit_text="submit_text" :loading="loading">
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" disabled v-if="loading">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Загрузка...</span>
                    </button>
                    <button type="submit" class="btn btn-success" v-else>{{ submit_text? submit_text : 'Отправить' }}</button>
                </div>
            </slot>
        </div>
    </form>
</template>
<script>
import Toast from 'primevue/toast';
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import AutoComplete from "primevue/autocomplete";
import Textarea from 'primevue/textarea';
import Checkbox from "primevue/checkbox";
import Password from 'primevue/password';
import FileUpload from 'primevue/fileupload';
// import { VueEditor, Quill } from "vue2-editor";


export default {
    name: "vForm",
    components: {
        FloatLabel,
        InputText,
        Textarea,
        Checkbox,
        AutoComplete,
        Password,
        FileUpload,
        Toast
    },
    props: {
        body_class: {
            type: String,
            default: "card-body",
        },
        // данные формы, включая layout по дефолтной сетке (x24grid)
        form_data: {
            type: Array,
            default: () => {
                return [];
            },
        },
        // значения формы
        form_values: {
            type: Object,
            default: () => {
                return {};
            },
        },
        // заголовок формы
        method: {
            type: String,
            default: "POST",
        },
        // режим работы формы
        mode: {
            type: String,
            default: "create",
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
        },
        // Папка для загрузки файлов
        uploadPath: {
            type: String,
            default: 'tmp',
        }
    },
    data() {
        return {
            loading: false,
            content: "",
            form: {},
            errors: {},
            items: {}
        }
    },
    mounted(){
        this.form = this.form_values
    },
    methods: {
        autocompleteSelect(event, value, key){
            if(value.searchType === 'inn') {
                this.form.inn = event?.value?.data?.inn
                if (event?.value?.value) {
                    this.form.name = event?.value?.value
                }
                if (event?.value?.data?.kpp) {
                    this.form.kpp = event?.value?.data?.kpp
                }
                if (event?.value?.data?.ogrn) {
                    this.form.ogrn = event?.value?.data?.ogrn
                }
            }
            if(value.searchType === 'address') {
                // console.log(event)
            }
        },
        dropdownClick(event, value, key){
            if(value.searchType === 'custom'){
                axios.get(value.searchUrl, { params: { filter: event.query}})
                    .then(res => {
                        this.items[key] = res.data.data
                    })
                    .catch((error) => {
                        this.errors = error.response?.data?.errors
                    });
            }
        },
        search(event, value, key){
            if(event.query){
                if(value.searchType === 'inn'){
                    this.$api.dadata.suggestionsCompany(event.query)
                        .then(res => {
                            this.items[key] = res.data
                        })
                }
                if(value.searchType === 'address'){
                    this.$api.dadata.suggestionsAddress(event.query)
                        .then(res => {
                            this.items[key] = res.data
                        })
                }
                if(value.searchType === 'custom'){
                    let params = { filter: event.query}
                    this.$api.base.get(value.searchUrl, params)
                        .then(res => {
                            this.items[key] = res.data.data
                        })
                }
            }
        },
        beforeFileSend($event){
            // console.log($event)
            let xsrf = this.$cookies.get('XSRF-TOKEN');
            $event.xhr.setRequestHeader('x-xsrf-token', xsrf);
            $event.formData.append('path', this.uploadPath)
            return $event;
        },
        onAdvancedUpload($event){
            let response = JSON.parse($event.xhr.responseText)
            // console.log(response)
            this.form.files = response?.files
        },
        submit(){
            this.loading = true
            this.errors = {}
            if(this.mode === 'create'){
                this.$api.base.post(this.form_url, this.form)
                    .then(res => {
                        if(this.redirect_url){
                            window.location.href = this.redirect_url;
                        }
                    })
                    .catch((error) => {
                        if(error.response?.data?.errors){
                            this.errors = error.response?.data?.errors
                        }
                        this.$toast.add({ severity: 'error', summary: "Ошибка!", detail: error.response?.data?.message, life: 5000 });
                        this.loading = false
                    });
            }
            if(this.mode === 'update'){
                this.$api.base.patch(this.form_url, this.form)
                    .then(res => {
                        if(this.redirect_url){
                            window.location.href = this.redirect_url;
                        }
                    })
                    .catch((error) => {
                        if(error.response?.data?.errors){
                            this.errors = error.response?.data?.errors
                        }
                        this.$toast.add({ severity: 'error', summary: "Ошибка!", detail: error.response?.data?.message, life: 5000 });
                        this.loading = false
                    });
            }

        }
    }
}
</script>

<style lang="scss">
    .dart-simple-label{
        font-size: 18px;
        display: block;
        margin-bottom: 8px;
    }
    .p-fileupload-file img{
        max-width: 200px;
        width: 100%;
        border-radius: 5px;
    }
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
