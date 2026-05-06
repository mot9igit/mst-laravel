export default {
    state: {
        remains: {},
        remain: {},
        remainPrices: {},
        remainPrice: {},
        remainHistories: {},
        remainHistory: {}
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
        },
        getRemainHistories ({ commit }, {storeId, remainId, filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.remain.getRemainHistories(storeId, remainId, payload).then((response) => {
                commit('SET_REMAIN_HISTORIES', response.data)
            })
        },
        getRemainHistory ({ commit }, {storeId, remainId, historyId}) {
            return this.$app.config.globalProperties.$api.remain.getRemainHistory(storeId, remainId, historyId).then((response) => {
                commit('SET_REMAIN_HISTORY', response.data)
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
        },
        SET_REMAIN_HISTORIES: (state, data) => {
            state.remainHistories = data
        },
        SET_REMAIN_HISTORY: (state, data) => {
            state.remainHistory = data
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
        },
        remainHistories (state) {
            return state.remainHistories
        },
        remainHistory (state) {
            return state.remainHistory
        }
    }
}
