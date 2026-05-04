export default {
    state: {
        remains: {},
        remain: {},
        remainPrices: {},
        remainPrice: {}
    },
    actions: {
        getRemains ({ commit }, {storeId, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.remain.getRemains(storeId, payload).then((response) => {
                commit('SET_REMAINS', response.data)
            })
        },
        getRemain ({ commit }, {storeId, remainId}) {
            return this.$app.config.globalProperties.$api.remain.getRemain(storeId, remainId).then((response) => {
                commit('SET_REMAIN', response.data)
            })
        },
        getRemainPrices ({ commit }, {storeId, remainId, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.remain.getRemainPrices(storeId, remainId, payload).then((response) => {
                commit('SET_REMAIN_PRICES', response.data)
            })
        },
        getRemainPrice ({ commit }, {storeId, remainId, priceId}) {
            return this.$app.config.globalProperties.$api.remain.getRemainPrice(storeId, remainId, priceId).then((response) => {
                commit('SET_REMAIN_PRICE', response.data)
            })
        }
    },
    mutations: {
        SET_REMAINS: (state, data) => {
            state.remains = data
        },
        SET_REMAIN: (state, data) => {
            state.remain = data
        },
        SET_REMAIN_PRICES: (state, data) => {
            state.remainPrices = data
        },
        SET_REMAIN_PRICE: (state, data) => {
            state.remainPrice = data
        }
    },
    getters: {
        remains (state) {
            return state.remains
        },
        remain (state) {
            return state.remain
        },
        remainPrices (state) {
            return state.remainPrices
        },
        remainPrice (state) {
            return state.remainPrice
        }
    }
}
