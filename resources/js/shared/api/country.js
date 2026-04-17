export default function (instance) {
    return {
        getCountries(payload) {
            const data = instance
                .get('/api/system/geo/country/', {params: payload})
            return data
        },
        getCountry(countryId) {
            const data = instance
                .get(`/api/system/geo/country/${countryId}`)
            return data
        },
    }
}
