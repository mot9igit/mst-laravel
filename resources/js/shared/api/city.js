export default function (instance) {
    return {
        getCities(payload) {
            const data = instance
                .get('/api/system/geo/city/', {params: payload})
            return data
        },
        getCity(cityId) {
            const data = instance
                .get(`/api/system/geo/city/${cityId}`)
            return data
        },
    }
}
