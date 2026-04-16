export default {
    state: {
        cities: {},
        city: {}
    },
    actions: {
        getCities ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.city.getCities(payload).then((response) => {
                commit('SET_CITIES', response.data)
            })
        },
        getCity ({ commit }, { cityId }) {
            return this.$app.config.globalProperties.$api.city.getCity(cityId).then((response) => {
                commit('SET_CITY', response.data)
            })
        }
    },
    mutations: {
        SET_CITY: (state, data) => {
            state.city = data
        },
        SET_CITIES: (state, data) => {
            state.cities = data
        }
    },
    getters: {
        cities (state) {
            return state.cities
        },
        city (state) {
            return state.city
        }
    }
}
