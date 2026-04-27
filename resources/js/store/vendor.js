import Axios from 'axios'

export default {
    state: {
        vendors: {},
        vendor: {}
    },
    actions: {
        getVendors ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.vendor.getVendors(payload).then((response) => {
                commit('SET_VENDORS', response.data)
            })
        },
        getVendor ({ commit }, {vendorId}) {
            return this.$app.config.globalProperties.$api.vendor.getVendor(vendorId).then((response) => {
                commit('SET_VENDOR', response.data)
            })
        }
    },
    mutations: {
        SET_VENDORS: (state, data) => {
            state.vendors = data
        },
        SET_VENDOR: (state, data) => {
            state.vendor = data
        }
    },
    getters: {
        vendors (state) {
            return state.vendors
        },
        vendor (state) {
            return state.vendor
        }
    }
}
