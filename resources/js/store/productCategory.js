import Axios from 'axios'

export default {
    state: {
        productCategoryTree: {},
        productCategories: {},
        productCategory: {}
    },
    actions: {
        getProductCategoryTree ({ commit }) {
            return Axios('/api/product/category/', {
                method: 'GET',
                params: {
                    tree: 1
                }
            })
                .then((response) => {
                    commit('SET_PRODUCT_CATEGORY_TREE', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        },
        getProductCategories ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            return Axios('/api/product/category/', {
                method: 'GET',
                params: {
                    filter: filter,
                    filtersdata: filtersdata,
                    sort: sort,
                    page: page,
                    perpage: perpage,
                    tree: 0
                }
            })
                .then((response) => {
                    commit('SET_PRODUCT_CATEGORIES', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
                })
        },
        getProductCategory ({ commit }, {category_id}) {
            return Axios(`/api/product/category/${category_id}`, {
                method: 'GET'
            })
                .then((response) => {
                    commit('SET_PRODUCT_CATEGORY', response.data)
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        // TODO: to auth page
                    }
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
