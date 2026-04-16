export default {
    state: {
        stores: {},
        store: {}
    },
    actions: {
        getStores ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.store.getStores(payload).then((response) => {
                commit('SET_STORES', response.data)
            })
        },
        getStore ({ commit }, { storeId }) {
            return this.$app.config.globalProperties.$api.store.getStore(storeId).then((response) => {
                commit('SET_STORE', response.data)
            })
        }
    },
    mutations: {
        SET_STORE: (state, data) => {
            state.store = data
        },
        SET_STORES: (state, data) => {
            state.stores = data
        }
    },
    getters: {
        stores (state) {
            return state.stores
        },
        store (state) {
            return state.store
        }
    }
}
