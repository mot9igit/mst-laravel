<template>
    <div>
        <vForm
            title="Создание новой категории"
            submit_text="Создать категорию"
            method="post"
            form_url="/api/product/category"
            redirect_url="/adm/product/category/"
            :form_data="this.formData"
        />
    </div>
</template>

<script>
import vForm from '../../main/form/v-form.vue';

export default {
    name: "CreateProductCategoryComponent",
    components: {
        vForm
    },
    data() {
        return {
            // 1 уровень - срока, 2 уровень сетка, 3 уровень - поле
            formData: [{
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
    },
    methods: {
        addCategory(){
            axios.post('/api/product/category', this.form)
                .then(res => {
                    window.location.href = "/adm/products/categories/";
                })
                .catch((error) => {
                    this.errors = error.response?.data?.errors
                });
        }
    }
}
</script>

<style scoped>

</style>
