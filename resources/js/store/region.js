export default {
    state: {
        regions: {},
        region: {}
    },
    actions: {
        getRegions ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.region.getRegions(payload).then((response) => {
                commit('SET_REGIONS', response.data)
            })
        },
        getRegion ({ commit }, { regionId }) {
            return this.$app.config.globalProperties.$api.region.getRegion(regionId).then((response) => {
                commit('SET_REGION', response.data)
            })
        }
    },
    mutations: {
        SET_REGION: (state, data) => {
            state.region = data
        },
        SET_REGIONS: (state, data) => {
            state.regions = data
        }
    },
    getters: {
        regions (state) {
            return state.regions
        },
        region (state) {
            return state.region
        }
    }
}
