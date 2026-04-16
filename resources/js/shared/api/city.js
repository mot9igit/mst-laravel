export default function (instance) {
    return {
        getCities() {
            const data = instance
                .get('/api/system/geo/city/')
            return data
        },
        getCity(cityId) {
            const data = instance
                .get(`/api/system/geo/city/${cityId}`)
            return data
        },
    }
}
