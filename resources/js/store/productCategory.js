import Axios from 'axios'

export default {
    state: {
        productCategoryTree: {},
        productCategories: {},
        productCategory: {}
    },
    actions: {
        getProductCategoryTree ({ commit }) {
            const payload = {
                tree: 1
            }
            return this.$app.config.globalProperties.$api.productCategory.getProductCategories(payload).then((response) => {
                commit('SET_PRODUCT_CATEGORY_TREE', response.data)
            })
        },
        getProductCategories ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage,
                tree: 0
            }
            return this.$app.config.globalProperties.$api.productCategory.getProductCategories(payload).then((response) => {
                commit('SET_PRODUCT_CATEGORIES', response.data)
            })
        },
        getProductCategory ({ commit }, {category_id}) {
            return this.$app.config.globalProperties.$api.productCategory.getProductCategory(category_id).then((response) => {
                commit('SET_PRODUCT_CATEGORY', response.data)
            })
        }
    },
    mutations: {
        SET_PRODUCT_CATEGORY_TREE: (state, data) => {
            state.productCategoryTree = data
        },
        SET_PRODUCT_CATEGORIES: (state, data) => {
            state.productCategories = data
        },
        SET_PRODUCT_CATEGORY: (state, data) => {
            state.productCategory = data
        }
    },
    getters: {
        productCategoryTree (state) {
            return state.productCategoryTree
        },
        productCategories (state) {
            return state.productCategories
        },
        productCategory (state) {
            return state.productCategory
        }
    }
}
