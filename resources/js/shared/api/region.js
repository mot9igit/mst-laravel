export default function (instance) {
    return {
        getRegions() {
            const data = instance
                .get('/api/system/geo/region/')
            return data
        },
        getRegion(regionId) {
            const data = instance
                .get(`/api/system/geo/region/${regionId}`)
            return data
        },
    }
}
