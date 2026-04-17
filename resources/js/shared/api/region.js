export default function (instance) {
    return {
        getRegions(payload) {
            const data = instance
                .get('/api/system/geo/region/', {params: payload})
            return data
        },
        getRegion(regionId) {
            const data = instance
                .get(`/api/system/geo/region/${regionId}`)
            return data
        },
    }
}
