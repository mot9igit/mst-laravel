import Axios from 'axios'

export default {
    state: {
        productCategoryTree: {},
        productCategories: {}
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
        getProductCategories ({ commit }) {
            return Axios('/api/product/category/', {
                method: 'GET',
                params: {
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
        }
    },
    mutations: {
        SET_PRODUCT_CATEGORY_TREE: (state, data) => {
            state.productCategoryTree = data
        },
        SET_PRODUCT_CATEGORIES: (state, data) => {
            state.productCategories = data
        }
    },
    getters: {
        productCategoryTree (state) {
            return state.productCategoryTree
        },
        productCategories (state) {
            return state.productCategories
        }
    }
}
