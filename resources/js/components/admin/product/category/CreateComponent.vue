<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            redirect_url="/adm/product/category/"
            :form_data="this.formData"
            :form_values="this.form"
        />
    </div>
</template>

<script>
import vForm from '../../main/form/v-form.vue';
import {mapActions, mapGetters} from "vuex";

export default {
    name: "CreateProductCategoryComponent",
    props: {
        category_id: {
            type: Number,
            default: 0
        }
    },
    components: {
        vForm
    },
    data() {
        return {
            form: {},
        }
    },
    mounted(){
        if(this.category_id > 0) {
            const reqData = {
                category_id: this.category_id
            }
            this.getProductCategory(reqData).then(() => {
                this.form.title = this.productCategory.title;
                this.form.longtitle = this.productCategory.longtitle;
                this.form.thumb_url = this.productCategory.thumb_url;
                this.form.slug = this.productCategory.slug;
                this.form.parent_id = this.productCategory.parent_id;
                this.form.description = this.productCategory.description;
                this.form.published = Boolean(this.productCategory.published);
                this.form.show_in_menu = Boolean(this.productCategory.show_in_menu);
                this.form.seo_title = this.productCategory.seo_title;
                this.form.seo_description = this.productCategory.seo_description;
            })
        }
        this.form.category_id = this.category_id
    },
    methods: {
        ...mapActions([
            'getProductCategory'
        ])
    },
    computed: {
        ...mapGetters([
            'productCategory'
        ]),
        formUrl(){
            if (Number(this.category_id) > 0) {
                return '/api/product/category/' + this.category_id;
            } else {
                return '/api/product/category';
            }
        },
        headerForm() {
            if (Number(this.category_id) > 0) {
                return 'Редактировать категорию';
            } else {
                return 'Создать категорию';
            }
        },
        submitText(){
            if(Number(this.category_id) > 0){
                return 'Редактировать категорию';
            }else{
                return 'Создать категорию';
            }
        },
        mode(){
            if(Number(this.category_id) > 0){
                return 'update';
            }else{
                return 'create';
            }
        },
        formData(){
            return [{
                grids: [{
                    class: "d-col-md-24",
                    fields: {
                        title: {
                            type: 'text',
                            value: '',
                            label: "Наименование"
                        },
                        longtitle: {
                            type: 'text',
                            value: '',
                            label: "Расширенный заголовок"
                        },
                        image: {
                            type: 'image',
                            value: '',
                            defaultValue: 'thumb_url',
                            label: "Изображение"
                        },
                        slug: {
                            type: 'text',
                            value: '',
                            label: "Псевдоним"
                        },
                        parent_id: {
                            type: 'text',
                            value: '',
                            label: "Родитель"
                        }
                    }
                },{
                    class: "d-col-md-24",
                    fields: {
                        description: {
                            type: 'textarea',
                            value: '',
                            label: "Описание"
                        },
                        published: {
                            type: 'checkbox',
                            value: '',
                            label: "Опубликована"
                        },
                        show_in_menu: {
                            type: 'checkbox',
                            value: '',
                            label: "Показывать в меню"
                        },
                    },
                },{
                    class: "d-col-md-24",
                    fields: {
                        header: {
                            type: 'header',
                            label: "SEO"
                        },
                        seo_title: {
                            type: 'text',
                            value: '',
                            label: "Заголовок (title)"
                        },
                        seo_description: {
                            type: 'text',
                            value: '',
                            label: "Описание (description)"
                        }
                    }
                }]
            }]
        }
    }
}
</script>

<style scoped>

</style>
