export default {
    state: {
        catalogs: {},
        catalog: {}
    },
    actions: {
        getCatalogs ({ commit }, {storeId, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.remainCatalog.getCatalogs(storeId, payload).then((response) => {
                commit('SET_CATALOGS', response.data)
            })
        },
        getCatalog ({ commit }, {storeId, catalogId}) {
            return this.$app.config.globalProperties.$api.remainCatalog.getCatalog(storeId, catalogId).then((response) => {
                commit('SET_CATALOG', response.data)
            })
        }
    },
    mutations: {
        SET_CATALOGS: (state, data) => {
            state.catalogs = data
        },
        SET_CATALOG: (state, data) => {
            state.catalog = data
        }
    },
    getters: {
        catalogs (state) {
            return state.catalogs
        },
        catalog (state) {
            return state.catalog
        }
    }
}
