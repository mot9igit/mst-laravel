export default function (instance) {
    return {
        getCountries() {
            const data = instance
                .get('/api/system/geo/country/')
            return data
        },
        getCountry(countryId) {
            const data = instance
                .get(`/api/system/geo/country/${countryId}`)
            return data
        },
    }
}
