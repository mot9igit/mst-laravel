export default {
    state: {
        countries: {},
        country: {}
    },
    actions: {
        getCountries ({ commit }, {filter, filtersdata, page, sort, perpage}) {
            const payload = {
                filter: filter,
                filtersdata: filtersdata,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.country.getCountries(payload).then((response) => {
                commit('SET_COUNTRIES', response.data)
            })
        },
        getCountry ({ commit }, { countryId }) {
            return this.$app.config.globalProperties.$api.country.getCountry(countryId).then((response) => {
                commit('SET_COUNTRY', response.data)
            })
        }
    },
    mutations: {
        SET_COUNTRY: (state, data) => {
            state.country = data
        },
        SET_COUNTRIES: (state, data) => {
            state.countries = data
        }
    },
    getters: {
        countries (state) {
            return state.countries
        },
        country (state) {
            return state.country
        }
    }
}
